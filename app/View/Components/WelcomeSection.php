<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WelcomeSection extends Component
{
    /**
     * @var mixed|string
     */
    public $url;
    public $heading;

    /**
     * Create a new component instance.
     *
     * @param null $url
     */
    public function __construct($url = null,$heading)
    {
        $this->url = $url;
        $this->heading = $heading;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.welcome-section');
    }
}
