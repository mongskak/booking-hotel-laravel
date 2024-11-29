<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class bookingCheckOutToday extends Component
{
    public $bookingStatus;
    /**
     * Create a new component instance.
     */
    public function __construct($bookingStatus)
    {
        $this->bookingStatus = $bookingStatus;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.booking-check-out-today');
    }
}