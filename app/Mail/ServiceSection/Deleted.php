<?php

namespace App\Mail\ServiceSection;

class Deleted extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceSection.deleted', ['serviceSection' => $this->request->id]);

        return $this->markdown('emails.serviceSection.deleted');
    }
}
