<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FileInput extends Component
{
    /**
     * The name of the input field.
     *
     * @var string
     */
    public $name;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.file-input');
    }
}
