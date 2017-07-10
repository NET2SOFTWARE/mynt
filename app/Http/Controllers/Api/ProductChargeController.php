<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductCharge;
use App\Models\ProductSales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = ProductSales::paginate(20);

        return response()->view('pages.product-charge', compact('rows'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $data = ProductSales::find($id);

        return response()->view('pages.product-charge-edit', compact('data'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $data = ProductCharge::firstOrNew(['product_sales_price_id' => $id]);
        $data->charge = $request->input('charge');
        $data->save();

        if (! $data) return redirect()->back()->withInput($request->all())->with('warning', 'Fail to edit product sales price.');

        return redirect()->back()->with('success', 'Product charge has been saved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $data = ProductCharge::destroy($id);

        if (! $data) return redirect()->back()->with('warning', 'Fail to delete product charge.');

        return redirect()->back()->with('success', 'Product charge has been deleted successfully.');
    }

    /**
     * Display a listing of the filter-sorted resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        $search = $request->input('search');

        if (is_null($search)) return redirect()->route('product.charge.index');

        $rows = ProductSales::whereHas('product_purchase', function($q) use ($search) {
                $q->whereHas('products', function($q) use ($search) {
                        $q->where('name', 'ILIKE', "%$search%");
                    })
                    ->orWhereHas('companies', function($q) use ($search) {
                        $q->where('name', 'ILIKE', "%$search%");
                    });
            })
            ->orWhereHas('merchants', function($q) use ($search) {
                $q->where('name', 'ILIKE', "%$search%");
            })
            ->paginate(20);

        return response()->view('pages.product-charge', compact('rows'), 200);
    }
}
