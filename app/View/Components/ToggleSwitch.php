<?php

// app/View/Components/ToggleSwitch.php

namespace App\View\Components;

use Illuminate\View\Component;

class ToggleSwitch extends Component
{
    public $id;
    public $checked;
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $checked = false, $url)
    {
        $this->id = $id;
        $this->checked = $checked;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.toggle-switch');
    }
}
