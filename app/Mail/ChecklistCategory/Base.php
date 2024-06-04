<?php

namespace App\Mail\ChecklistCategory;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChecklistCategory;

class Base extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public $requestEditUrl;

    public $previewUrl;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function __construct(ChecklistCategory $checklistCategory)
    {
        $this->request = $checklistCategory;

        $this->requestEditUrl = route('admin.checklist.overviewForChecklist', ['checklist' => $this->request->checklist_id]);
    }
}
