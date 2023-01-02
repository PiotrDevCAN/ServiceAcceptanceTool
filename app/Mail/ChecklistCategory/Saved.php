<?php

namespace App\Mail\ChecklistCategory;

class Saved extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistCategory.saved', ['checklistCategory' => $this->request->id]);

        return $this->markdown('emails.checklistCategory.saved');
    }
}
