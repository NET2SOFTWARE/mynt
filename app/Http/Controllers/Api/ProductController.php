<?php

namespace App\Http\Controllers\Api;

use SnappyPDF;
use Lava;
use Khill\Lavacharts\Lavacharts;
use App\Models\Product;
use App\Models\Account;
use App\Models\Company;
use App\Contracts\ProductInterface;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
class ProductController extends Controller
{

    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * ProductController constructor.
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->product->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('products'), 200)
            : response()->view('pages.product', compact('products'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.product-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = $this->product->insert($this->product->attribute($request->only(['name', 'price', 'description'])));

        abort_unless($product, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('product'), 201)
            : redirect()->back()
                ->with(compact('product'))
                ->with('success', 'Product has been added successfully.');
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
        # $product = $this->product->get($id);
        $product = Product::with([
                'companies' => function($q) {
                    $q->with('accounts');
                },
                'merchants' => function($q) {
                    $q->with('accounts');
                }
            ])
            ->find($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('product'), 200)
            : response()->view('pages.product-show', compact('product'), 200);
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
        $product = $this->product->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.product-edit', compact('product'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = $this->product->update($id, $request->only(['name', 'price', 'description']));

        abort_unless($product, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('product'), 204)
            : redirect()->back()
                ->with(compact('product'))
                ->with('success', 'Product data was updated successfully');
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
        $product = $this->product->delete($id);

        abort_unless($product, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Product data was updated successfully');
    }

    /**
     * Display sorted listing for products
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('product.index');

        $products = Product::where('name', 'like', '%'. $request->input('search') .'%')
            ->orWhere('description', 'like', '%'. $request->input('search') .'%')
            ->paginate(20);

        return response()->view('pages.product', compact('products'), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function mappingPricePage(Request $request)
    {
        $products = Account::with(['companies', 'merchants'])
            ->whereHas('companies', function($q) {
                $q->has('products');
            })
            ->orWhereHas('merchants', function($q) {
                $q->has('products');
            })
            ->paginate(15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('products'), 200)
            : response()->view('pages.product-mapping_price', compact('products'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function createMappingPricePage(Request $request)
    {
        $products = Product::all();
        $accounts = Account::whereIn('account_type_id', [3,4])->get();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('products', 'accounts'), 200)
            : response()->view('pages.product-mapping_price-create', compact('products', 'accounts'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeMappingPrice(Request $request)
    {
        $products = [];
        $accounts = Account::whereIn('id', $request->input('account_id'))->with(['companies', 'merchants'])->get();

        foreach ($accounts as $account)
        {
            $product = Product::find($request->input('product_id'));

            if ($account->account_type_id == 3)
                $product->companies()->save($account->companies()->first(), ['price' => $request->input('price')]);
            elseif ($account->account_type_id == 4)
                $product->merchants()->save($account->merchants()->first(), ['price' => $request->input('price')]);

            $products[] = $product;
        }

        abort_unless($product, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('product'), 201)
            : redirect()->back()
                ->with(compact('product'))
                ->with('success', 'Product has been added successfully.');
    }

    public function deactivatePage(Request $request)
    {
        $products = $this->product->getsPaginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('products'), 200)
            : response()->view('pages.product-deactivate', compact('products'), 200);
    }

    public function deactivateSort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('product.deactivate.sort');

        $products = product::where('code', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('products'), 200)
            : response()->view('pages.product-deactivate', compact('products'), 200);
    }

    public function deactivateProcess(Request $request, $id)
    {
        $product = product::find($id);

        $product->is_active = ! $product->is_active;

        $product->save();

        abort_unless($product, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('product'), 204)
            : redirect()->back()
                ->with(compact('product'))
                ->with('success', 'product data was updated successfully.');
    }

    public function report(Request $request)
    {
        $data = [];

        return response()->view('pages.report-product', compact('data'), 200);
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

        $companies = Company::get();
        $products = Product::get();

        $data['companies'] = $companies;
        $data['products'] = $products;
        $data['count_product'] = $products->count();
        $data['total_fees'] = 0;

        $dataTable = Lava::DataTable();
        $dataTable->addStringColumn('Company')->addNumberColumn('Count');

        foreach ($companies as $company) $dataTable->addRow([$company->name, $company->product_purchase->count()]);

        Lava::PieChart('Products', $dataTable, [
            'title'  => 'Products provided by company',
            // 'png' => true,
        ]);

        $dataTable = Lava::DataTable();
        $dataTable->addStringColumn('Product')->addNumberColumn('Amount');

        foreach ($products as $product) $dataTable->addRow([$product->name, 0]);

        Lava::PieChart('Fees', $dataTable, [
            'title'  => 'Fee by product',
            // 'png' => true,
        ]);

        return response()->view('pages.report-product-show', compact('data'), 200);
    }
}
