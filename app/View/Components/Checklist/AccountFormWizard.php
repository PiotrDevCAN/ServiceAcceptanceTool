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

class AccountFormWizard extends Component
{
    public $name;
    public $record;
    public $states;
    public $accounts;
    public $types;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $record,
        TestServiceInterface $test,
        BluePagesServiceInterface $bluePages,
        BlueGroupsServiceInterface $blueGroups,
        BlueGroupsManageServiceInterface $blueGroupsManage
        )
    {
        dump($record);

        // load required relations
        // if (!empty($record->id)) {
        //     $record->loadCount('account');
        // }

        $this->name = $name;
        $this->record = $record;
        $this->states = Account::STATES;
        $this->types = ServiceCategory::TYPES;

        // if (is_null($record->id)) {

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
        // } else {
        //     $this->accounts = null;
        // }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.account-form-wizard');
    }
}
