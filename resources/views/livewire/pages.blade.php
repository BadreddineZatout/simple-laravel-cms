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
                                <th class="table-head">Title</th>
                                <th class="table-head">Link</th>
                                <th class="table-head">Content</th>
                                <th class="table-head"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($pages->count())
                                @foreach ($pages as $page)
                                    <tr>
                                        <td class="table-data">
                                            {{ $page->title }}
                                            {!! $page->is_default_home ? '<span class="text-green-600 text-sm font-bold">[Default Home Page]</span>' : '' !!}
                                            {!! $page->is_default_404 ? '<span class="text-red-600 text-sm font-bold">[Default 404 Error Page]</span>' : '' !!}
                                        </td>
                                        <td class="table-data">
                                            <a href="{{ URL::to('/' . $page->slug) }}" target="_blank"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                {{ $page->slug }}
                                            </a>
                                        </td>
                                        <td class="table-data">{!! \Illuminate\Support\Str::limit($page->content, 50, '...') !!}</td>
                                        <td class="table-data flex justify-end gap-2">
                                            <x-jet-button wire:click="updateShowModal({{ $page->id }})">
                                                {{ __('Edit') }}
                                            </x-jet-button>
                                            <x-jet-danger-button wire:click="deleteShowModal({{ $page->id }})">
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
    {{ $pages->links() }}

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Save Page') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title"
                    wire:model.debounce.500ms="title" />
                @error('title')
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
                <label>
                    <input class="form-checkbox" type="checkbox" value="{{ $isDefaultHome }}"
                        wire:model="isDefaultHome">
                    <span class="ml-2 text-sm text-gray-600">Set as the default home page</span>
                </label>
            </div>
            <div class="mt-4">
                <label>
                    <input class="form-checkbox" type="checkbox" value="{{ $isDefault404 }}"
                        wire:model="isDefault404">
                    <span class="ml-2 text-sm text-red-600">Set as the default 404 error page</span>
                </label>
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Content') }}" />
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                            <trix-editor class="trix-content" x-ref="trix" wire:model.debounce.500ms="content"
                                wire:key="trix-content-unique-key"></trix-editor>
                        </div>
                    </div>
                </div>
                @error('content')
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
            {{ __('Are you sure you want to delete this page? Once the page is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDelete')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete Page') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
