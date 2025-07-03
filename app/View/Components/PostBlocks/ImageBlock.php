<?php

namespace App\View\Components\PostBlocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageBlock extends Component
{
    public $blockId, $content;
    public $url = '';

    public function __construct($blockId)
    {
        $this->blockId = $blockId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-blocks.image-block');
    }
}
