<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Facades\BlueGroups;
// use App\Facades\BluePages;
// use App\Facades\BlueGroupsManage;
use App\Services\Contracts\BlueGroupsManageServiceInterface;
use App\Services\Contracts\BlueGroupsServiceInterface;
use App\Services\Contracts\BluePagesServiceInterface;
use App\Services\Contracts\TestServiceInterface;
use Illuminate\Support\Facades\Log;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;
use App\Models\AccessRequest;
use Illuminate\Support\Facades\URL;

class Index extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('guest:user')->except('logout');
        // $this->middleware('guest:admin')->except('logout');

        $this->middleware('guest:user,admin')->except('logout');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('main');
    }

    public function index(Request $request
        // TestServiceInterface $test,
        // BluePagesServiceInterface $bluePages,
        // BlueGroupsServiceInterface $blueGroups,
        // BlueGroupsManageServiceInterface $blueGroupsManage
        )
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $userMail = $user->mail[0];

        $accounts = Account::where('account_dpe_intranet_id', '=', $userMail)
            ->orWhere('tt_focal_intranet_id', '=', $userMail)
            ->get();

        // $checklists = Account::with(['checklists' => function ($query) use($userMail) {
        //         $query->where('created_by', '=', $userMail);
        //     }])
        //     ->where('account_dpe_intranet_id', '=', $userMail)
        //     ->orWhere('tt_focal_intranet_id', '=', $userMail)
        //     ->get();

        // $services = Account::with(['checklists' => function ($query) use($userMail) {
        //         $query->where('created_by', '=', $userMail);
        //     }])
        //     ->where('account_dpe_intranet_id', '=', $userMail)
        //     ->orWhere('tt_focal_intranet_id', '=', $userMail)
        //     ->get();

        $checklists = Account::with('userChecklists')
            ->where('account_dpe_intranet_id', '=', $userMail)
            ->orWhere('tt_focal_intranet_id', '=', $userMail)
            ->get();

        $services = Account::with('userChecklists')
            ->where('account_dpe_intranet_id', '=', $userMail)
            ->orWhere('tt_focal_intranet_id', '=', $userMail)
            ->get();

        // $services->load('inScopeNo');

        // dump('my test');
        // dump($accounts);
        // dump($checklists);
        // dump($services);

        $pending = AccessRequest::where('status', '=', AccessRequest::STATUS_PENDING)
            ->get();

        $data = array(
            'user' => $user,
            'accounts' => $accounts,
            'accountsChecklists' => $checklists,
            'accountsPendingServices' => $services,
            'pending' => $pending,
        );

        return view('main', $data);
    }

    public function access()
    {
        // Get the currently authenticated user...
        $user = Auth::user();

        $data = array(
            'user' => $user
        );

        return view('access', $data);
    }
}
