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

                    <div class="flex justify-center items-center">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded-full">
                            <span>選択</span>
                        </label>
                    </div>

                    <div>投票数: <span id="vote-count-{{ $option->id }}">{{ $option->vote_count }}</span></div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="fixed inset-x-0 bottom-0 px-10 py-4 bg-sky-300 shadow">
            <div class="flex justify-between">
                <!-- 投票を終了ボタン -->
                <a href="{{ route('index') }}" class="flex-1 text-center text-white bg-gray-400 border-0 py-4 px-5 mr-2 focus:outline-none hover:bg-gray-500 rounded-lg">投票を終了</a>

                <!-- 投票ボタン -->
                <button class="flex-1 text-white bg-teal-500 border-0 py-4 px-5 ml-2 focus:outline-none hover:bg-teal-600 rounded-lg">投票</button>
            </div>
        </div>
    </section>
</x-app-layout>