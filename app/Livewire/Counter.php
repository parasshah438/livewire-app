<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    //Public properties are automatically available in the view
    public $count = 0;

    //Methods can be called from the view using wire:click
    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        //Prevent negative values
        if ($this->count > 0) {
            $this->count--;
        }
    }

    public function resetCounter()
    {
        $this->count = 0;
    }

    //The render method returns the view
    public function render()
    {
        return view('livewire.counter');
    }
}
