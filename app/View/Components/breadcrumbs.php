<?php

namespace App\View\Components;

use Illuminate\View\Component;

class breadcrumbs extends Component
{
    public $pages;

    public function __construct($pages)
    {
        $this->pages = $pages;
    }


    public function render()
    {
        return view('components.breadcrumbs');
    }
}
