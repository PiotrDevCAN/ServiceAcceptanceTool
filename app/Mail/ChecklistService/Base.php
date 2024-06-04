<?php

namespace App\Mail\ChecklistService;

use App\Models\Checklist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChecklistService;

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
    public function __construct(ChecklistService $checklistService)
    {
        $this->request = $checklistService;

        $this->requestEditUrl = route('admin.checklist.overviewForChecklist', ['checklist' => $this->request->checklist_id]);
    }
}
