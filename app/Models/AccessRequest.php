<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use Touhidurabir\Filterable\Filterable;

class AccessRequest extends Model
{
    // use Filterable;

    const STATUS_PENDING = 'Pending';
    const STATUS_APPROVED = 'Approved';
    const STATUS_REJECTED = 'Rejected';

    const TYPE_USER = 'User';
    const TYPE_ADMIN = 'Administrator';

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
    protected $table = 'Access_Requests';

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
        'employee',
        'employee_notes_id',
        'employee_intranet_id',
        'status',
        'type',
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
            return route('admin.access.edit', $this);
        } else {
            return route('admin.access.create');
        }
    }

    // public static $limit = 10;

    // public static function getWithPredicates($predicates, $page = 1)
    // {
    //     $columns = array(
    //         'id', 'category_id', 'section_id', 'name'
    //     );

    //     // $data = Cache::remember('ServiceCategory.getWithPredicates'.serialize($predicates).$page.static::$limit, 33660, function() use ($predicates, $columns)
    //     // {
    //         // return self::select($columns)
    //             // ->where($predicates)
    //             // ->paginate(static::$limit);
    //             // ->get();
    //         return DB::table('services')
    //             ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
    //             ->join('service_sections', 'services.section_id', '=', 'service_sections.id')
    //             ->select('services.*', 'service_categories.name as category_name', 'service_sections.name as section_name')
    //             ->where($predicates)
    //             ->get();
    //     // });

    //     // return $data;
    // }
}
