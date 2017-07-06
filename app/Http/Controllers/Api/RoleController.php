<?php

namespace App\Http\Controllers\Api;

use App\Contracts\AccessConfigurationInterface;
use Illuminate\Http\Request;
use App\Contracts\RoleInterface;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

/**
 * Class RoleController
 * @package App\Http\Controllers\Api
 */
class RoleController extends Controller
{

    /**
     * @var RoleInterface
     */
    private $role;

    private $accessConfiguration;

    /**
     * RoleController constructor.
     * @param RoleInterface $role
     * @param AccessConfigurationInterface $accessConfiguration
     */
    public function __construct(
        RoleInterface $role,
        AccessConfigurationInterface $accessConfiguration
    )
    {
        $this->role = $role;
        $this->accessConfiguration = $accessConfiguration;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = $this->role->paginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('roles'), 200)
            : response()->view('pages.role', compact('roles'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $accesses = $this->accessConfiguration->gets();

        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.role-create', compact('accesses'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = $this->role->save($request->only(['name']));

        if (!$role) {
            redirect()->back()
                ->withInput($request->all())
                ->with('warning', 'System can not create role data.');
        }

        $accessConfig = $this->accessConfiguration->save($request->all());

        if (!$accessConfig) {
            $role->delete();
            redirect()->back()
                ->withInput($request->all())
                ->with('warning', 'System can not create role configuration data.');
        }

        $role->access_configurations()->attach($accessConfig->id);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('role'), 201)
            : redirect()->back()
                ->with(compact('role'))
                ->with('success', 'Role has added successfully.');
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
        $role = $this->role->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('role'), 200)
            : response()->view('pages.role-show', compact('role'), 200);
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
        $role = $this->role->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.role-edit', compact('role'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = $this->role->update($id, $request->all());

        abort_unless($role, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('role'), 204)
            : redirect()->back()
                ->with(compact('role'))
                ->with('success', 'Role data was updated successfully');
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
        $role = $this->role->delete($id);

        abort_unless($role, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Role data was updated successfully');
    }
}
