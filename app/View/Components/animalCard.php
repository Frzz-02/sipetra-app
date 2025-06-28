<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class animalCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $animal_name, $animal_birth, $animal_img;
    
    
    public function __construct($name, $birth, $img)
    {
        $this->animal_name = $name;
        $this->animal_birth = $birth;
        $this->animal_img = $img;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.animal-card');
    }
}
