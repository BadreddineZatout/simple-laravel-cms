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
    public $isDefaultHome;
    public $isDefault404;

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
        if ($this->modelId) $this->cleanAfterUpdate();
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
        $this->isDefaultHome = $data->is_default_home;
        $this->isDefault404 = $data->is_default_404;
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
     * runs when isDefaultHome value changes
     *
     * @return void
     */
    public function updatedIsDefaultHome()
    {
        $this->isDefault404 = null;
    }

    /**
     * runs when isDefaul404 value changes
     *
     * @return void
     */
    public function updatedIsDefault404()
    {
        $this->isDefaultHome = null;
    }

    /**
     * Unassign the default home page in the pages table
     *
     * @return void
     */
    public function unassignDefaultHomePage()
    {
        if ($this->isDefaultHome) {
            Page::where('is_default_home', true)->update([
                'is_default_home' => null
            ]);
        }
    }

    /**
     * Unassign the default 404 page in the pages table
     *
     * @return void
     */
    public function unassignDefault404Page()
    {
        if ($this->isDefault404) {
            Page::where('is_default_404', true)->update([
                'is_default_404' => null
            ]);
        }
    }

    /**
     * get the model data
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_default_home' => $this->isDefaultHome,
            'is_default_404' => $this->isDefault404,
        ];
    }

    /**
     * create a new page
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        $this->unassignDefaultHomePage();
        $this->unassignDefault404Page();
        Page::create($this->modelData());
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
        $this->isDefaultHome = null;
        $this->isDefault404 = null;
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
        $this->unassignDefaultHomePage();
        $this->unassignDefault404Page();
        Page::where('id', $this->modelId)
            ->update($this->modelData());
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
