<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSection extends Model
{
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
    protected $table = 'Service_Sections';

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
            return route('admin.section.edit', $this);
        } else {
            return route('admin.section.create');
        }
    }

    public static $limit = 10;

    public static function getWithPredicates($predicates, $page = 1)
    {
        $columns = array(
            'id', 'name'
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

    public static function sections()
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
     * Get the items for the section.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'section_id', 'id');
    }

    /**
     * The checklists that belong to the category.
     */
    public function checklists()
    {
        return $this->belongsToMany(Checklist::class, 'checklist_services', 'service_id', 'checklist_id');
    }
}
