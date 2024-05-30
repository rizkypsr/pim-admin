<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionButtons extends Component
{
    public $editRoute;

    public $deleteRoute;

    public $showRoute;

    /**
     * Create a new component instance.
     */
    public function __construct($editRoute, $deleteRoute, $showRoute)
    {
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
        $this->showRoute = $showRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action-buttons');
    }
}
