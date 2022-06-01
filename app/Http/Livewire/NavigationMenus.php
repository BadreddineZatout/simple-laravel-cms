<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\NavigationMenu;
use Illuminate\Validation\Rule;

class NavigationMenus extends Component
{
    use WithPagination;


    public $modalFormVisible = false;
    public $modalConfirmDelete = false;
    public $modelId;
    public $label;
    public $sequence = 1;
    public $type = 'Sidebar';
    public $slug;

    /**
     * validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'required',
            'slug' => 'required',
            'sequence' => ['required', 'numeric'],
            'type' => 'required',
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
        $data = NavigationMenu::find($this->modelId);
        $this->modalFormVisible = true;
        $this->label = $data->label;
        $this->type = $data->type;
        $this->slug = $data->slug;
        $this->sequence = $data->sequence;
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
    public function updatedLabel($value)
    {
        $this->slug = Str::slug($value);
    }

    /**
     * get the model data
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'sequence' => $this->sequence,
            'type' => $this->type,
            'label' => $this->label,
            'slug' => $this->slug,
        ];
    }

    /**
     * read pages from database
     *
     * @return void
     */
    public function read()
    {
        return NavigationMenu::paginate(5);
    }

    /**
     * create a new page
     *
     * @return void
     */
    public function create()
    {
        $this->validate();

        NavigationMenu::create($this->modelData());
        $this->reset();
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
        NavigationMenu::where('id', $this->modelId)
            ->update($this->modelData());
        $this->reset();
    }

    /**
     * delete a page
     *
     * @return void
     */
    public function delete()
    {
        NavigationMenu::destroy($this->modelId);
        $this->modalConfirmDelete = false;
        $this->modelId = null;
    }


    public function render()
    {
        return view('livewire.navigation-menus', [
            'navigationMenus' => $this->read()
        ]);
    }
}
