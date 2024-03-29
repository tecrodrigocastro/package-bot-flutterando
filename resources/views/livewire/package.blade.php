<div>

    <div class="py-6 flex flex-col gap-5 max-h-1/3 ">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" text-gray-900 dark:text-gray-100">
                    <form wire:submit='addPackage'>
                        <div class="flex flex-row gap-4">
                            <input wire:model="name" placeholder="Nome do package" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"/>
                            <button type="submit" class=" px-4 rounded-lg bg-green-600 text-2xl font-bold">+</button>
                            @if (session()->has('message'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                    role="alert">
                                    <strong class="font-bold">{{ session('message') }}</strong>
                                </div>
                            @endif
                        </div>
                        <x-input-error :messages="$errors->get('name')" />
                    </form>
                </div>
            </div>

        </div>



        <div class="grid grid-cols-5 gap-3 overflow-auto">
            @foreach ($package_list as $package)
                <div
                    class="p-3 bg-white dark:bg-gray-600 rounded-lg dark:text-white text-black flex flex-row items-center justify-between">
                    <p class="truncate text-ellipsis">{{ $package->name }}</p>
                    <button wire:click="removePackage({{ $package->id }})" wire:confirm="Você tem certeza que quer deletar esse package?"
                        class="px-4 rounded-lg bg-red-900 text-2xl font-bold">-</button>
                </div>
            @endforeach
        </div>

    </div>

</div>
