<?php

namespace App\Mail\ServiceCategory;

class Created extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceCategory.created', ['serviceCategory' => $this->request->id]);

        return $this->markdown('emails.serviceCategory.created');
    }
}
