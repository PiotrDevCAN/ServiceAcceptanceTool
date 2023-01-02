<?php

namespace App\Mail\Service;

class Created extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.service.created', ['service' => $this->request->id]);

        return $this->markdown('emails.service.created');
    }
}
