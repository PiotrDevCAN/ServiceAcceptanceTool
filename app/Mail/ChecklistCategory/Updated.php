<?php

namespace App\Mail\ChecklistCategory;

class Updated extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistCategory.updated', ['checklistCategory' => $this->request->id]);

        return $this->markdown('emails.checklistCategory.updated');
    }
}
