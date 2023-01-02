<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use Touhidurabir\Filterable\Filterable;

class Service extends Model
{
    // use Filterable;

    const IN_SCOPE_YES = 'Yes';
    const IN_SCOPE_NO = 'No';
    const IN_SCOPE_NOT_IN_SCOPE = 'Not in scope';

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
    protected $table = 'Services';

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
        'category_id',
        'section_id',
        'name'
    ];

    protected $appends = ['entry_url'];

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
            return route('admin.service.edit', $this);
        } else {
            return route('admin.service.create');
        }
    }

    public static $limit = 10;

    public static function getWithPredicates($predicates, $page = 1)
    {
        $columns = array(
            'id', 'category_id', 'section_id', 'name'
        );

        // $data = Cache::remember('ServiceCategory.getWithPredicates'.serialize($predicates).$page.static::$limit, 33660, function() use ($predicates, $columns)
        // {
            // return self::select($columns)
                // ->where($predicates)
                // ->paginate(static::$limit);
                // ->get();
            return DB::table('services')
                ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
                ->join('service_sections', 'services.section_id', '=', 'service_sections.id')
                ->select('services.*', 'service_categories.name as category_name', 'service_sections.name as section_name')
                ->where($predicates)
                ->get();
        // });

        // return $data;
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['category', 'section'];

    /**
     * Get the category that owns the service.
     */
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id', 'id');
    }

    public function categoryTTYes()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id', 'id')
            ->where('type', '=', ServiceCategory::TYPE_TT_YES);
    }

    public function categoryTTNo()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id', 'id')
            ->where('type', '=', ServiceCategory::TYPE_TT_NO);
    }

    /**
     * Get the section that owns the service.
     */
    public function section()
    {
        return $this->belongsTo(ServiceSection::class, 'section_id', 'id');
    }

    /**
     * Get the checklist services related to the service.
     */
    public function checklistServices()
    {
        return $this->hasMany(ChecklistService::class, 'service_id', 'id');
    }
}
