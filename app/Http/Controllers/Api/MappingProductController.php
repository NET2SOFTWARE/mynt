<?php

namespace App\Http\Controllers\Api;

use App\Models\MappingProduct;
use App\Models\Account;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MappingProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mapping_products = MappingProduct::paginate(15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('mapping_products'), 200)
            : response()->view('pages.mapping_product', compact('mapping_products'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $products = Product::all();
        $accounts = Account::whereIn('account_type_id', [3,4])->get();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('products', 'accounts'), 200)
            : response()->view('pages.mapping_product-create', compact('products', 'accounts'), 200);
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
            'account_id'        => 'required|numeric',
            'product_id'        => 'required|numeric',
            'tax'               => 'required|numeric|min:0',
            'fee'               => 'required|numeric|min:0',
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()->withErrors($validator)->with('warning', 'Fail to create mapping product tax and fee, please check invalid message below.')->withInput($request->all());
        }

        $mapping_product = MappingProduct::create($request->only([
            'account_id',
            'product_id',
            'tax',
            'fee',
        ]));

        abort_unless($mapping_product, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('mapping_product'), 201)
            : redirect()->back()
                ->with(compact('mapping_product'))
                ->with('success', 'Product tax and fee has been mapped successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MappingProduct  $mappingProduct
     * @return \Illuminate\Http\Response
     */
    public function show(MappingProduct $mappingProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MappingProduct  $mappingProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(MappingProduct $mappingProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MappingProduct  $mappingProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MappingProduct $mappingProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MappingProduct  $mappingProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(MappingProduct $mappingProduct)
    {
        //
    }

    /**
     * Display sorted listing for products
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('mapping_product.index');

        return response()->view('pages.mapping_product', compact(null), 200);
    }
}
