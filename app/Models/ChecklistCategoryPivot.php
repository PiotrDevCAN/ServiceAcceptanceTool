<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChecklistCategoryPivot extends Pivot
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
    protected $table = 'checklist_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'in_scope',
        'status'
    ];
}
