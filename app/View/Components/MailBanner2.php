<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MailBanner2 extends Component
{
    public $image_url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($imageUrl)
    {
        $this->image_url = $imageUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.mail-banner2');
    }
}
