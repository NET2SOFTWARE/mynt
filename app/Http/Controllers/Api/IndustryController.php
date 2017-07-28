<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryRequest;
use App\Contracts\IndustryInterface;
use App\Models\Industry;

class IndustryController extends Controller
{
    private $industry;

    /**
     * IndustryController constructor.
     * @param IndustryInterface $industry
     */
    public function __construct(IndustryInterface $industry)
    {
        $this->industry = $industry;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $industries = $this->industry->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('industries'), 200)
            : response()->view('pages.industry', compact('industries'), 200);
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
            : response()->view('pages.industry-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IndustryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndustryRequest $request)
    {
        $industry = $this->industry->insert($this->industry->attribute($request->only(['name'])));

        abort_unless($industry, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('industry'), 201)
            : redirect()->back()
                ->with(compact('industry'))
                ->with('success', 'Institution has been added successfully.');
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
        $industry = $this->industry->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('industry'), 200)
            : response()->view('pages.industry-show', compact('industry'), 200);
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
        $industry = $this->industry->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.industry-edit', compact('industry'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IndustryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(IndustryRequest $request, $id)
    {
        $industry = $this->industry->update($id, $request->only(['name']));

        abort_unless($industry, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('industry'), 204)
            : redirect()->back()
                ->with(compact('industry'))
                ->with('success', 'Institution data was updated successfully');
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
        $industry = $this->industry->delete($id);

        abort_unless($industry, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()
                ->route('industry.index')
                ->with('success', 'Institution data was removed successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('industry.index');

        $industries = Industry::where('name', 'ILIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('industries'), 200)
            : response()->view('pages.industry', compact('industries'), 200);
    }
}
