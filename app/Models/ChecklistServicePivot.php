<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChecklistServicePivot extends Pivot
{
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
    protected $table = 'checklist_services';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completition_date' => 'datetime:Y-m-d',
    ];

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
        'user_input',
        'owner',
        'owner_notes_id',
        'owner_intranet_id'
    ];
}
