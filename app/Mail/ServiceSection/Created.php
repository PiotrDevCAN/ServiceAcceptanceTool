<?php

namespace App\Mail\ServiceSection;

class Created extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceSection.created', ['serviceSection' => $this->request->id]);

        return $this->markdown('emails.serviceSection.created');
    }
}
