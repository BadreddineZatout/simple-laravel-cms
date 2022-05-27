<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class FrontPage extends Component
{
    public $title;
    public $content;

    /**
     * the livewire mount function
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function mount($urlslug = null)
    {
        $this->getContent($urlslug);
    }

    /**
     * get page content using the url slug
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function getContent($urlslug)
    {
        $page = empty($urlslug)
            ? Page::where('is_default_home', true)->first()
            : Page::where('slug', $urlslug)->first();
        if (!$page) {
            $page = Page::where('is_default_404', true)->firstOrFail();
        }
        $this->title = $page->title;
        $this->content = $page->content;
    }

    public function render()
    {
        return view('livewire.front-page')->layout('layouts.my-app');
    }
}
