<?php

namespace App\Mail\Account;

class Saved extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.account.saved', ['account' => $this->request->id]);

        return $this->markdown('emails.account.saved');
    }
}
