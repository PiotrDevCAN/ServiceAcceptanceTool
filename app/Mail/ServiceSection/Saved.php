<?php

namespace App\Mail\ServiceSection;

class Saved extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceSection.saved', ['serviceSection' => $this->request->id]);

        return $this->markdown('emails.serviceSection.saved');
    }
}
