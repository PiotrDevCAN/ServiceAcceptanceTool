<?php

namespace App\Mail\Account;

class Updated extends Base
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->previewUrl = route('mailable.account.updated', ['account' => $this->request->id]);

        return $this->markdown('emails.account.updated');
    }
}
