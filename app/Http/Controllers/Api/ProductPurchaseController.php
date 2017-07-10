<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductPurchase;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = ProductPurchase::paginate(20);

        return response()->view('pages.product-purchase', compact('rows'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $companies = Company::all();

        return response()->view('pages.product-purchase-create', compact('products', 'companies'), 200);
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
            $data = ProductPurchase::create($request->only([
                'product_id',
                'company_id',
                'price',
            ]));
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with('warning', 'Fail to add product purchase price.');
        }

        if (! $data) return redirect()->back()->withInput($request->all())->with('warning', 'Fail to add product purchase price.');

        return redirect()->back()->with('success', 'Purchase product has been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $data = ProductPurchase::find($id);

        return response()->view('pages.product-purchase-edit', compact('data'), 200);
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
            $data = ProductPurchase::where('id', $id)->update($request->only(['price']));
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->all())->with('warning', 'Fail to edit product purchase price.');
        }

        if (! $data) return redirect()->back()->withInput($request->all())->with('warning', 'Fail to edit product purchase price.');

        return redirect()->back()->with('success', 'Purchase product has been edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $data = ProductPurchase::destroy($id);

        if (! $data) return redirect()->back()->with('warning', 'Fail to delete product purchase price.');

        return redirect()->back()->with('success', 'Purchase product has been deleted successfully.');
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

        if (is_null($search)) return redirect()->route('product.purchase.index');

        $rows = ProductPurchase::whereHas('products', function($q) use ($search) {
                $q->where('name', 'ILIKE', "%$search%");
            })
            ->orWhereHas('companies', function($q) use ($search) {
                $q->where('name', 'ILIKE', "%$search%");
            })
            ->paginate(20);

        return response()->view('pages.product-purchase', compact('rows'), 200);
    }
}
