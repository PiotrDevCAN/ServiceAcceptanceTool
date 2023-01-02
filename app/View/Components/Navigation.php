<?php

namespace App\View\Components;

use App\Services\Contracts\BlueGroupsManageServiceInterface;
use App\Services\Contracts\BlueGroupsServiceInterface;
use App\Services\Contracts\BluePagesServiceInterface;
use App\Services\Contracts\TestServiceInterface;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Navigation extends Component
{

    private $homeMenu = array(
        'route' => 'home'
    );

    private $userMenu = array(
        'route' => array(
            'Create' => array(
                'route' => 'checklist.create'
            ),
            'Entry' => array(
                'route' => 'checklist.edit',
                'param' => array(
                    'checklist' => 1
                )
            ),
            'List - Overview' => array(
                'route' => 'checklist.list'
            ),
            'Services Checklist' => array(
                'route' => 'checklist.overview'
            ),
            'Services Checklist Details' => array(
                'route' => 'checklist.overviewForChecklist',
                'param' => array(
                    'checklist' => 1
                )
            ),
        ),
    );

    private $adminMenu = array(
        'route' => array(
            'Accounts' => array(
                'route' => array(
                    'Create' => array(
                        'route' => 'admin.account.create'
                    ),
                    'Entry' => array(
                        'route' => 'admin.account.edit',
                        'param' => array(
                            'account' => 1
                        )
                    ),
                    'List - Overview' => array(
                        'route' => 'admin.account.list'
                    )
                )
            ),
            'Checklists' => array(
                'route' => array(
                    'Create' => array(
                        'route' => 'admin.checklist.create'
                    ),
                    'Entry' => array(
                        'route' => 'admin.checklist.edit',
                        'param' => array(
                            'checklist' => 1
                        )
                    ),
                    'List - Overview' => array(
                        'route' => 'admin.checklist.list'
                    ),
                    'Services Checklist' => array(
                        'route' => 'admin.checklist.overview'
                    ),
                    'Services Checklist Details' => array(
                        'route' => 'admin.checklist.overviewForChecklist',
                        'param' => array(
                            'checklist' => 1
                        )
                    ),
                )
            ),
            'Services Categories' => array(
                'route' => array(
                    'Create' => array(
                        'route' => 'admin.category.create'
                    ),
                    'Entry' => array(
                        'route' => 'admin.category.edit',
                        'param' => array(
                            'category' => 1
                        )
                    ),
                    'List - Overview' => array(
                        'route' => 'admin.category.list'
                    )
                )
            ),
            'Services Sections' => array(
                'route' => array(
                    'Create' => array(
                        'route' => 'admin.section.create'
                    ),
                    'Entry' => array(
                        'route' => 'admin.section.edit',
                        'param' => array(
                            'section' => 1
                        )
                    ),
                    'List - Overview' => array(
                        'route' => 'admin.section.list'
                    )
                )
            ),
            'Services aka Questions' => array(
                'route' => array(
                    'Create' => array(
                        'route' => 'admin.service.create'
                    ),
                    'Entry' => array(
                        'route' => 'admin.service.edit',
                        'param' => array(
                            'service' => 1
                        )
                    ),
                    'List - Overview' => array(
                        'route' => 'admin.service.list'
                    )
                )
            ),
            'Access Control' => array(
                'route' => array(
                    'Grant' => array(
                        'route' => 'admin.access.create'
                    ),
                    'Entry' => array(
                        'route' => 'admin.access.edit',
                        'param' => array(
                            'access' => 1
                        )
                    ),
                    'Manage Requests' => array(
                        'route' => 'admin.access.pending'
                    ),
                    'Users in BG' => array(
                        'route' => 'admin.access.users'
                    ),
                    'Admins in BG' => array(
                        'route' => 'admin.access.admins'
                    )
                )
            ),
        ),
    );

    private $logOnMenu = array(
        'route' => 'login',
    );

    private $logOffMenu = array(
        'route' => 'logout',
    );

    public $menuList;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        TestServiceInterface $test,
        BluePagesServiceInterface $bluePages,
        BlueGroupsServiceInterface $blueGroups,
        BlueGroupsManageServiceInterface $blueGroupsManage
    )
    {


        // originalParameters

        $routeName = Route::currentRouteName();
        // dump($routeName);

        $routeInfo = Route::current();
        // dump($routeInfo);

        if (Auth::check()) {
            // The user is logged in...

            // prepare routes
            collect($this->userMenu)->each(function ($item, $key) use ($routeName, $routeInfo) {
                collect($item)->each(function ($item2, $key2)  use ($key, $routeName, $routeInfo) {
                    if ($key2 == 'Entry' || $key2 == 'Services Checklist Details') {
                        if ($item2['route'] == $routeName) {
                            // set parameters
                            $this->userMenu[$key][$key2]['param'] = $routeInfo->originalParameters();
                        } else {
                            // remove menu item
                            unset($this->userMenu[$key][$key2]);
                        }
                    }
                });
            });

            collect($this->adminMenu)->each(function ($item, $key) use ($routeName, $routeInfo) {
                collect($item)->each(function ($item2, $key2)  use ($key, $routeName, $routeInfo) {
                    collect($item2)->each(function ($item3, $key3)  use ($key, $key2, $routeName, $routeInfo) {
                        collect($item3)->each(function ($item4, $key4)  use ($key, $key2, $key3, $routeName, $routeInfo) {
                            if ($key4 == 'Entry' || $key4 == 'Services Checklist Details') {
                                if ($item4['route'] == $routeName) {
                                    // set parameters
                                    $this->adminMenu[$key][$key2][$key3][$key4]['param'] = $routeInfo->originalParameters();
                                } else {
                                    // remove menu item
                                    unset($this->adminMenu[$key][$key2][$key3][$key4]);
                                }
                            }
                        });
                    });
                });
            });

            // Get the currently authenticated user...
            $user = Auth::user();
            if($user->hasAdminRole()) {
                $this->menuList = array(
                    'Home' => $this->homeMenu,
                    'Checklists' => $this->userMenu,
                    'Admin' => $this->adminMenu,
                    'Log off' => $this->logOffMenu,
                );
            } else {
                $this->menuList = array(
                    'Home' => $this->homeMenu,
                    'Checklists' => $this->userMenu,
                    'Administrative Access' => array(
                        'route' => array(
                            'Request' => array(
                                'route' => 'access.request'
                            ),
                        )
                    ),
                    'Log off' => $this->logOffMenu,
                );
            }

            /*
            * Check which item is selected
            */
            foreach ($this->menuList as $key => $value) {
                if (is_array($value['route'])) {
                    foreach ($value['route'] as $subKey => $subValue) {
                        if (is_array($subValue['route'])) {
                            foreach ($subValue['route'] as $subSubKey => $subSubValue) {
                                if (is_array($subSubValue['route'])) {
                                    foreach ($subSubValue['route'] as $subSubSubKey => $subSubSubValue) {
                                        if ($subSubSubValue['route'] == Route::currentRouteName()) {
                                            $this->menuList[$key]['route'][$subKey]['route'][$subSubKey]['route'][$subSubSubKey]['selected'] = true;

                                            // open group
                                            $this->menuList[$key]['expanded'] = true;

                                            // open sub group
                                            $this->menuList[$key]['route'][$subKey]['expanded'] = true;

                                            // open sub sub group
                                            $this->menuList[$key]['route'][$subKey]['route'][$subSubKey]['expanded'] = true;
                                        }
                                    }
                                } else {
                                    if ($subSubValue['route'] == Route::currentRouteName()) {
                                        $this->menuList[$key]['route'][$subKey]['route'][$subSubKey]['selected'] = true;

                                        // open group
                                        $this->menuList[$key]['expanded'] = true;

                                        // open sub group
                                        $this->menuList[$key]['route'][$subKey]['expanded'] = true;
                                    }
                                }
                            }
                        } else {
                            if ($subValue['route'] == Route::currentRouteName()) {
                                $this->menuList[$key]['route'][$subKey]['selected'] = true;

                                // open group
                                $this->menuList[$key]['expanded'] = true;
                            }
                        }
                    }
                } else {
                    if ($value['route'] == Route::currentRouteName()) {
                        $this->menuList[$key]['selected'] = true;
                    }
                }
            }
        } else {
            // The user is not logged in...
            $this->menuList = array(
                'Home' => $this->homeMenu,
                'Log on' => $this->logOnMenu,
            );
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.navigation');
    }
}
