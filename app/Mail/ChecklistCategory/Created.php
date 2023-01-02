<?php

namespace App\Mail\ChecklistCategory;

class Created extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistCategory.created', ['checklistCategory' => $this->request->id]);

        return $this->markdown('emails.checklistCategory.created');
    }
}
