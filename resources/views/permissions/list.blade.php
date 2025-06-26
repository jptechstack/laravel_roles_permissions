<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions') }}
            </h2>
            @php
                $canCreate = auth()->user()->can('create permissions');
            @endphp
            <a href="{{ $canCreate ? route('permissions.create') : '#' }}"
            class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white transition
                    {{ $canCreate ? 'cursor-pointer hover:bg-slate-800' : 'opacity-50 cursor-not-allowed pointer-events-auto' }}"
            @if(!$canCreate) tabindex="-1" aria-disabled="true" @endif
            >
                Create
            </a>

        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

               <x-message></x-message>
               <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b">
                            <th class="px-6 py-3 text-left" width="60">#</th>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left" width="180">Created</th>
                            <th class="px-6 py-3 text-center" width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">{{$permission->id}}</td>
                                <td class="px-6 py-3 text-left">{{$permission->name}}</td>
                                <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($permission->created_at)->format('d/m/Y')}}</td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex gap-x-2">
                                    @php
                                        $canEdit = auth()->user()->can('edit permissions');
                                    @endphp
                                    <a href="{{ $canEdit ? route('permissions.edit', $permission->id) : '#' }}"
                                    class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white transition
                                            {{ $canEdit ? 'cursor-pointer hover:bg-slate-600' : 'opacity-50 cursor-not-allowed pointer-events-auto' }}"
                                    @if(!$canEdit) tabindex="-1" aria-disabled="true" @endif
                                    >
                                        Edit
                                    </a>

                                    @php
                                        $canDelete = auth()->user()->can('delete permissions');
                                    @endphp

                                    <a href="{{ $canDelete ? 'javascript:void(0);' : '#' }}"
                                    onclick="{{ $canDelete ? "deletePermission($permission->id)" : '' }}"
                                    class="bg-red-600 text-sm rounded-md px-3 py-2 text-white transition
                                            {{ $canDelete ? 'cursor-pointer hover:bg-red-500' : 'opacity-50 cursor-not-allowed pointer-events-auto' }}"
                                    @if(!$canDelete) tabindex="-1" aria-disabled="true" @endif
                                    >
                                        Delete
                                    </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
               </table>
            </div>
            <div class="my-3">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id) {
                if(confirm("Are you sure want to delete?")) {
                    $.ajax({
                        url: '{{ route("permissions.destroy")}}',
                        type: 'delete',
                        data: {id:id},
                        datatype: 'json',
                        headers: {
                            'x-csrf-token' : '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.href = '{{route("permissions.index")}}';
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
