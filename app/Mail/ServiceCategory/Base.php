<?php

namespace App\Mail\ServiceCategory;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ServiceCategory;

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
    public function __construct(ServiceCategory $serviceCategory)
    {
        $this->request = $serviceCategory;

        $this->requestEditUrl = route('admin.category.edit', ['category' => $this->request->id]);
    }
}
