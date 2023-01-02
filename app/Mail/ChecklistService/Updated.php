<?php

namespace App\Mail\ChecklistService;

class Updated extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistService.updated', ['checklistService' => $this->request->id]);

        return $this->markdown('emails.checklistService.updated');
    }
}
