<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
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
     * get the sidebar links
     *
     * @return void
     */
    private function getSidebarLinks()
    {
        return NavigationMenu::where('type', 'Sidebar')->orderBy('sequence', 'asc')->get();
    }

    /**
     * get the top bar links
     *
     * @return void
     */
    private function getTopLinks()
    {
        if (Auth::check())
            return NavigationMenu::where('type', 'Top')->where('slug', '!=', 'login')->orderBy('sequence', 'asc')->get();
        return NavigationMenu::where('type', 'Top')->orderBy('sequence', 'asc')->get();
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
        return view('livewire.front-page', [
            'sidebarLinks' => $this->getSidebarLinks(),
            'topLinks' => $this->getTopLinks()
        ])->layout('layouts.my-app');
    }
}
