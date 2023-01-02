<?php

namespace App\Mail\ServiceCategory;

class Updated extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceCategory.updated', ['serviceCategory' => $this->request->id]);

        return $this->markdown('emails.serviceCategory.updated');
    }
}
