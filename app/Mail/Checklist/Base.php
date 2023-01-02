<?php

namespace App\Mail\Checklist;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Checklist;

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
    public function __construct(Checklist $checklist)
    {
        $this->request = $checklist;

        $this->requestEditUrl = route('admin.checklist.edit', ['checklist' => $this->request->id]);
    }
}
