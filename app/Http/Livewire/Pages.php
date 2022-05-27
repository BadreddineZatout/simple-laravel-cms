<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;

    public $modalFormVisible = false;
    public $modalConfirmDelete = false;
    public $modelId;
    public $title;
    public $slug;
    public $content;

    /**
     * validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')->ignore($this->modelId)],
            'content' => 'required',
        ];
    }

    /**
     * the livewire mount function
     *
     * @return void
     */
    public function mount()
    {
        $this->resetPage();
    }

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
     * Show the form modal
     * of the update function
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->modelId = $id;
        $data = Page::find($this->modelId);
        $this->modalFormVisible = true;
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
    }

    /**
     * Show the modal of
     * the delete function
     *
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDelete = true;
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
     * read pages from database
     *
     * @return void
     */
    public function read()
    {
        return Page::paginate(5);
    }

    /**
     * update an existing page
     *
     * @param  mixed $id
     * @return void
     */
    public function update()
    {
        $this->validate();
        Page::where('id', $this->modelId)
            ->update([
                'title' => $this->title,
                'slug' => $this->slug,
                'content' => $this->content
            ]);
        $this->cleanAfterUpdate();
    }

    /**
     * Reset vars after page update
     *
     * @return void
     */
    public function cleanAfterUpdate()
    {
        $this->modelId = null;
        $this->cleanAfterCreate();
    }

    /**
     * delete a page
     *
     * @return void
     */
    public function delete()
    {
        Page::destroy($this->modelId);
        $this->modalConfirmDelete = false;
        $this->modelId = null;
    }

    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages', [
            'pages' => $this->read()
        ]);
    }
}
