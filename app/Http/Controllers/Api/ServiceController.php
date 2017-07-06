<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Contracts\ServiceInterface;
use App\Models\Service;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api
 */
class ServiceController extends Controller
{

    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * ServiceController constructor.
     * @param ServiceInterface $service
     */
    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = $this->service->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('cities'), 200)
            : response()->view('pages.service', compact('services'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.service-create', compact(null), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40|unique:services'
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to create service, please check invalid message below.')
                    ->withInput($request->all());
        }

        $service = $this->service->insert($this->service->attribute($request->only(['name'])));

        abort_unless($service, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('service'), 201)
            : redirect()->back()
                ->with(compact('service'))
                ->with('success', 'Service has added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $service = $this->service->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('service'), 200)
            : response()->view('pages.service-show', compact('service'), 200);
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
        $service = $this->service->get($id);

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.service-edit', compact('service'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40|unique:services,name,' . $id
        ]);

        if ($validator->fails())
        {
            return ($request->ajax() || $request->isJson())
                ? abort(500, config('code.500'))
                : redirect()->back()
                    ->withErrors($validator)
                    ->with('warning', 'Fail to update service, please check invalid message below.')
                    ->withInput($request->all());
        }

        $service = $this->service->update($id, $request->only(['name']));

        abort_unless($service, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('service'), 204)
            : redirect()->back()
                ->with(compact('service'))
                ->with('success', 'Service data was updated successfully');
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
        $service = $this->service->delete($id);

        abort_unless($service, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Service data was updated successfully');
    }

    /**
     * Display sorted listing
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('service.index');

        $services = Service::where('name', 'ILIKE', '%'.strtolower($request->input('search')).'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('services'), 200)
            : response()->view('pages.service', compact('services'), 200);
    }

    public function deactivatePage(Request $request)
    {
        $services = $this->service->getsPaginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('services'), 200)
            : response()->view('pages.service-deactivate', compact('services'), 200);
    }

    public function deactivateSort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('service.deactivate.sort');

        $services = service::where('name', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('services'), 200)
            : response()->view('pages.service-deactivate', compact('services'), 200);
    }

    public function deactivateProcess(Request $request, $id)
    {
        $service = service::find($id);

        $service->is_active = ! $service->is_active;

        $service->save();

        abort_unless($service, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('service'), 204)
            : redirect()->back()
                ->with(compact('service'))
                ->with('success', 'Service data was updated successfully.');
    }
}
