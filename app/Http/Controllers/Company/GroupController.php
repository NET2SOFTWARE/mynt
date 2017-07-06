<?php

namespace App\Http\Controllers\Company;

use App\Models\Member;
use App\Models\Merchant;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $companyId = Auth::user()->companies->first()['id'];

        $members = Member::whereHas('companies', function ($query) use ($companyId) {
            $query->where('companies.id', $companyId);
        })->paginate((int) 15);

        return response()
            ->view('company.list-group', compact('members'), 200);
    }

    public function sort(Request $request)
    {
        if (is_null($request->input('search')))
            return redirect()->route('company.list.member');

        $companyId = Auth::user()->companies->first()['id'];

        $members = Member::where(function ($query) use ($request) {
                                $query->where('members.name', 'LIKE', '%'.$request->input('search').'%')
                                    ->orWhere('members.email', 'LIKE', '%'.$request->input('search').'%')
                                    ->orWhere('members.phone', 'LIKE', '%'.$request->input('search').'%');
                                })->whereHas('companies', function ($query) use ($companyId, $request) {
                                    $query->where('companies.id', '=', $companyId);
                                })->paginate((int) 15);

        return response()
            ->view('company.list-group', compact('members'), 200);
    }

    public function listMerchant()
    {
        $companyId = Auth::user()->companies->first()['id'];

        $merchants = Merchant::where(function ($query) use ($companyId) {
            $query->whereHas('companies', function ($query) use ($companyId) {
                $query->where('companies.id', $companyId);
            });
        })->paginate((int) 15);


        return response()
            ->view('company.list-group-merchant', compact('merchants'), 200);
    }

    public function sortMerchant(Request $request)
    {
        if (is_null($request->input('search')))
            return redirect()->route('company.list.merchant');

        $companyId = Auth::user()->companies->first()['id'];

        $merchants = Merchant::where(function ($query) use ($request, $companyId) {
            $query->where('merchants.name', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('merchants.email', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('merchants.phone', 'LIKE', '%'.$request->input('search').'%')
                ->where(function ($query) use ($companyId) {
                    $query->whereHas('companies', function ($query) use ($companyId) {
                        $query->where('companies.id', $companyId);
                    });
                });
        })->paginate((int) 15);

        return response()
            ->view('company.list-group-merchant', compact('merchants'), 200);
    }
}
