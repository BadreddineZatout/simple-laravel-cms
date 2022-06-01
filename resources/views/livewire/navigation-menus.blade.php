<div class="p-6">
    <div class="flex items-centre justify-end px-4 py-3 sm:py-6 text-right">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-jet-button>
    </div>

    {{-- The data table --}}

    <div class="flex flex-col">
        <div class="my-2 overflow-x-auto sm:mx-6 lg:mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="table-head">Type</th>
                                <th class="table-head">Sequesnce</th>
                                <th class="table-head">Label</th>
                                <th class="table-head">URL</th>
                                <th class="table-head"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($navigationMenus->count())
                                @foreach ($navigationMenus as $navigationMenu)
                                    <tr>
                                        <td class="table-data">
                                            {{ $navigationMenu->type }}
                                        </td>
                                        <td class="table-data">{{ $navigationMenu->sequence }}</td>
                                        <td class="table-data">{{ $navigationMenu->label }}</td>
                                        <td class="table-data">
                                            <a href="{{ URL::to('/' . $navigationMenu->slug) }}" target="_blank"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                {{ $navigationMenu->slug }}
                                            </a>
                                        </td>
                                        <td class="table-data flex justify-end gap-2">
                                            <x-jet-button wire:click="updateShowModal({{ $navigationMenu->id }})">
                                                {{ __('Edit') }}
                                            </x-jet-button>
                                            <x-jet-danger-button
                                                wire:click="deleteShowModal({{ $navigationMenu->id }})">
                                                {{ __('Delete') }}
                                                </x-jet-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="table-data" colspan="4">No Results Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br />
    {{ $navigationMenus->links() }}

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Save Page') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="label" value="{{ __('Label') }}" />
                <x-jet-input id="label" class="block mt-1 w-full" type="text" name="label"
                    wire:model.debounce.500ms="label" />
                @error('label')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 py-3 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        http://localhost:8000/
                    </span>
                    <input wire:model.lazy="slug"
                        class="form-input flex-1 block w-full pl-1 rounded-none border rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        placeholder="url-slug">
                </div>
                @error('slug')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="sequence" value="{{ __('Sequence') }}" />
                <x-jet-input id="sequence" class="block mt-1 w-full" type="number" name="sequence"
                    wire:model.debounce.500ms="sequence" />
                @error('sequence')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <select name="type" id="type"
                    class="block appearance-none w-full border-gray-300 py-3 px-4 rounded  leading-tight focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    wire:model="type">
                    <option value="Sidebar">Sidebar</option>
                    <option value="Top">Top</option>
                </select>
                @error('type')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-danger-button class="ml-3" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-danger-button>
            @else
                <x-jet-danger-button class="ml-3" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-danger-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Delete Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDelete">
        <x-slot name="title">
            {{ __('Delete Page') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item? Once the page is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDelete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
