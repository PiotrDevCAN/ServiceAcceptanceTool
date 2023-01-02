<?php

namespace App\Mail\Service;

class Deleted extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.service.deleted', ['service' => $this->request->id]);

        return $this->markdown('emails.service.deleted');
    }
}
