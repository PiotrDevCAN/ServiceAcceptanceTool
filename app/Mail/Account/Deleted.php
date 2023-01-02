<?php

namespace App\Mail\Account;

class Deleted extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.account.deleted', ['account' => $this->request->id]);

        return $this->markdown('emails.account.deleted');
    }
}
