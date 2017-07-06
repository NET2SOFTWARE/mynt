<?php

namespace App\Http\Controllers\Api;

use App\Models\Charge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $charges = Charge::paginate(15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('charges'), 200)
            : response()->view('pages.charge', compact('charges'), 200);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.charge-create', compact(null), 200);
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
            'name' => 'required|string|max:40|unique:charges'
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to create charge, please check invalid message below.')
                    ->withInput($request->all());
        }

        $charge = Charge::create($request->only(['name']));

        abort_unless($charge, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('charge'), 201)
            : redirect()->back()
                ->with(compact('charge'))
                ->with('success', 'Charge has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $charge = Charge::findOrFail($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('charge'), 200)
            : response()->view('pages.charge-show', compact('charge'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $charge = Charge::findOrFail($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.charge-edit', compact('charge'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40|unique:charges,name,' . $id
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to update charge, please check invalid message below.')
                    ->withInput($request->all());
        }

        $charge = Charge::findOrFail($id)->update($request->only(['name']));

        abort_unless($charge, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('charge'), 204)
            : redirect()->back()
                ->with(compact('charge'))
                ->with('success', 'Charge data was updated successfully');
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
        $charge = Charge::destroy($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Charge data was deleted successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('charge.index');

        $charges = Charge::where('name', 'ILIKE', '%'.strtolower($request->input('search')).'%')
            ->paginate(15);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('charges'), 200)
            : response()->view('pages.charge', compact('charges'), 200);
    }
}
