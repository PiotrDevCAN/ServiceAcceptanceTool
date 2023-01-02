<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use Touhidurabir\Filterable\Filterable;

class Checklist extends Model
{
    use HasFactory;
    // use Filterable;

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
    protected $table = 'Checklists';

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
        'account_id',
        'name',
        'type',
        'duplicated_from'
    ];

    protected $appends = ['completed_pct', 'not_completed_pct', 'entry_url'];
    // protected $appends = ['completed_pct', 'not_completed_pct', 'duplicated_from'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
//         'delayed' => false,
    ];

    public function getEntryUrlAttribute()
    {
        $referer = request()->headers->get('referer');
        $adminSection = Str::contains($referer, 'admin');

        if (!is_null($this->id)) {
            if ($adminSection) {
                $routeName = 'admin.checklist.edit';
            } else {
                $routeName = 'checklist.edit';
            }
        } else {
            if ($adminSection) {
                $routeName = 'admin.checklist.create';
            } else {
                $routeName = 'checklist.create';
            }
        }
        return route($routeName, $this);
    }

    public static $limit = 10;

    public static function getWithPredicates($predicates, $page = 1)
    {
        $columns = array(
            'id', 'account_id'
        );

        // $data = Cache::remember('Checklist.getWithPredicates'.serialize($predicates).$page.static::$limit, 33660, function() use ($predicates, $columns)
        // {
            return self::select($columns)
                ->where($predicates)
                // ->paginate(static::$limit);
                ->get();
        // });

        // return $data;
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['account', 'categories', 'services', 'inScopeNo', 'inScopeYes', 'notInScope'];
    // protected $with = ['inScopeNo'];

    // protected $withCount = ['inScopeNo', 'inScopeYes', 'notInScope'];
    // protected $withCount = ['inScopeNo', 'checklistCategoriesInScopeYes', 'checklistCategoriesCompleted'];
    // protected $withCount = ['inScopeNo', 'inScopeYes', 'notInScope', 'checklistCategoriesInScopeYes', 'checklistCategoriesCompleted'];

    /**
     * Get the account that owns the checklist.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * The categories that belong to the checklist.
     */
    public function categories()
    {
        return $this->belongsToMany(ServiceCategory::class, 'checklist_categories', 'checklist_id', 'category_id')
            ->withPivot('id', 'in_scope', 'status');
    }

    /**
     * The services that belong to the checklist.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'checklist_services', 'checklist_id', 'service_id')
            ->withPivot('id', 'status', 'evidence', 'completition_date', 'user_input');
    }

    /**
     * The completed services that belong to the checklist.
     */
    public function inScopeNo()
    {
        return $this->belongsToMany(Service::class, 'checklist_services', 'checklist_id', 'service_id')
            ->withPivot('id', 'status', 'evidence', 'completition_date', 'user_input')
            ->wherePivot('status', '=', Service::IN_SCOPE_NO);
    }

    /**
     * The not completed services that belong to the checklist.
     */
    public function inScopeYes()
    {
        return $this->belongsToMany(Service::class, 'checklist_services', 'checklist_id', 'service_id')
            ->withPivot('id', 'status', 'evidence', 'completition_date', 'user_input')
            ->wherePivot('status', '=', Service::IN_SCOPE_YES);
    }

    /**
     * The services not in scope that belong to the checklist.
     */
    public function notInScope()
    {
        return $this->belongsToMany(Service::class, 'checklist_services', 'checklist_id', 'service_id')
            ->withPivot('id', 'status', 'evidence', 'completition_date', 'user_input')
            ->wherePivot('status', '=', Service::IN_SCOPE_NOT_IN_SCOPE);
    }

    public function getCompletedPctAttribute($value)
    {
        if (($this->in_scope_yes_count + $this->in_scope_no_count) != 0) {
            return round((($this->in_scope_yes_count / ($this->in_scope_yes_count + $this->in_scope_no_count)) * 100), 2);
        } else {
            return 0;
        }
    }

    public function getNotCompletedPctAttribute($value)
    {
        if (($this->in_scope_yes_count + $this->in_scope_no_count) != 0) {
            return round((($this->in_scope_no_count / ($this->in_scope_yes_count + $this->in_scope_no_count)) * 100), 2);
        } else {
            return 0;
        }
    }

    // Accessors
    // public function getDuplicatedFromAttribute() {
    //     return $this->duplicated_from;
    // }

    // Mutators
    // public function setDuplicatedFromAttribute($value)
    // {
    //     $this->attributes['duplicated_from'] = $value;
    // }

    public function checklistServices()
    {
        return $this->hasMany(ChecklistService::class, 'checklist_id', 'id');
    }

    public function checklistCategories()
    {
        return $this->hasMany(ChecklistCategory::class, 'checklist_id', 'id');
    }

    public function checklistCategoriesInScopeNo()
    {
        return $this->hasMany(ChecklistCategory::class, 'checklist_id', 'id')
            ->where('in_scope', '=', ServiceCategory::IN_SCOPE_NO);
    }

    public function checklistCategoriesInScopeYes()
    {
        return $this->hasMany(ChecklistCategory::class, 'checklist_id', 'id')
            ->where('in_scope', '=', ServiceCategory::IN_SCOPE_YES);
    }

    public function checklistCategoriesCompleted()
    {
        return $this->hasMany(ChecklistCategory::class, 'checklist_id', 'id')
            ->where('status', '=', ServiceCategory::STATUS_COMPLETE);
    }

    public function checklistCategoriesNotCompleted()
    {
        return $this->hasMany(ChecklistCategory::class, 'checklist_id', 'id')
            ->where('status', '=', ServiceCategory::STATUS_NOT_COMPLETE);
    }
}
