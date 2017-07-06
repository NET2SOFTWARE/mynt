<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Terminal;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Contracts\TerminalInterface;
use App\Http\Requests\TerminalRequest;
use App\Http\Controllers\Controller;

/**
 * Class TerminalController
 * @package App\Http\Controllers\Api
 */
class TerminalController extends Controller
{

    /**
     * @var TerminalInterface
     */
    private $terminal;

    /**
     * TerminalController constructor.
     * @param TerminalInterface $terminal
     */
    public function __construct(TerminalInterface $terminal)
    {
        $this->terminal = $terminal;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $terminals = $this->terminal->getsPaginate();

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('terminals'), 200)
            : response()->view('pages.terminal', compact('terminals'), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $merchants = Merchant::orderBy('name', 'asc')->get();

        return ($request->ajax() || $request->isJson())
            ? abort(405, config('code.405'))
            : response()->view('pages.terminal-create', compact('merchants'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TerminalRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerminalRequest $request)
    {
        $terminal = $this->terminal->save($this->terminal->attribute($request->only(['code'])));

        $terminal->merchants()->attach($request->input('merchant_id'));

        abort_unless($terminal, 500);

        return ($request->isJson() || $request->ajax())
            ? response()->json(compact('terminal'), 201)
            : redirect()->back()
                ->with(compact('terminal'))
                ->with('success', 'Terminal has been added successfully.');
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
        $terminal = $this->terminal->get($id);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('terminal'), 200)
            : response()->view('pages.terminal-show', compact('terminal'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        // $terminal = $this->terminal->get($id);
        $terminal = Terminal::find($id);
        $merchants = Merchant::orderBy('name', 'asc')->get();

        return ($request->isJson() || $request->ajax())
            ? abort(405, config('code.405'))
            : response()->view('pages.terminal-edit', compact('terminal', 'merchants'), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TerminalRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TerminalRequest $request, $id)
    {
        $terminal = Terminal::findOrFail($id);
        $terminal->update($request->only(['code']));
        $terminal->merchants()->sync($request->input('merchant_id'));

        abort_unless($terminal, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('terminal'), 204)
            : redirect()->back()
                ->with(compact('terminal'))
                ->with('success', 'Terminal data was updated successfully');
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
        $terminal = $this->terminal->delete($id);

        abort_unless($terminal, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json([
                'status' => 'true',
                'code' => 204,
                'message' => config('code.204'),
                'data' => null
            ], 204)
            : redirect()->back()
                ->with('success', 'Terminal data was updated successfully');
    }

    /**
     * Display sorted listing for terminals
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('terminal.index');

        $terminals = Terminal::where(DB::raw('code::TEXT'), 'LIKE', '%'. $request->input('search') .'%')
            ->orWhereHas('merchants', function ($query) use ($request) {
                $query->where('name', 'ILIKE', '%'.$request->input('search').'%');
            })
            ->paginate(20);

        return response()->view('pages.terminal', compact('terminals'), 200);
    }

    public function deactivatePage(Request $request)
    {
        $terminals = $this->terminal->getsPaginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('terminals'), 200)
            : response()->view('pages.terminal-deactivate', compact('terminals'), 200);
    }

    public function deactivateSort(Request $request)
    {
        if (is_null($request->input('search'))) return redirect()->route('terminal.deactivate.sort');

        $terminals = Terminal::where('code', 'LIKE', '%'.$request->input('search').'%')
            ->paginate(20);

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('terminals'), 200)
            : response()->view('pages.terminal-deactivate', compact('terminals'), 200);
    }

    public function deactivateProcess(Request $request, $id)
    {
        $terminal = Terminal::find($id);

        $terminal->is_active = ! $terminal->is_active;

        $terminal->save();

        abort_unless($terminal, config('code.500'));

        return ($request->ajax() || $request->isJson())
            ? response()->json(compact('terminal'), 204)
            : redirect()->back()
                ->with(compact('terminal'))
                ->with('success', 'terminal data was updated successfully.');
    }
}
