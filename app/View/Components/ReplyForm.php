<?php

namespace App\View\Components;

use App\Models\Profile;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ReplyForm extends Component
{
    public Profile $profile;
    /**
     * Create a new component instance.
     */
    public function __construct(public \App\Models\Post $post)
    {
        $this->profile = Auth::user()->profile;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reply-form');
    }
}
