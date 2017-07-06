<?php

namespace App\Http\Controllers\Api;

use App\Models\MappingCharge;
use App\Models\MappingFee;
use App\Models\Charge;
use App\Models\Service;
use App\Models\AccountType;
use App\Models\Company;
use App\Models\Merchant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MappingChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mapping_charges = MappingCharge::paginate(15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('mapping_charges'), 200)
            : response()->view('pages.mapping_charge', compact('mapping_charges'), 200);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $charges = Charge::all();
        $services = Service::all();
        $account_types = AccountType::all();
        $companies = Company::all();
        $merchants = Merchant::all();

        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.mapping_charge-create', compact('charges', 'services', 'account_types', 'companies', 'merchants'), 200);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id'        => 'required|numeric',
            'charge_id'         => 'required|numeric',
            'account_type_id'   => 'required|numeric',
            'account_id'        => 'required|array|min:1',
            'account_id.*'      => 'required|numeric',
            'amount'            => 'required|numeric',
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to create charge mapping, please check invalid message below.')
                    ->withInput($request->all());
        }

        foreach ($request->input('account_id') as $account_id)
        {
            $mapping_charge = MappingCharge::firstOrNew([
                  'service_id' => $request->input('service_id')
                , 'charge_id' => $request->input('charge_id')
                , 'account_type_id' => $request->input('account_type_id')
                , 'account_id' => $account_id
            ], []);

            $mapping_charge->amount = $request->input('amount');

            $mapping_charge->save();
        }

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact(null), 201)
            : redirect()->back()
                ->with(compact(null))
                ->with('success', 'Charge mapping has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $mapping_charge = MappingCharge::findOrFail($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('mapping_charge'), 200)
            : response()->view('pages.mapping_charge-show', compact('mapping_charge'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $mapping_charge = MappingCharge::findOrFail($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.mapping_charge-edit', compact('mapping_charge'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to update charge mapping, please check invalid message below.')
                    ->withInput($request->all());
        }

        $mapping_charge = MappingCharge::findOrFail($id)->update($request->only(['amount']));

        abort_unless($mapping_charge, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('mapping_charge'), 204)
            : redirect()->back()
                ->with(compact('mapping_charge'))
                ->with('success', 'Charge mapping data was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $mapping_charge = MappingCharge::destroy($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Charge mapping data was deleted successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('mapping_charge.index');

        $mapping_charges = MappingCharge::whereHas('charge', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->orWhereHas('service', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->orWhereHas('account_type', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->orWhereHas('account', function ($query) use ($request) {
                $query->whereHas('companies', function ($query) use ($request) {
                    $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
                });
            })
            ->paginate(15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('mapping_charges'), 200)
            : response()->view('pages.mapping_charge', compact('mapping_charges'), 200);
    }
}
