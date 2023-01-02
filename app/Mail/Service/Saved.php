<?php

namespace App\Mail\Service;

class Saved extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.service.saved', ['service' => $this->request->id]);

        return $this->markdown('emails.service.saved');
    }
}
