<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $id;
    public $submitButton;

    /**
     * Create a new component instance.
     *
     * @param String $title
     * @param String $id
     * @param String $submitButton
     */
    public function __construct($title, $id, $submitButton)
    {
        $this->title = $title;
        $this->id = $id;
        $this->submitButton = $submitButton;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
