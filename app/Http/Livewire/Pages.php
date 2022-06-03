<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

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
        $this->resetValidation();
        $this->reset();
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
        $this->resetValidation();
        $this->reset();

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
        $this->slug = Str::slug($value);
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
            Page::defaultHome()->update([
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
            Page::default404()->update([
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
        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'New Page :D',
            'eventMessage' => 'A new page has been created!'
        ]);
        $this->reset();
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
        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'Updated Page :D',
            'eventMessage' => 'The page "' . $this->title . '" has been updated!'
        ]);
        $this->reset();
    }

    /**
     * delete a page
     *
     * @return void
     */
    public function delete()
    {
        Page::destroy($this->modelId);
        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'Page Deleted :,(',
            'eventMessage' => 'The page "' . $this->modelId . '" has been deleted!'
        ]);
        $this->reset();
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
