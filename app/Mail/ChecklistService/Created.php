<?php

namespace App\Mail\ChecklistService;

class Created extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistService.created', ['checklistService' => $this->request->id]);

        return $this->markdown('emails.checklistService.created');
    }
}
