<?php

namespace App\Http\Controllers\Api;

use DB;
use SnappyPDF;
use Lava;
use Khill\Lavacharts\Lavacharts;
use App\Models\Company;
use App\Models\Bank;
use App\Models\Product;
use App\Models\Location;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\Account;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\Confirmation;
use App\Contracts\UserInterface;
use App\Contracts\AccountInterface;
use App\Contracts\CompanyInterface;
use App\Http\Controllers\Controller;
use App\Contracts\IndustryInterface;
use Intervention\Image\Facades\Image;
use App\Http\Requests\CompanyRequest;
use App\Contracts\PartnershipInterface;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * @var CompanyInterface
     */
    private $company;

    /**
     * @var IndustryInterface
     */
    private $industry;

    private $partnership;

    private $productImageName;

    private $user;

    private $account;

    private $confirmation;

    /**
     * CompanyController constructor.
     * @param CompanyInterface $company
     * @param IndustryInterface $industry
     * @param PartnershipInterface $partnership
     * @param UserInterface $user
     * @param AccountInterface $account
     * @param Confirmation $confirmation
     */
    public function __construct(
        CompanyInterface        $company,
        IndustryInterface       $industry,
        PartnershipInterface    $partnership,
        UserInterface           $user,
        AccountInterface        $account,
        Confirmation            $confirmation
    )
    {
        $this->company              = $company;
        $this->industry             = $industry;
        $this->partnership          = $partnership;
        $this->productImageName     = '';
        $this->user                 = $user;
        $this->account              = $account;
        $this->confirmation         = $confirmation;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $param
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $param = NULL)
    {
        $companies = Company::paginate(20, ['*']);

        switch ($param) {
            case 'document' :
                $page = 'pages.company-document';
                break;
            case 'deactivate' :
                $page = 'pages.company-deactivate';
                break;
            case 'transactions' :
                $page = 'pages.company-transactions';
                break;
            default :
                $page = 'pages.company';
                break;
        }

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('companies'), 200)
            : response()->view($page, compact('companies'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function transactions($id, Request $request)
    {
        $company = Company::find($id, ['*']);
        
        $transactions = Transaction::whereHas('accounts', function ($query) use ($id) {
                $query->whereHas('companies', function ($query) use ($id) {
                    $query->where('companies.id', '=', $id);
                });
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('company', 'transactions'), 200)
            : response()->view('pages.company-detail-transactions', compact('company', 'transactions'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function members($id, Request $request)
    {
        $company = Company::find($id);
        $accounts = Account::where('account_type_id', '<>', 3)
            ->whereHas('members', function($query) use ($id) {
                $query->whereHas('companies', function($query) use ($id) {
                    $query->where('companies.id', '=', $id);
                });
            })
            ->orWhereHas('merchants', function($query) use ($id) {
                $query->whereHas('companies', function($query) use ($id) {
                    $query->where('companies.id', '=', $id);
                });
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('company'), 200)
            : response()->view('pages.company-members', compact('company', 'accounts'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $industries = $this->industry->gets(['id', 'name']);
        $partnerships = $this->partnership->gets(['id', 'name']);

        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.company-create', compact('industries', 'partnerships'), 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:40',
            'brand'             => 'nullable|string|max:100',
            'email'             => 'required|email|unique:companies',
            'website'           => 'nullable|max:40',
            'photo'             => 'nullable|image|mimes:jpeg,jpg,png,bmp,gif',
            'phone'             => 'required|numeric|digits_between:6,16',
            'industry_id'       => 'required',
            'password'          => 'required|string|min:6|confirmed',
            'code'              => 'required|numeric|digits:3|unique:companies',
            'partnership_id'    => 'required'
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()->withErrors($validator)->with('warning', 'Fail to create company, please check invalid message below.')->withInput($request->all());
        }

        $logoName = '';

        if ($request->hasFile('logo') && $request->file('logo')->isValid())
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 120);

            $photo = $request->file('logo');
            $name  = time() . '.' . $photo->getClientOriginalExtension();

            Image::make($photo->getRealPath())->resize(160, 160, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save('img/product/'. $name);

            $logoName = $name;
        }

        $company = $this->company->save([
            'code'          => $request->input('code'),
            'name'          => $request->input('name'),
            'brand'         => $request->input('brand'),
            'email'         => $request->input('email'),
            'website'       => $request->input('website'),
            'phone'         => str_is('0*', $request->input('phone')) ? '62'. substr($request->input('phone'), 1) : $request->input('phone'),
            'industry_id'   => $request->input('industry_id'),
            'image'         => (is_null($logoName) || $logoName == '') ? 'company.jpg' : $logoName
        ]);

        if (!$company)
            return ($request->ajax() || $request->isJson())
                ? response()->json(compact('company'), 200)
                : redirect()->back()->with('warning', 'System error, please try again later.')->withInput($request->all());


        $user = $this->user->save([
            'name'          => $request->input('name'),
            'email'         => $request->input('email'),
            'phone'         => str_is('0*', $request->input('phone')) ? '62'. substr($request->input('phone'), 1) : $request->input('phone'),
            'password'      => bcrypt($request->input('password')),
            'isConfirmed'   => true
        ]);

        if (!$user) {
            $company->forceDelete();
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()->with('warning', 'System can not create user of company, please try again later.')->withInput($request->all());
        }


        $account = $this->account->save([
            'number'                    => $company->code . date('y'),
            'account_type_id'           => 3,
            'mynt_id'                   => null,
            'limit_balance'             => 25000000,
            'limit_balance_transaction' => 50000000,
        ]);

        if (!$account) {
            $company->forceDelete();
            $user->forceDelete();
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()->with('warning', 'System can not create company`s account, please try again later.')->withInput($request->all());
        }

        $user->roles()->attach(6);

        $company->partnerships()->sync($request->input('partnership_id'));

        $company->accounts()->attach($account->id);

        $company->users()->attach($user->id);

        $this->confirmation->sendConfirmationMail($user);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('company'), 201)
            : redirect()->back()
                ->with(compact('company'))
                ->with('success', 'Company has added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $company = Company::find($id, ['*']);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('merchant'), 200)
            : response()->view('pages.company-show', compact('company'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $company = Company::find($id, ['*']);
        $industries = $this->industry->gets(['id', 'name']);
        $partnerships = $this->partnership->gets(['id', 'name']);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.company-edit', compact('company', 'industries', 'partnerships'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:40',
            'brand'             => 'nullable|string|max:100',
            'email'             => 'required|email|unique:companies,email,'.$id,
            'website'           => 'nullable|max:40',
            'photo'             => 'nullable|image|mimes:jpeg,jpg,png,bmp,gif',
            'phone'             => 'required|numeric|digits_between:6,16',
            'industry_id'       => 'required',
            'password'          => 'required|string|min:6|confirmed',
            'code'              => 'required|numeric|digits:3|unique:companies,code,'.$id,
            'partnership_id'    => 'required'
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()->withErrors($validator)->with('warning', 'Fail to update company, please check invalid message below.')->withInput($request->all());
        }

        $company = Company::findOrFail($id, ['*']);

        $company->update($request->only([
              'name'
            , 'brand'
            , 'email'
            , 'website'
            , 'phone'
            , 'industry_id'
            , 'password'
            , 'code'
            , 'partnership_id'
        ]));

        $company->partnerships()->sync($request->input('partnership_id'));

        abort_unless($company, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('company'), 204)
            : redirect()->back()
                ->with(compact('company'))
                ->with('message', 'Company data was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $company = Company::find($id)->delete();

        abort_unless($company, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Company data was updated successfully');
    }

    public function saveLocation($companyId, Request $request)
    {
        Validator::make($request->all(), [
            'street'    => 'required',
            'city_id'   => 'required',
            'zip_code'  => 'required'
        ]);

        $location = new Location;

        $location->street       = $request->input('street');
        $location->city_id      = $request->input('city_id');
        $location->zip_code     = $request->input('zip_code');

        $location->save();

        if (!$location)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Location data can not be added.');

        $location->companies()->attach($companyId);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function saveBank($idCompany, Request $request)
    {
        Validator::make($request->all(), [
            'bank_code'             => 'required',
            'bank_name'             => 'required',
            'bank_account_number'   => 'required'
        ]);

        $banks = new Bank;

        $banks->bank_code = $request->input('bank_code');
        $banks->bank_name = $request->input('bank_name');
        $banks->bank_account_number = $request->input('bank_account_number');

        $banks->save();

        if (!$banks)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Bank data can not be added');

        $banks->companies()->attach($idCompany);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function saveProduct($idCompany, Request $request)
    {
        Validator::make($request->all(), [
            'name'          => 'required',
            'photo'         => 'required',
            'price'         => 'required',
            'description'   => 'max:120'
        ]);

        if ($request->hasFile('photo') && $request->file('photo')->isValid())
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 120);

            $photo = $request->file('photo');
            $this->productImageName  = time() . '.' . $photo->getClientOriginalExtension();

            Image::make($photo->getRealPath())->resize(160, 160, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save('img/product/'. $this->productImageName);
        }

        $product = new Product;

        $product->name  = $request->input('name');
        $product->photo = ($this->productImageName == '') ? 'product.jpg' : $this->productImageName;
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();

        if (!$product)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Bank data can not be added');

        $product->companies()->attach($idCompany);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function deactivate($id, Request $request)
    {
        $company_users = Company::findOrFail($id)->users()->withTrashed()->get();

        foreach ($company_users as $user)
        {
            if ($user->deleted_at == null)
            {
                $user->delete();
            } else {
                $user->restore();
            }
        }

        abort_unless($company_users, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Company data was updated successfully');
    }

    /**
     * API for check referral code availibility
     * 
     * @param  string  $code
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkCodeAvalibility($code = null, Request $request)
    {
        $status = ($code !== null);

        $company = Company::where('code', '=', $code);
        if ($request->input('id') !== null) $company->where('id', '<>', $request->input('id'));

        $status = ! $status ? $status : (count($company->get()) < 1);

        return ($request->ajax() || $request->isJson())
            ? response()->json(['status' => $status], 200)
            : abort(404);
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search')))
        {
            if (! is_null($request->input('route'))) return redirect()->route($request->input('route'));
            if (! is_null($request->input('extra'))) return redirect()->route('company.index', [$request->input('extra')]);
        }

        $page = is_null($request->input('page')) ? 'pages.company' : $request->input('page');

        $companies = Company::where('name', 'ILIKE', '%'.$request->input('search').'%')
            ->orWhere('code', 'ILIKE', '%'.$request->input('search').'%')
            ->orWhereHas('accounts', function ($query) use ($request) {
                $query->where('number', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->orWhereHas('industry', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->orWhereHas('partnerships', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('companies'), 200)
            : response()->view($page, compact('companies'), 200);
    }

    /**
     * Display sorted listing of company transactions
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sortTransactions($id, Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('company.transactions', $id);

        $company = Company::find($id, ['*']);
        
        $transactions = Transaction::whereHas('accounts', function ($query) use ($id) {
                $query->whereHas('companies', function ($query) use ($id) {
                    $query->where('companies.id', '=', $id);
                });
            })
            ->orWhere(DB::raw('trx_id::TEXT'), 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('sender_account_number', 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('receiver_account_number', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('company', 'transactions'), 200)
            : response()->view('pages.company-detail-transactions', compact('company', 'transactions'), 200);
    }

    /**
     * Display sorted listing of company transactions
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sortMembers($id, Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('company.members', $id);

        $company = Company::find($id);
        $accounts = Account::where('account_type_id', '<>', 3)
            ->whereHas('members', function($query) use ($id, $request) {
                $query->whereHas('companies', function($query) use ($id) {
                        $query->where('companies.id', '=', $id);
                    })
                    ->where(function($query) use ($request) {
                        $query->where('name', 'ILIKE', '%'.$request->input('search').'%')
                            ->orWhere('email', 'ILIKE', '%'.$request->input('search').'%')
                            ->orWhere('phone', 'ILIKE', '%'.$request->input('search').'%');
                    });
            })
            ->orWhereHas('merchants', function($query) use ($id, $request) {
                $query->whereHas('companies', function($query) use ($id) {
                        $query->where('companies.id', '=', $id);
                    })
                    ->where(function($query) use ($request) {
                        $query->where('name', 'ILIKE', '%'.$request->input('search').'%')
                            ->orWhere('email', 'ILIKE', '%'.$request->input('search').'%')
                            ->orWhere('phone', 'ILIKE', '%'.$request->input('search').'%');
                    });
            })
            ->orWhere(function($query) use ($request){
                $query->where('number', 'LIKE', '%'.$request->input('search').'%');
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('company', 'accounts'), 200)
            : response()->view('pages.company-members', compact('company', 'accounts'), 200);
    }

    public function report(Request $request)
    {
        $companies = Company::all();

        return response()->view('pages.report-company', compact('companies'), 200);   
    }

    // public function reportShow(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'company_id'    => 'required|numeric|exists:companies,id',
    //         'type'          => 'required|string|in:daily,ranged,monthly',
    //         'date'          => 'required_if:type,daily|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
    //         'date_from'     => 'required_if:type,ranged|date_format:m/d/Y|before:date_to',
    //         'date_to'       => 'required_if:type,ranged|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
    //         'year'          => 'required_if:type,monthly|numeric|min:2017',
    //         'month'         => 'required_if:type,monthly|numeric|between:1,12',
    //     ]);

    //     if ($validator->fails()) return redirect()->route('report.company.index')->withInput()->withErrors($validator);

    //     $charts = [];
    //     $data = [];

    //     $company = Company::find($request->input('company_id'));
    //     $services = Service::with('transaction')->get();

    //     $data['count_member'] = $company->members->count();
    //     $data['count_merchant'] = $company->merchants->count();
    //     $data['count_account'] = $data['count_member'] + $data['count_merchant'];
    //     $data['services'] = $services->pluck('name')->toArray();

    //     for ($i=0; $i < 4; $i++) { 
    //         $charts[] = app()->chartjs
    //             ->name('pieChartTest'.$i)
    //             ->type('pie')
    //             ->size(['width' => 400, 'height' => 200])
    //             ->labels(['Label x', 'Label y'])
    //             ->datasets([
    //                 [
    //                     'backgroundColor' => ['#FF6384', '#36A2EB'],
    //                     'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
    //                     'data' => [69, 59]
    //                 ]
    //             ])
    //             ->options([]);
    //     }

    //     $charts['accounts'] = app()->chartjs
    //         ->name('accounts')
    //         ->type('pie')
    //         ->size(['width' => 400, 'height' => 200])
    //         ->labels(['Member', 'Merchant'])
    //         ->datasets([
    //             [
    //                 'backgroundColor' => ['#1976d2', '#009688'],
    //                 'hoverBackgroundColor' => ['#82b1ff', '#4db6ac'],
    //                 'data' => [
    //                     null, // $data['count_merchant'],
    //                     null, // $data['count_member'],
    //                 ]
    //             ]
    //         ])
    //         ->options([]);

    //     $charts['closedAccounts'] = app()->chartjs
    //         ->name('closedAccounts')
    //         ->type('pie')
    //         ->size(['width' => 400, 'height' => 200])
    //         ->labels(['All', 'Closed'])
    //         ->datasets([
    //             [
    //                 'backgroundColor' => ['#1976d2', '#f44336'],
    //                 'hoverBackgroundColor' => ['#82b1ff', '#e57373'],
    //                 'data' => [
    //                     $data['count_account'],
    //                     0,
    //                 ]
    //             ]
    //         ])
    //         ->options([]);

    //     $charts['transactions'] = app()->chartjs
    //         ->name('transactions')
    //         ->type('pie')
    //         ->size(['width' => 380, 'height' => 300])
    //         ->labels($data['services'])
    //         ->datasets([
    //             [
    //                 // 'backgroundColor' => [
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 // ],
    //                 // 'hoverBackgroundColor' => [
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 //     '#000',
    //                 // ],
    //                 // 'backgroundColor' => ['#1976d2', '#f44336'],
    //                 // 'hoverBackgroundColor' => ['#82b1ff', '#e57373'],
    //                 'data' => [
    //                     10,
    //                     0,
    //                     0,
    //                     0,
    //                     0,
    //                     0,
    //                     0,
    //                     0,
    //                     0,
    //                     0,
    //                 ]
    //             ]
    //         ])
    //         ->options([]);

    //     $charts['transactionsAmount'] = app()->chartjs
    //         ->name('transactionsAmount')
    //         ->type('pie')
    //         ->size(['width' => 400, 'height' => 200])
    //         ->labels(['All', 'Closed'])
    //         ->datasets([
    //             [
    //                 'backgroundColor' => ['#1976d2', '#f44336'],
    //                 'hoverBackgroundColor' => ['#82b1ff', '#e57373'],
    //                 'data' => [
    //                     $data['count_account'],
    //                     0,
    //                 ]
    //             ]
    //         ])
    //         ->options([]);

    //     return response()->view('pages.report-company-show', compact('data', 'charts'), 200);
    // }

    public function reportShow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id'    => 'required|numeric|exists:companies,id',
            'type'          => 'required|string|in:daily,ranged,monthly',
            'date'          => 'required_if:type,daily|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
            'date_from'     => 'required_if:type,ranged|date_format:m/d/Y|before:date_to',
            'date_to'       => 'required_if:type,ranged|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
            'year'          => 'required_if:type,monthly|numeric|min:2017',
            'month'         => 'required_if:type,monthly|numeric|between:1,12',
        ]);

        if ($validator->fails()) return redirect()->route('report.company.index')->withInput()->withErrors($validator);

        $data = [];

        $company = Company::find($request->input('company_id'));
        $services = Service::with('transaction')->get();

        $data['company'] = $company;
        $data['services'] = $services;
        $data['count_member'] = $company->members->count();
        $data['count_merchant'] = $company->merchants->count();
        $data['count_account'] = $data['count_member'] + $data['count_merchant'];
        $data['total_income'] = 0;
        $data['total_income_company'] = 0;

        $accounts = Lava::DataTable();
        $accounts->addStringColumn('Type')
            ->addNumberColumn('Counts')
            ->addRow(['Member', $data['count_member']])
            ->addRow(['Merchant', $data['count_merchant']]);
            
        Lava::PieChart('Accounts', $accounts, [
            'title'  => 'Accounts belongs to this company',
            // 'png' => true,
        ]);

        $closedAccounts = Lava::DataTable();
        $closedAccounts->addStringColumn('Type')
            ->addNumberColumn('Count')
            ->addRow(['Active', $data['count_account']])
            ->addRow(['Closed', 0]);

        Lava::PieChart('ClosedAccounts', $closedAccounts, [
            'title'  => 'Accounts closed that belongs to this company',
            // 'png' => true,
        ]);

        $transactions = Lava::DataTable();
        $transactions->addStringColumn('Service')->addNumberColumn('Count');

        foreach ($services as $service) $transactions->addRow([$service->name, $service->transaction->count()]);

        Lava::PieChart('Transactions', $transactions, [
            'title'  => 'Transaction count by service',
            // 'png' => true,
        ]);

        $transactionsAmount = Lava::DataTable();
        $transactionsAmount->addStringColumn('Service')->addNumberColumn('Amount');

        foreach ($services as $service) $transactionsAmount->addRow([$service->name, $service->transaction->sum('amount')]);

        Lava::PieChart('TransactionsAmount', $transactionsAmount, [
            'title'  => 'Transaction amount by service',
            // 'png' => true,
        ]);

        return response()->view('pages.report-company-show', compact('request', 'data'), 200);
    }

    public function reportPrint(Request $request)
    {
        $charts = [];
        $data = [];

        $company = Company::find($request->input('company_id'));
        $services = Service::with('transaction')->get();

        $data['count_member'] = $company->members->count();
        $data['count_merchant'] = $company->merchants->count();
        $data['count_account'] = $data['count_member'] + $data['count_merchant'];
        $data['services'] = $services->pluck('name')->toArray();

        $accounts = Lava::DataTable();
        $accounts->addStringColumn('Types')->addNumberColumn('Counts')
            ->addRow(['Member', $data['count_member']])
            ->addRow(['Merchant', $data['count_merchant']]);
        Lava::PieChart('Accounts', $accounts, [
            'title'  => 'Accounts belongs to this company',
            'png' => true,
        ]);

        $pdf = SnappyPDF::loadView('pages.report-company-show', compact('request', 'data'));

        return $pdf->download('report.pdf');
    }
}
