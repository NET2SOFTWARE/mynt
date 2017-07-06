<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Account;
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

}
