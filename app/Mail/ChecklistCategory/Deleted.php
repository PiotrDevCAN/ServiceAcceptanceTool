<?php

namespace App\Mail\ChecklistCategory;

class Deleted extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.checklistCategory.deleted', ['checklistCategory' => $this->request->id]);

        return $this->markdown('emails.checklistCategory.deleted');
    }
}
