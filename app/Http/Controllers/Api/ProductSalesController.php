<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductSales;
use App\Models\ProductPurchase;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = ProductSales::paginate(20);

        return response()->view('pages.product-sales', compact('rows'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = ProductPurchase::all();
        $merchants = Merchant::all();

        return response()->view('pages.product-sales-create', compact('products', 'merchants'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            /**
             * Business logic validation:
             *
             * Merchant can only sells a particular product from 1 supplier.
             * If the same product has already been available for sale in this merchant,
             * but with different supplier, fail this create step.
             */
            $purchase = ProductPurchase::find($request->input('product_purchase_price_id'));
            $merchant = Merchant::whereHas('product_sales', function($q) use ($purchase) {
                $q->where('product_purchase_price_id', '<>', $purchase->id)
                    ->whereHas('product_purchase', function($q) use ($purchase) {
                       $q->where('product_id', $purchase->products()->first()->id); 
                    });
            })->find($request->input('merchant_id'));

            if ($merchant) abort(400);

            $data = ProductSales::create($request->only([
                'product_purchase_price_id',
                'merchant_id',
                'price',
            ]));

            if (! $data) 
                return redirect()->back()->withInput($request->all())->with('warning', 'Fail to add product sales price.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput($request->all())->with('warning', 'Fail to add product sales price. Merchant already selling selected product.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with('warning', 'Fail to add product sales price. Merchant already selling selected product from different supplier.');
        }

        return redirect()->back()->with('success', 'Sales product has been added successfully.');
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

        return response()->view('pages.product-sales-edit', compact('data'), 200);
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
        try {
            $data = ProductSales::where('id', $id)->update($request->only(['price']));
            
            if (! $data) return redirect()->back()->withInput($request->all())->with('warning', 'Fail to edit product sales price.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with('warning', 'Fail to edit product sales price.');
        }

        return redirect()->back()->with('success', 'Sales product has been edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $data = ProductSales::destroy($id);

        if (! $data) return redirect()->back()->with('warning', 'Fail to delete product sales price.');

        return redirect()->back()->with('success', 'Sales product has been deleted successfully.');
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

        if (is_null($search)) return redirect()->route('product.sales.index');

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

        return response()->view('pages.product-sales', compact('rows'), 200);
    }
}
