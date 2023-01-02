<?php

namespace App\Mail\Checklist;

class Updated extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklist.updated', ['checklist' => $this->request->id]);

        return $this->markdown('emails.checklist.updated');
    }
}
