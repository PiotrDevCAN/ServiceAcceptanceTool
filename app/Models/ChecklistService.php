<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChecklistService extends Model
{
    use HasFactory;
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
    protected $table = 'Checklist_Services';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completition_date' => 'datetime:Y-m-d',
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
        'checklist_id',
        'service_id',
        'status',
        'evidence',
        'completition_date',
        'user_input'
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
        $referer = request()->headers->get('referer');
        return $referer;
    }

    public static $limit = 10;

    public static function getWithPredicates($predicates, $page = 1)
    {
        $columns = array(
            'id',
            'checklist_id',
            'service_id',
            'status',
            'evidence',
            'completition_date',
            'user_input'
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
    protected $with = ['service'];

    /**
     * Get the service associated with the pivot.
     */
    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
