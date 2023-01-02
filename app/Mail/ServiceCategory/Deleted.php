<?php

namespace App\Mail\ServiceCategory;

class Deleted extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.serviceCategory.deleted', ['serviceCategory' => $this->request->id]);

        return $this->markdown('emails.serviceCategory.deleted');
    }
}
