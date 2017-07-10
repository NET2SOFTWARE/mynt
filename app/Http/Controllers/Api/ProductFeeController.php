<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductFee;
use App\Models\ProductCharge;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductFeeController extends Controller
{
    
    /**
     * Display all listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $rows = ProductCharge::paginate(20);

        return response()->view('pages.product-fee-all', compact('rows'), 200);
    }

    /**
     * Display a listing of the filter-sorted resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sortAll(Request $request)
    {
        $search = $request->input('search');

        if (is_null($search)) return redirect()->route('product.fee.all');

        $rows = ProductCharge::whereHas('product_sales', function($q) use ($search) {
            $q->whereHas('product_purchase', function($q) use ($search) {
                $q->whereHas('products', function($q) use ($search) {
                    $q->where('name', 'ILIKE', "%$search%");
                })->orWhereHas('companies', function($q) use ($search) {
                    $q->where('name', 'ILIKE', "%$search%");
                });
            })->orWhereHas('merchants', function($q) use ($search) {
                $q->where('name', 'ILIKE', "%$search%");
            });
        })->paginate(20);

        return response()->view('pages.product-fee-all', compact('rows'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int $product_id
     * @return \Illuminate\Http\Response
     */
    public function index(int $product_id)
    {
        $product = ProductCharge::find($product_id);
        $rows = ProductFee::where('product_charge_id', $product_id)->paginate(20);

        return response()->view('pages.product-fee', compact('product', 'rows'), 200);
    }

    /**
     * Display a listing of the filter-sorted resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $product_id
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request, int $product_id)
    {
        $search = $request->input('search');

        if (is_null($search)) return redirect()->route('product.fee.index');

        $rows = ProductFee::whereHas('accounts', function($q) use ($search) {
            $q->where(function($q) use ($search) {
                $q->whereHas('companies', function($q) use ($search) {
                    $q->where('name', 'ILIKE', "%$search%");
                })->orWhereHas('merchants', function($q) use ($search) {
                    $q->where('name', 'ILIKE', "%$search%");
                });
            })->orWhere('number', 'ILIKE', "%$search%");
        })->where('product_charge_id', $product_id)->paginate(20);

        return response()->view('pages.product-fee', compact('rows'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $product_id
     * @return \Illuminate\Http\Response
     */
    public function create(int $product_id)
    {
        $data = ProductCharge::find($product_id);
        $accounts = Account::whereIn('account_type_id', [3, 4])
            ->whereDoesntHave('product_fees', function($q) use ($product_id) {
                $q->where('product_charge_id', $product_id);
            })
            ->orderBy('number', 'asc')->get();

        return response()->view('pages.product-fee-create', compact('data', 'accounts'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $product_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $product_id)
    {
        foreach ($request->input('account_id') as $key => $account_id)
        {
            $data = ProductFee::create([
                'product_charge_id' => $product_id,
                'account_id' => $account_id,
                'fee' => $request->input('fee')[$key]
            ]);
        }

        if (! $data) return redirect()->back()->withInput($request->all())->with('warning', 'Fail to map product fee.');

        return redirect()->back()->with('success', 'Product fee has been mapped successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $product_id
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $product_id, int $id)
    {
        $data = ProductFee::find($id);
        $product = ProductCharge::find($product_id);
        $accounts = Account::all();

        return response()->view('pages.product-fee-edit', compact('data', 'product', 'accounts'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $product_id
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $product_id, int $id)
    {
        $data = ProductFee::where('id', $id)->update($request->only(['fee']));

        if (! $data) return redirect()->back()->withInput($request->all())->with('warning', 'Fail to edit product fee.');

        return redirect()->back()->with('success', 'Product fee has been edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $product_id
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $product_id, int $id)
    {
        $data = ProductFee::destroy($id);

        if (! $data) return redirect()->back()->with('warning', 'Fail to delete product fee.');

        return redirect()->back()->with('success', 'Product fee has been deleted successfully.');
    }
}
