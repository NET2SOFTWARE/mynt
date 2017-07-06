<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdentityRequest;
use App\Contracts\IdentityInterface;
use App\Models\Identity;

/**
 * Class IdentityController
 * @package App\Http\Controllers\Api
 */
class IdentityController extends Controller
{
    /**
     * @var IdentityInterface
     */
    private $identity;

    /**
     * IdentityController constructor.
     * @param IdentityInterface $identity
     */
    public function __construct(IdentityInterface $identity)
    {
        $this->identity = $identity;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $identities = $this->identity->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('identities'), 200)
            : response()->view('pages.identity', compact('identities'), 200);
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
            : response()->view('pages.identity-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IdentityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IdentityRequest $request)
    {
        $identity = $this->identity->insert($this->identity->attribute($request->only(['name'])));

        abort_unless($identity, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('identity'), 201)
            : redirect()->back()
                ->with(compact('identity'))
                ->with('success', 'Identity has added successfully.');
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
        $identity = $this->identity->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('identity'), 200)
            : response()->view('pages.identity-show', compact('identity'), 200);
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
        $identity = $this->identity->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.identity-edit', compact('identity'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IdentityRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(IdentityRequest $request, $id)
    {
        $identity = $this->identity->update($id, $request->only(['name']));

        abort_unless($identity, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('identity'), 204)
            : redirect()->back()
                ->with(compact('identity'))
                ->with('success', 'Identity data was updated successfully');
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
        $identity = $this->identity->delete($id);

        abort_unless($identity, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Identity data was updated successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('identity.index');

        $identities = Identity::where('name', 'ILIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('identities'), 200)
            : response()->view('pages.identity', compact('identities'), 200);
    }
}
