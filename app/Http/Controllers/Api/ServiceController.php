<?php

namespace App\Http\Controllers\Api;

use SnappyPDF;
use Lava;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Contracts\ServiceInterface;
use App\Models\Service;
use App\Models\Company;
use App\Models\Merchant;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{

    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * ServiceController constructor.
     * @param ServiceInterface $service
     */
    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = $this->service->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('cities'), 200)
            : response()->view('pages.service', compact('services'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.service-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40|unique:services'
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to create service, please check invalid message below.')
                    ->withInput($request->all());
        }

        $service = $this->service->insert($this->service->attribute($request->only(['name'])));

        abort_unless($service, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('service'), 201)
            : redirect()->back()
                ->with(compact('service'))
                ->with('success', 'Service has added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $service = $this->service->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('service'), 200)
            : response()->view('pages.service-show', compact('service'), 200);
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
        $service = $this->service->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.service-edit', compact('service'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40|unique:services,name,' . $id
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to update service, please check invalid message below.')
                    ->withInput($request->all());
        }

        $service = $this->service->update($id, $request->only(['name']));

        abort_unless($service, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('service'), 204)
            : redirect()->back()
                ->with(compact('service'))
                ->with('success', 'Service data was updated successfully');
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
        $service = $this->service->delete($id);

        abort_unless($service, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Service data was updated successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('service.index');

        $services = Service::where('name', 'ILIKE', '%'.strtolower($request->input('search')).'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('services'), 200)
            : response()->view('pages.service', compact('services'), 200);
    }

    public function deactivatePage(Request $request)
    {
        $services = $this->service->getsPaginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('services'), 200)
            : response()->view('pages.service-deactivate', compact('services'), 200);
    }

    public function deactivateSort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('service.deactivate.sort');

        $services = service::where('name', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('services'), 200)
            : response()->view('pages.service-deactivate', compact('services'), 200);
    }

    public function deactivateProcess(Request $request, $id)
    {
        $service = service::find($id);

        $service->is_active = ! $service->is_active;

        $service->save();

        abort_unless($service, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('service'), 204)
            : redirect()->back()
                ->with(compact('service'))
                ->with('success', 'Service data was updated successfully.');
    }

    public function report(Request $request)
    {
        $data = [];

        return response()->view('pages.report-service', compact('data'), 200);
    }

    public function reportShow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'          => 'required|string|in:daily,ranged,monthly',
            'date'          => 'required_if:type,daily|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
            'date_from'     => 'required_if:type,ranged|date_format:m/d/Y|before:date_to',
            'date_to'       => 'required_if:type,ranged|date_format:m/d/Y|before_or_equal:' . date('m/d/Y'),
            'year'          => 'required_if:type,monthly|numeric|min:2017',
            'month'         => 'required_if:type,monthly|numeric|between:1,12',
        ]);

        if ($validator->fails()) return redirect('report.service.index')->withInput()->withErrors($validator);

        $data = [];

        $services = Service::with('transaction')->get();
        $companies = Company::get();
        $merchants = Merchant::get();

        $data['services'] = $services;
        $data['companies'] = $companies;
        $data['merchants'] = $merchants;
        $data['total_income'] = 0;
        $data['total_income_company'] = 0;
        $data['total_income_merchant'] = 0;

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

        $charges = Lava::DataTable();
        $charges->addStringColumn('Service')->addNumberColumn('Charge');

        foreach ($services as $service) $charges->addRow([$service->name, 0]);

        Lava::PieChart('Charge', $charges, [
            'title'  => 'Charge by service',
            // 'png' => true,
        ]);

        return response()->view('pages.report-service-show', compact('data'), 200);
    }
}
