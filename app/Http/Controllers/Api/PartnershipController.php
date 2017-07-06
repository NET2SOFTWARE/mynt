<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnershipRequest;
use App\Contracts\PartnershipInterface;
use App\Models\Partnership;

class PartnershipController extends Controller
{
    private $partnership;

    /**
     * PartnershipController constructor.
     * @param PartnershipInterface $partnership
     * @internal param PartnershipInterface $service
     */
    public function __construct(PartnershipInterface $partnership)
    {
        $this->partnership = $partnership;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $partnerships = $this->partnership->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('partnerships'), 200)
            : response()->view('pages.partnership', compact('partnerships'), 200);
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
            : response()->view('pages.partnership-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PartnershipRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnershipRequest $request)
    {
        $partnership = $this->partnership->insert($this->partnership->attribute($request->only(['name', 'description'])));

        abort_unless($partnership, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('partnership'), 201)
            : redirect()->back()
                ->with(compact('partnership'))
                ->with('success', 'Partnership has added successfully.');
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
        $partnership = $this->partnership->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('partnership'), 200)
            : response()->view('pages.partnership-show', compact('partnership'), 200);
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
        $partnership = $this->partnership->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.partnership-edit', compact('partnership'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PartnershipRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PartnershipRequest $request, $id)
    {
        $partnership = $this->partnership->update($id, [
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        abort_unless($partnership, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('partnership'), 204)
            : redirect()->back()
                ->with(compact('partnership'))
                ->with('success', 'Partnership data was updated successfully');
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
        $partnership = $this->partnership->delete($id);

        abort_unless($partnership, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Partnership data was updated successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('partnership.index');

        $partnerships = Partnership::where('name', 'ILIKE', '%'.$request->input('search').'%')
            ->orWhere('description', 'ILIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('partnerships'), 200)
            : response()->view('pages.partnership', compact('partnerships'), 200);
    }
}
