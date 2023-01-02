<?php

namespace App\Mail\Account;

class Created extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.account.created', ['account' => $this->request->id]);

        return $this->markdown('emails.account.created');
    }
}
