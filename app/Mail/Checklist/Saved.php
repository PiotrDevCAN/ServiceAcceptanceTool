<?php

namespace App\Mail\Checklist;

class Saved extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklist.saved', ['checklist' => $this->request->id]);

        return $this->markdown('emails.checklist.saved');
    }
}
