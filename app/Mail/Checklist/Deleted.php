<?php

namespace App\Mail\Checklist;

class Deleted extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklist.deleted', ['checklist' => $this->request->id]);

        return $this->markdown('emails.checklist.deleted');
    }
}
