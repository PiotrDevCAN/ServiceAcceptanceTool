<?php

namespace App\Mail\Checklist;

class Created extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklist.created', ['checklist' => $this->request->id]);

        return $this->markdown('emails.checklist.created');
    }
}
