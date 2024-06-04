<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Account extends Model
{
    // use Filterable;

    const STATE_TRANSITION = 'Transition';
    const STATE_TRANSFORMATION = 'Transformation';
    const STATE_GO_LIVE = 'Go Live';
    const STATES = array(self::STATE_TRANSITION, self::STATE_TRANSFORMATION, self::STATE_GO_LIVE);

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'ibmi';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Accounts';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'go_live_date' => 'datetime:Y-m-d',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'transition_state',
        'go_live_date',
        'account_dpe',
        'account_dpe_notes_id',
        'account_dpe_intranet_id',
        'tt_focal',
        'tt_focal_notes_id',
        'tt_focal_intranet_id',
        'created_by'
    ];

    protected $appends = ['escaped_name', 'entry_url'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
//         'delayed' => false,
    ];

    /**
     * Get the account's escaped name.
     *
     * @param  string  $value
     * @return string
     */
    public function getEscapedNameAttribute()
    {
        return Str::snake($this->name);
    }

    public function getEntryUrlAttribute()
    {
        if (!is_null($this->id)) {
            return route('admin.account.edit', $this);
        } else {
            return route('admin.account.create');
        }
    }

    public static $limit = 10;

    public static function getWithPredicates($predicates, $page = 1)
    {
        $columns = array(
            'id',
            'name',
            'transition_state',
            'go_live_date',
            'account_dpe',
            'account_dpe_notes_id',
            'account_dpe_intranet_id',
            'tt_focal',
            'tt_focal_notes_id',
            'tt_focal_intranet_id',
            'created_by'
        );

        // $data = Cache::remember('ServiceCategory.getWithPredicates'.serialize($predicates).$page.static::$limit, 33660, function() use ($predicates, $columns)
        // {
            return self::select($columns)
                ->where($predicates)
                // ->paginate(static::$limit);
                ->get();
        // });

        return $data;
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['checklists'];

    protected $withCount = ['checklists'];

    /**
     * Get the checklist associated with the account.
     */
    // public function checklist()
    // {
    //     return $this->hasOne(Checklist::class, 'account_id', 'id');
    // }

    /**
     * Get the checklists associated with the account.
     */
    public function checklists()
    {
        return $this->hasMany(Checklist::class, 'account_id', 'id');
    }

    /**
     * Get the checklist associated with the account.
     */
    // public function userChecklist()
    // {
    //     // Get the currently authenticated user...
    //     $user = Auth::user();
    //     $userMail = $user->mail[0];

    //     return $this->hasOne(Checklist::class, 'account_id', 'id')
    //         ->where('created_by', '=', $userMail);
    // }

    /**
     * Get the checklists associated with the account.
     */
    public function userChecklists()
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $userMail = $user->mail[0];

        return $this->hasMany(Checklist::class, 'account_id', 'id')
            ->withCount('inScopeNo', 'checklistCategoriesInScopeYes', 'checklistCategoriesCompleted')
            ->where('created_by', '=', $userMail);
    }
}
