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
            ? Page::defaultHome()->first()
            : Page::where('slug', $urlslug)->first();
        if (!$page) {
            $page = Page::default404()->firstOrFail();
        }
        $this->title = $page->title;
        $this->content = $page->content;
    }

    public function render()
    {
        return view('livewire.front-page')->layout('layouts.my-app');
    }
}
