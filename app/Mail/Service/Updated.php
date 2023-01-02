<?php

namespace App\Mail\Service;

class Updated extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.service.updated', ['service' => $this->request->id]);

        return $this->markdown('emails.service.updated');
    }
}
