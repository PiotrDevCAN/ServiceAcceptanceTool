<?php

namespace App\Mail\ChecklistService;

class Saved extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistService.saved', ['checklistService' => $this->request->id]);

        return $this->markdown('emails.checklistService.saved');
    }
}
