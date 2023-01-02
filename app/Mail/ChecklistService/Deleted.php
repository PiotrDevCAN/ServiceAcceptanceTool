<?php

namespace App\Mail\ChecklistService;

class Deleted extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistService.deleted', ['checklistService' => $this->request->id]);

        return $this->markdown('emails.checklistService.deleted');
    }
}
