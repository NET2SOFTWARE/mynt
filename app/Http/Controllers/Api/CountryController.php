<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Contracts\CountryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
    private $country;

    /**
     * CountryController constructor.
     * @param CountryInterface $country
     */
    public function __construct(CountryInterface $country)
    {
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = $this->country->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('countries'), 200)
            : response()->view('pages.country', compact('countries'), 200);
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
            : response()->view('pages.country-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CountryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        $country = $this->country->insert($this->country->attribute($request->only([
            'name', 'iso', 'currency'
        ])));

        abort_unless($country, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('country'), 201)
            : redirect()->back()
                        ->with(compact('country'))
                        ->with('success', 'Country has added successfully.');
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
        $country = $this->country->getWith($id, array('state', 'state.city'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('country'), 200)
            : response()->view('pages.country-show', compact('country'), 200);
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
        $country = $this->country->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.country-edit', compact('country'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        $country = $this->country->update($id, $request->only([
            'name', 'iso', 'currency'
        ]));

        abort_unless($country, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('country'), 204)
            : redirect()->back()
                        ->with(compact('country'))
                        ->with('success', 'Country data was updated successfully');
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
        $country = $this->country->delete($id);

        abort_unless($country, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                    'status' => 'true',
                    'code' => 204,
                    'message' => config('code.204'),
                    'data' => null
                ], 204)
            : redirect()->back()
                ->with('success', 'Country data was updated successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('country.index', ['all']);

        $countries = Country::where('name', 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('iso', 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('currency', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('countries'), 200)
            : response()->view('pages.country', compact('countries'), 200);
    }
}
