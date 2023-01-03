<?php

namespace App\View\Components\Checklist;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\ServiceCategory;
use App\Services\Contracts\BlueGroupsManageServiceInterface;
use App\Services\Contracts\BlueGroupsServiceInterface;
use App\Services\Contracts\BluePagesServiceInterface;
use App\Services\Contracts\TestServiceInterface;

class AccountFormCard extends Component
{
    public $record;
    public $wizard;
    public $states;
    public $accounts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $record,
        $wizard = null,
        TestServiceInterface $test,
        BluePagesServiceInterface $bluePages,
        BlueGroupsServiceInterface $blueGroups,
        BlueGroupsManageServiceInterface $blueGroupsManage
        )
    {
        $this->record = $record;
        $this->wizard = $wizard;
        $this->states = Account::STATES;

        if (is_null($record->id)) {

            // Get the currently authenticated user...
            $user = Auth::user();
            $userMail = $user->mail[0];

            $adminBg = app()->config['app']['adminBg'];
            $groupAuth = $blueGroups->groupAuth($userMail, $adminBg);

            if($groupAuth) {
                $this->accounts = Account::orderBy('name', 'asc')
                    ->get();
            } else {
                $this->accounts = Account::where('account_dpe_intranet_id', '=', $userMail)
                    ->orWhere('tt_focal_intranet_id', '=', $userMail)
                    ->orderBy('name', 'desc')
                    ->get();
            }
        } else {
            $this->accounts = array();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.account-form-card');
    }
}
