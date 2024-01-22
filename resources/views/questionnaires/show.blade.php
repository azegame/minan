<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投票画面
        </h2>
    </x-slot>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap -mx-4 -mb-10 text-center">
                @foreach($options as $option)
                <div class="sm:w-1/2 mb-10 px-4">
                    <div class="rounded-lg h-64 overflow-hidden">
                        <img alt="content" class="object-cover object-center h-full w-full" src="https://dummyimage.com/1201x501">
                    </div>
                    <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-3">{{ $option->option_name}}</h2>
                    <p class="leading-relaxed text-base"></p>
                    <button class="vote-button flex mx-auto mt-6 text-white bg-blue-500 border-0 py-2 px-5 focus:outline-none hover:bg-blue-600 rounded"" data-option-id=" {{ $option->id }}">投票</button>
                    <div>投票数: <span id="vote-count-{{ $option->id }}">{{ $option->vote_count }}</span></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>