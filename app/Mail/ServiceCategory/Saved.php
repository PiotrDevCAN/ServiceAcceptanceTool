<?php

namespace App\Mail\ServiceCategory;

class Saved extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceCategory.saved', ['serviceCategory' => $this->request->id]);

        return $this->markdown('emails.serviceCategory.saved');
    }
}
