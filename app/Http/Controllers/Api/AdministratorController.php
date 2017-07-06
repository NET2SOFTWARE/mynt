<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdministratorRequest;
use App\Contracts\AdministratorInterface;
use App\Admin;

/**
 * Class AdministratorController
 * @package App\Http\Controllers\Api
 */
class AdministratorController extends Controller
{

    private $administrator;

    /**
     * AdministratorController constructor.
     * @param AdministratorInterface $administrator
     */
    public function __construct(AdministratorInterface $administrator)
    {
        $this->administrator = $administrator;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $param
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $param = null)
    {
        switch ($param) {
            case 'super-admin' :
                $admins = $this->administrator->sortByRelationPaginate('roles', 'name', 'super-admin');
                $page = 'pages.administrator-super';
                break;
            case 'admin' :
                $admins = $this->administrator->sortByRelationPaginate('roles', 'name', 'admin');
                $page = 'pages.administrator-admin';
                break;
            default :
                $admins = $this->administrator->getsPaginate();
                $page = 'pages.administrator';
                break;
        }

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('admins'), 200)
            : response()->view($page, compact('admins'), 200);
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
            : response()->view('pages.administrator-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:40',
            'email'             => 'required|email|unique:admins',
            'password'          => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to create administrator, please check invalid message below.')
                    ->withInput($request->all());
        }

        $administrator = $this->administrator->insert($this->administrator->attribute($request->only(['name', 'email', 'password'])));

        abort_unless($administrator, 500);
        
        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('administrator'), 201)
            : redirect()->back()
                ->with(compact('administrator'))
                ->with('success', 'Administrator has been added successfully.');
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
        $administrator = $this->administrator->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('administrator'), 200)
            : response()->view('pages.administrator-show', compact('administrator'), 200);
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
        $administrator = $this->administrator->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.administrator-edit', compact('administrator'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdministratorRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdministratorRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:40',
            'email'             => 'required|email|unique:admins,email,' . $id,
            'password'          => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to update administrator, please check invalid message below.')
                    ->withInput($request->all());
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $administrator = $this->administrator->update($id, $data);

        abort_unless($administrator, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('administrator'), 204)
            : redirect()->back()
                ->with(compact('administrator'))
                ->with('success', 'Administrator data was updated successfully.');
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
        $administrator = $this->administrator->delete($id);

        abort_unless($administrator, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Administrator data was updated successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('administrator.index', ['all']);

        $admins = Admin::where('name', 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('email', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('admins'), 200)
            : response()->view('pages.administrator', compact('admins'), 200);
    }

    public function deactivatePage(Request $request)
    {
        $administrators = $this->administrator->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('administrators'), 200)
            : response()->view('pages.administrator-deactivate', compact('administrators'), 200);
    }

    public function deactivateSort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('administrator.deactivate.sort');

        $administrators = Admin::where('name', 'LIKE', '%'.$request->input('search').'%')
            ->orWhere('email', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('administrators'), 200)
            : response()->view('pages.administrator-deactivate', compact('administrators'), 200);
    }

    public function deactivateProcess(Request $request, $id)
    {
        $administrator = Admin::find($id);

        $administrator->is_active = ! $administrator->is_active;

        $administrator->save();

        abort_unless($administrator, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('administrator'), 204)
            : redirect()->back()
                ->with(compact('administrator'))
                ->with('success', 'Administrator data was updated successfully.');
    }
}
