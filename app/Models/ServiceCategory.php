<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    // public $arg1= null;

    // use Filterable;

    const IN_SCOPE_YES = 'Yes';
    const IN_SCOPE_NO = 'No';

    const STATUS_COMPLETE = 'Complete';
    const STATUS_NOT_COMPLETE = 'Not Complete';

    const TYPE_TT_YES = 'T&T_YES';
    const TYPE_TT_NO = 'T&T_NO';

    const TYPES = [
        [
            'name' => 'Non T&T',
            'type' => 'T&T_NO',
        ],
        [
            'name' => 'T&T',
            'type' => 'T&T_YES',
        ]
    ];

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
    protected $table = 'Service_Categories';

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
        'parent_id',
        'name',
        'sequence',
        'type'
    ];

    protected $appends = ['entry_url'];
    // protected $appends = ['services_in_scope_yes', 'services_in_scope_no', 'services_not_in_scope', 'ready_to_complete', 'entry_url'];

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
        if (!is_null($this->id)) {
            return route('admin.category.edit', $this);
        } else {
            return route('admin.category.create');
        }
    }

    // public function getServicesInScopeYesAttribute()
    // {
    //     return 'test value yes '.$this->arg1;
    // }

    // public function getServicesInScopeNoAttribute()
    // {
    //     return 'test value no '.$this->arg1;
    // }

    // public function getServicesNotInScopeAttribute()
    // {
    //     return 'test value not in scope '.$this->arg1;
    // }

    // public function getReadyToCompleteAttribute()
    // {
    //     return 'test value ready to complete '.$this->arg1;
    // }

    public static $limit = 10;

    public static function getWithPredicates($predicates, $page = 1)
    {
        $columns = array(
            'id', 'parent_id', 'name', 'sequence', 'type'
        );

        // $data = Cache::remember('ServiceCategory.getWithPredicates'.serialize($predicates).$page.static::$limit, 33660, function() use ($predicates, $columns)
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
    // protected $with = ['parent'];
    // protected $with = ['children'];

    // protected $withCount = ['children'];

    public static function categories()
    {
        // $data = Cache::remember('Location.locations', 33660, function()
        // {
            return self::select('id', 'name')
                ->distinct()
                ->orderBy('name', 'asc')
                ->get();
        // });

        // return $data;
    }

    /**
     * Get the items for the category.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id', 'id');
    }

    /**
     * The checklists that belong to the category.
     */
    public function checklists()
    {
        return $this->belongsToMany(Checklist::class, 'checklist_categories', 'category_id', 'checklist_id');
    }

    /**
     * Get the child categories for the category.
     */
    public function children()
    {
        return $this->hasMany(ServiceCategory::class, 'parent_id', 'id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the parent category that owns the category.
     */
    public function parent()
    {
        return $this->belongsTo(ServiceCategory::class, 'parent_id', 'id');
    }

        /**
     * Get the checklist categories related to the category.
     */
    public function checklistCategories()
    {
        return $this->hasMany(ChecklistCategory::class, 'category_id', 'id');
    }
}
