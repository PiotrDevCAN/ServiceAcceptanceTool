<?php

namespace App\Mail\ServiceSection;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ServiceSection;

class Base extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public $requestEditUrl;

    public $previewUrl;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function __construct(ServiceSection $serviceSection)
    {
        $this->request = $serviceSection;

        $this->requestEditUrl = route('admin.section.edit', ['section' => $this->request->id]);
    }
}
