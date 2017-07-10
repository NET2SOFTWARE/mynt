<?php

namespace App\Http\Controllers\Api;

use App\Models\MappingCharge;
use App\Models\MappingFee;
use App\Models\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MappingFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $mapping_charges = MappingCharge::paginate(15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('mapping_charges'), 200)
            : response()->view('pages.mapping_fee-all', compact('mapping_charges'), 200);
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sortAll(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('mapping_fee.all');

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
            : response()->view('pages.mapping_fee-all', compact('mapping_charges'), 200);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $mapping_charge_id)
    {
        $mapping_charge = MappingCharge::find($mapping_charge_id);
        $mapping_fees = MappingFee::where('mapping_charge_id', $mapping_charge_id)->paginate(15);

        return response()->view('pages.mapping_fee', compact('mapping_charge', 'mapping_fees'), 200);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $mapping_charge_id)
    {
        $mapping_charge = MappingCharge::find($mapping_charge_id);
        $mapping_fees = MappingFee::where('mapping_charge_id', $mapping_charge_id)->get();

        $existing_accounts = [];
        foreach($mapping_fees as $account) $existing_accounts[] = $account->account_id;

        $accounts = Account::whereHas('account_type', function ($q) { $q->whereIn('id', [3,4]); })
        	->whereNotIn('id', $existing_accounts)
        	->get();

        return response()->view('pages.mapping_fee-create', compact('mapping_charge', 'mapping_fees', 'accounts'), 200);
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
            'mapping_charge_id' => 'required|numeric',
            'account_id'        => 'required|array',
            'account_id.*'      => 'required|numeric',
            'amount'            => 'required|array',
            'amount.*'          => 'required|numeric',
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to create fee mapping, please check invalid message below.')
                    ->withInput($request->all());
        }

        foreach ($request->input('account_id') as $key => $account_id) {
            $mapping_fee = MappingFee::firstOrNew([
                  'mapping_charge_id' => $request->input('mapping_charge_id')
                , 'account_id' => $account_id
            ], []);

            if (! is_null($mapping_fee->id))
            {
                return ($request->ajax() || $request->isJson())
                    ? abort(500, config('code.500'))
                    : redirect()->back()
                        ->with('warning', 'Fail to create fee mapping, selected fee receiver already exist in this fee sharing.')
                        ->withInput($request->all());
            }

            $remaining = MappingCharge::findOrFail($request->input('mapping_charge_id'))->amount;
            $existing_fee = MappingFee::where('mapping_charge_id', $request->input('mapping_charge_id'))->sum('amount');

            if ($remaining - ($existing_fee + $request->input('amount')[$key]) < 0)
            {
                return ($request->ajax() || $request->isJson())
                    ? abort(500, config('code.500'))
                    : redirect()->back()
                        ->with('warning', 'Fail to create fee mapping, overlimit fee sharing.')
                        ->withInput($request->all());
            }

            $mapping_fee->amount = $request->input('amount')[$key];
            $mapping_fee->save();
        }

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact(null), 201)
            : redirect()->back()
                ->with(compact(null))
                ->with('success', 'Fee mapping has been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $mapping_charge_id, $id)
    {
        $mapping_charge = MappingCharge::findOrFail($mapping_charge_id);
        $mapping_fees = MappingFee::where('mapping_charge_id', $mapping_charge_id)->where('id', '<>', $id)->get();
        $mapping_fee = MappingFee::findOrFail($id);

        $existing_accounts = [];
        foreach($mapping_fees as $account) $existing_accounts[] = $account->account_id;

        $accounts = Account::whereHas('account_type', function ($q) { $q->whereIn('id', [3,4]); })
        	->whereNotIn('id', $existing_accounts)
        	->get();

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.mapping_fee-edit', compact('mapping_charge', 'mapping_fees', 'accounts', 'mapping_fee'), 200);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'mapping_charge_id' => 'required|numeric',
            'account_id'        => 'required|numeric',
            'amount'            => 'required|numeric',
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to edit fee mapping, please check invalid message below.')
                    ->withInput($request->all());
        }

        $mapping_fee = MappingFee::firstOrNew([
              'mapping_charge_id' => $request->input('mapping_charge_id')
            , 'account_id' => $request->input('account_id')
        ], []);

        $remaining = MappingCharge::findOrFail($request->input('mapping_charge_id'))->amount;
        $existing_fee = MappingFee::where('mapping_charge_id', $request->input('mapping_charge_id'))->where('id', '<>', $id)->sum('amount');

        if ($remaining - ($existing_fee + $request->input('amount')) < 0)
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->with('warning', 'Fail to edit fee mapping, overlimit fee sharing.')
                    ->withInput($request->all());
        }

        $mapping_fee->amount = $request->input('amount');
        $mapping_fee->save();

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact(null), 201)
            : redirect()->back()
                ->with(compact(null))
                ->with('success', 'Fee mapping has been added successfully.');
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
        $mapping_fee = MappingFee::destroy($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Fee mapping data was deleted successfully');
    }
}
