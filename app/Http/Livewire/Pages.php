<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pages extends Component
{
    public $modalFormVisible = false;
    public $title;
    public $slug;
    public $content;

    /**
     * Show the form modal
     * of the create function.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    /**
     * validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')],
            'content' => 'required',
        ];
    }

    /**
     * runs when title value changes
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedTitle($value)
    {
        $this->slug = strtolower(str_replace(' ', '-', $value));
    }

    /**
     * create a new page
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Page::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content
        ]);
        $this->cleanAfterCreate();
    }

    /**
     * Reset vars after page create
     *
     * @return void
     */
    public function cleanAfterCreate()
    {
        $this->modalFormVisible = false;
        $this->title = "";
        $this->slug = "";
        $this->content = "";
    }

    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages');
    }
}
