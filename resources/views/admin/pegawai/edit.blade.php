<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pegawai
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm rounded-lg p-6">
            @include('admin.pegawai.form', [
                'action' => route('admin.pegawai.update', $pegawai),
                'method' => 'PUT',
                'pegawai' => $pegawai,
                'buttonLabel' => 'Perbarui'
            ])
        </div>

    </div>
</x-app-layout>
