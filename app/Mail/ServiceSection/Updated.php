<?php

namespace App\Mail\ServiceSection;

class Updated extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceSection.updated', ['serviceSection' => $this->request->id]);

        return $this->markdown('emails.serviceSection.updated');
    }
}
