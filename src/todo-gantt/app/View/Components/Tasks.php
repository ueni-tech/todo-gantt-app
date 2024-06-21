<?php

namespace App\View\Components;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tasks extends Component
{
    public $project;
    public $tasks;

    /**
     * Create a new component instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->tasks = $project->tasks;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tasks');
    }
}
