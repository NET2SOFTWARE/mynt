<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Contracts\CityInterface;
use App\Contracts\StateInterface;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;
use App\Models\City;

/**
 * Class CityController
 * @package App\Http\Controllers\Api
 */
class CityController extends Controller
{

    /**
     * @var CityInterface
     */
    private $city;

    /**
     * @var StateInterface
     */
    private $state;

    /**
     * CityController constructor.
     * @param CityInterface $city
     * @param StateInterface $state
     */
    public function __construct(
        CityInterface $city,
        StateInterface $state
    )
    {
        $this->city = $city;
        $this->state = $state;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = $this->city->getsPaginateWith('state,state.country', 20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('cities'), 200)
            : response()->view('pages.city', compact('cities'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $states = $this->state->gets(array('id', 'name'));

        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.city-create', compact('states'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $city = $this->city->insert($this->city->attribute($request->only([
            'name', 'state_id'
        ])));

        abort_unless($city, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('city'), 201)
            : redirect()->back()
                ->with(compact('city'))
                ->with('success', 'City has added successfully.');
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
        $city = $this->city->getWith($id, array('state', 'state.country'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('city'), 200)
            : response()->view('pages.city-show', compact('city'), 200);
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
        $city = $this->city->get($id);

        $states = $this->state->gets(['id', 'name']);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.city-edit', compact('city', 'states'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, $id)
    {
        $city = $this->city->update($id, $request->only([
            'name', 'state_id'
        ]));

        abort_unless($city, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('city'), 204)
            : redirect()->back()
                ->with(compact('city'))
                ->with('success', 'City data was updated successfully');
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
        $city = $this->city->delete($id);

        abort_unless($city, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()
                ->route('city.index')
                ->with('success', 'City data was removed successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('city.index');

        $cities = City::where('name', 'ILIKE', '%'.$request->input('search').'%')
            ->orWhereHas('state', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%')
                    ->orWhereHas('country', function ($query) use ($request) {
                        $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
                    });
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('cities'), 200)
            : response()->view('pages.city', compact('cities'), 200);
    }
}
