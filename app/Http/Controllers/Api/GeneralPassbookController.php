<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\GlobalPassbookInterface;
use Illuminate\Http\Request;

class GeneralPassbookController extends Controller
{
    private $global;

    public function __construct(GlobalPassbookInterface $global)
    {
        $this->global = $global;
    }

    public function index()
    {
        $general_passbooks = $this->global->paginate();

        return response()
            ->view('pages.general-ledger', compact('general_passbooks'), 200);
    }

    public function sort(Request $request)
    {

    }
}
