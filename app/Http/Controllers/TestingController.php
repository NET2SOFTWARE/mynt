<?php

namespace App\Http\Controllers;

use App\Contracts\EncryptInterface;
use Illuminate\Http\Request;


class TestingController extends Controller
{
    public $app;

    public function __construct(EncryptInterface $app)
    {
        $this->app = $app;
    }

    public function testing(Request $request)
    {
        $cipherText = $this->app->encrypt($request->get('text'));
        return base64_encode($cipherText);
    }
}
