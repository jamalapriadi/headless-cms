<?php

namespace App\View\Components\PostBlocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextBlock extends Component
{
    /**
     * Create a new component instance.
     */
    public $blockId;
    public $content;

    public function __construct($blockId)
    {
        $this->blockId = $blockId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-blocks.text-block');
    }
}
