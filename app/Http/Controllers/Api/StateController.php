<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Contracts\StateInterface;
use App\Contracts\CountryInterface;
use App\Http\Requests\StateRequest;
use App\Http\Controllers\Controller;
use App\Models\State;

/**
 * Class StateController
 * @package App\Http\Controllers\Api
 */
class StateController extends Controller
{
    /**
     * @var
     */
    private $state;

    /**
     * @var
     */
    protected $country;

    /**
     * StateController constructor.
     * @param StateInterface $state
     * @param CountryInterface $country
     */
    public function __construct(
        StateInterface $state,
        CountryInterface $country
    )
    {
        $this->state = $state;
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
        $states = $this->state->getsPaginateWith('country', 20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('states'), 200)
            : response()->view('pages.state', compact('states'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $countries = $this->country->gets(array('id', 'name'));

        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.state-create', compact('countries'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $state = $this->state->insert($this->state->attribute($request->only([
            'name', 'country_id'
        ])));

        abort_unless($state, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('state'), 201)
            : redirect()->back()
                        ->with(compact('state'))
                        ->with('success', 'State has added successfully.');
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
        $state = $this->state->getWith($id, array('country', 'city'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('state'), 200)
            : response()->view('pages.state-show', compact('state'), 200);
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
        $state = $this->state->get($id);

        $countries = $this->country->gets(['id', 'name']);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.state-edit', compact('state', 'countries'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, $id)
    {
        $state = $this->state->update($id, $this->state->attribute($request->only([
            'name', 'country_id'
        ])));

        abort_unless($state, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('state'), 204)
            : redirect()->back()
                        ->with(compact('state'))
                        ->with('success', 'State data was updated successfully');
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
        $state = $this->state->delete($id);

        abort_unless($state, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                        ->with('success', 'State data was updated successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('state.index');

        $states = State::where('name', 'ILIKE', '%'.$request->input('search').'%')
            ->orWhereHas('country', function($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('states'), 200)
            : response()->view('pages.state', compact('states'), 200);
    }
}
