<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MailBanner extends Component
{
    public $image_link;

    /**
     * Create a new component instance.
     *
     * @param $image_link
     */
    public function __construct($imageLink)
    {
        $this->image_link = $imageLink;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.mail-banner');
    }
}
