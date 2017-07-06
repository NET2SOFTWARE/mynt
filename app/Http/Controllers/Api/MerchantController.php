<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Bank;
use App\Models\City;
use App\Models\Company;
use App\Models\Location;
use App\Models\Merchant;
use App\Models\Pic;
use App\Models\Position;
use App\Models\Product;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Services\Confirmation;
use Illuminate\Http\Request;
use App\Contracts\UserInterface;
use App\Contracts\AccountInterface;
use App\Contracts\CompanyInterface;
use App\Http\Controllers\Controller;
use App\Contracts\MerchantInterface;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Http\Requests\MerchantRequest;


/**
 * Class MerchantController
 * @package App\Http\Controllers\Api
 */
class MerchantController extends Controller
{

    /**
     * @var MerchantInterface
     */
    private $merchant;

    /**
     * @var CompanyInterface
     */
    private $company;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var
     */
    private $account;

    /**
     * @var
     */
    private $referral;

    /**
     * @var
     */
    private $photoName;

    /**
     * @var
     */
    private $confirmation;

    /**
     * MerchantController constructor.
     * @param MerchantInterface $merchant
     * @param CompanyInterface $company
     * @param UserInterface $user
     * @param AccountInterface $account
     * @param Confirmation $confirmation
     */
    public function __construct(
        MerchantInterface   $merchant,
        CompanyInterface    $company,
        UserInterface       $user,
        AccountInterface    $account,
        Confirmation        $confirmation
    )
    {
        $this->merchant     = $merchant;
        $this->company      = $company;
        $this->user         = $user;
        $this->account      = $account;
        $this->confirmation = $confirmation;
        $this->photoName    = '';
    }

    public function index()
    {
        $merchants = Merchant::paginate(20, ['*']);

        return response()->view('pages.merchant', compact('merchants'), 200);
    }

    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('merchant.index');

        $merchants = Merchant::where('name', 'like', '%'. $request->input('search') .'%')
            ->orWhere('email', 'like', '%'. $request->input('search') .'%')
            ->orWhere('phone', 'like', '%'. $request->input('search') .'%')
            ->paginate(20);

        return response()->view('pages.merchant', compact('merchants'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companies  = $this->company->gets(['id', 'name']);

        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.merchant-create', compact('companies'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\MerchantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MerchantRequest $request)
    {
        if ($request->hasFile('photo') && $request->file('photo')->isValid())
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 120);

            $photo = $request->file('photo');
            $this->photoName  = time() . '.' . $photo->getClientOriginalExtension();

            Image::make($photo->getRealPath())->resize(160, 160, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save('img/merchant/'. $this->photoName);
        }

        $merchant = $this->merchant->save([
            'name'                  => $request->input('name'),
            'brand'                 => $request->input('brand'),
            'phone'                 => str_is('0*', $request->input('phone')) ? '62'. substr($request->input('phone'), 1) : $request->input('phone'),
            'email'                 => $request->input('email'),
            'website'               => $request->input('website'),
            'account_type'          => $request->input('merchant.type'),
            'photo'                 => (is_null($this->photoName)) ? 'merchant.jpg' : $this->photoName
        ]);


        if (!$merchant)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error, please try again later.');

        if ($request->has('merchant.company')) {
            $merchant->companies()->attach($request->input('merchant.company'));
        } else {
            $merchant->companies()->attach(1);
        }

        $user = $this->user->save([
            'name'          => $request->input('name'),
            'email'         => $request->input('email'),
            'phone'         => str_is('0*', $request->input('phone')) ? '62'. substr($request->input('phone'), 1) : $request->input('phone'),
            'password'      => bcrypt($request->input('password')),
            'isConfirmed'   => true,
        ]);

        if (!$user) {
            $merchant->delete();
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Internal system error, please try again later.');
        }

        $user->merchants()->attach($merchant->id);


        if (is_null($request->input('merchant.company'))) {
            $this->referral = '000';
        } else {
            $company = $this->company->get($request->input('merchant.company'));

            if (is_null($company)) {
                $user->merchant()->detach($merchant->id);
                $user->forceDelete($user->id);
                $merchant->forceDelete($merchant->id);
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->with('warning', 'Internal system error, system can not create referral company please try again later.');
            }

            $this->referral = $company->code;
        }

        $account = $this->account->save([
            'number'                    => $this->referral . date('y'),
            'account_type_id'           => 4,
            'mynt_id'                   => null,
            'limit_balance'             => 50000000,
            'limit_balance_transaction' => 150000000,
        ]);

        if (!$account) {
            $user->merchant()->detach($merchant->id);
            $user->forceDelete($user->id);
            $merchant->forceDelete($merchant->id);
            return redirect()
                ->back()
                ->with('warning', 'Internal system error, system can not create account merchant please try again later.');
        }

        $merchant->accounts()->attach($account->id);

        $user->roles()->attach(5);

        $this->confirmation->sendConfirmationMail($user);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('merchant'), 201)
            : redirect()->back()
                ->with(compact('merchant'))
                ->with('success', 'Merchant has added successfully.');
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
        # $merchant = $this->merchant->get($id);
        $merchant = Merchant::find($id, ['*']);

        $cities = City::all(['id', 'name']);

        $positions = Position::all();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('merchant'), 200)
            : response()->view('pages.merchant-show', compact('merchant', 'cities', 'positions'), 200);
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
        # $merchant = $this->merchant->get($id);
        $merchant = Merchant::find($id, ['*']);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.merchant-edit', compact('merchant'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MerchantRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(MerchantRequest $request, $id)
    {
        $merchant = Merchant::withTrashed()::find($id);

        $merchant->update(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'brand' => $request->input('brand'),
                'phone' => str_is('0*', $request->input('phone')) ? '62'. substr($request->input('phone'), 1) : $request->input('phone'),
            ]
        );

        if (!$merchant)
            ($request->ajax() || $request->isJson())
                ? response()->json(['status' => false, 'code' => '17', 'text' => 'System error', 'data' => null], 204)
                : redirect()->back()
                    ->with(compact('merchant'))
                    ->with('message', 'Proses error');

        abort_unless($merchant, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('merchant'), 204)
            : redirect()->back()
                ->with(compact('merchant'))
                ->with('message', 'Merchant data was updated successfully');
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
        # $merchant = $this->merchant->delete($id);
        $merchant = Merchant::findOrFail($id)->delete();

        abort_unless($merchant, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Merchant was deleted successfully');
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
        $merchant = Merchant::find($id, ['*']);
        
        $transactions = Transaction::whereHas('accounts', function ($query) use ($id) {
                $query->whereHas('merchants', function ($query) use ($id) {
                    $query->where('merchants.id', '=', $id);
                });
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('merchant', 'transactions'), 200)
            : response()->view('pages.merchant-detail-transactions', compact('merchant', 'transactions'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function group(Request $request)
    {
        $merchant = $this->merchant->merchantGroup();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('merchant'), 200)
            : response()->view('pages.merchant-group', compact('merchant'), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function individual(Request $request)
    {
        $merchant = $this->merchant->merchantIndividual();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('merchant'), 200)
            : response()->view('pages.merchant-individual', compact('merchant'), 200);
    }

    public function saveBank($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'bank_name'             => 'required',
            'bank_code'             => 'required',
            'bank_account_number'   => 'required'
        ]);

        $bank = new Bank;

        $bank->bank_code            = $request->input('bank_code');
        $bank->bank_name            = $request->input('bank_name');
        $bank->bank_account_number  = $request->input('bank_account_number');

        $bank->save();

        if (!$bank)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Bank data can not be added.');

        $bank->merchants()->attach($merchantId);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function saveLocation($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'street'            => 'required',
            'zip_code'          => 'required',
            'city_id'           => 'required'
        ]);

        $location = new Location;

        $location->street = $request->input('street');
        $location->zip_code = $request->input('zip_code');
        $location->city_id = $request->input('city_id');

        $location->save();

        if (!$location)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Location data can not be added.');

        $location->merchants()->attach($merchantId);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function saveTerminal($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'code'            => 'required',
        ]);

        $terminal = new Terminal;

        $terminal->code = $request->input('code');

        $terminal->save();

        if (!$terminal)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Terminal data can not be added.');

        $terminal->merchants()->attach($merchantId);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function savePic($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'name'              => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'position_id'       => 'required',
        ]);

        $pic = new Pic;

        $pic->name  = $request->input('name');
        $pic->email  = $request->input('email');
        $pic->phone  = $request->input('phone');
        $pic->position_id  = $request->input('position_id');

        $pic->save();

        if (!$pic)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'PIC data can not be added.');

        $pic->merchants()->attach($merchantId);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function saveProduct($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'name'              => 'required',
            'photo'             => 'required',
            'price'             => 'required',
            'description'       => 'required'
        ]);

        if ($request->hasFile('photo') && $request->file('photo')->isValid())
        {
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 120);

            $photo = $request->file('photo');
            $this->photoName  = time() . '.' . $photo->getClientOriginalExtension();

            Image::make($photo->getRealPath())->resize(160, 160, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save('img/product/'. $this->photoName);
        }

        $product = new Product;

        $product->name  = $request->input('name');
        $product->photo  = ($this->photoName == '') ? 'product.jpg' : $this->photoName;
        $product->price  = $request->input('price');
        $product->description  = $request->input('description');

        $product->save();

        if (!$product)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Product data can not be added.');

        $product->merchants()->attach($merchantId);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function updateAccount($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'mynt_id'              => 'required'
        ]);

        $merchant = Merchant::find($merchantId);

        $merchant->accounts()->update([
            'mynt_id' => $request->input('mynt_id')
        ]);

        if (!$merchant)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Process update error');

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function changeImage($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'image_photo'   => 'required|image|mimes:jpeg,bmp,png,jpg,gif'
        ]);

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 120);

        $photo = $request->file('photo');
        $name  = time() . '.' . $photo->getClientOriginalExtension();

        Image::make($photo->getRealPath())->resize(160, 160, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        })->save('img/merchant/'. $this->$name);

        $merchant = Merchant::find($merchantId);

        $merchant->update(
            [
                'photo' => $name
            ]
        );

        if (!$merchant)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Process update error');

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    public function savePicLocation($merchantId, Request $request)
    {
        Validator::make($request->all(), [
            'street'            => 'required',
            'zip_code'          => 'required',
            'city_id'           => 'required'
        ]);

        $location = new Location;

        $location->street = $request->input('street');
        $location->zip_code = $request->input('zip_code');
        $location->city_id = $request->input('city_id');

        $location->save();

        if (!$location)
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', 'Location data can not be added.');

        $merchant = Merchant::find($merchantId);

        $pic = $merchant->pics()->first();

        $pic->locations()->attach($location->id);

        return redirect()
            ->back()
            ->with('success', 'Process success.');
    }

    /**
     * Display merchant deactivate page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deactivate_page(Request $request)
    {
        $merchants = Merchant::paginate(20, ['*']);

        return response()->view('pages.merchant-deactivate', compact('merchants'), 200);
    }

    /**
     * Display merchant transactions page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function transactions_page(Request $request)
    {
        $merchants = Merchant::paginate(20, ['*']);

        return response()->view('pages.merchant-transactions', compact('merchants'), 200);
    }

    /**
     * Toggle merchant status (active, inactive)
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id, Request $request)
    {
        $merchant_users = Merchant::findOrFail($id)->users()->withTrashed()->get();

        foreach ($merchant_users as $user)
        {
            if ($user->deleted_at == null)
            {
                $user->delete();
            } else {
                $user->restore();
            }
        }

        abort_unless($merchant_users, config('code.500'));

        return redirect()
            ->back()
            ->with('success', 'Merchant was updated successfully');
    }

    /**
     * Display sorted listing for merchant transactions
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sortTransactions(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('merchant.transactions.index');

        $merchants = Merchant::where('name', 'like', '%'. $request->input('search') .'%')
            ->paginate(20);

        return response()->view('pages.merchant-transactions', compact('merchants'), 200);
    }

    /**
     * Display sorted listing for merchant deactivate
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sortDeactivate(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('merchant.deactivate.index');

        $merchants = Merchant::where('name', 'like', '%'. $request->input('search') .'%')
            ->orWhere('email', 'like', '%'. $request->input('search') .'%')
            ->orWhere('phone', 'like', '%'. $request->input('search') .'%')
            ->paginate(20);

        return response()->view('pages.merchant-deactivate', compact('merchants'), 200);
    }

    /**
     * Display sorted listing of company transactions
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sortDetailTransactions($id, Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('merchant.transactions', $id);

        $merchant = Merchant::find($id, ['*']);
        
        $transactions = Transaction::whereHas('accounts', function ($query) use ($id) {
                $query->whereHas('merchants', function ($query) use ($id) {
                    $query->where('merchants.id', '=', $id);
                });
            })
            ->orWhere(DB::raw('trx_id::TEXT'), 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('sender_account_number', 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('receiver_account_number', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('merchant', 'transactions'), 200)
            : response()->view('pages.merchant-detail-transactions', compact('merchant', 'transactions'), 200);
    }

}
