<?php

namespace App\Http\Controllers;

use App\Models\Secret;
use Illuminate\Http\Request;

class SecretController extends Controller
{
	public function get(Request $request)
	{
		$secret = Secret::where('name', 'ILIKE', '%password%')->first();

		if ($secret)
		{
			return response()
	            ->json([
	            	'id' => $secret->id
	            ,	'key' => $secret->secret
	            ], 200);
		} else {
			return response()
	            ->json([
	            	'key' => null
	            ], 404);
		}
	}
}