<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('アンケート作成画面') }}
        </h2>
    </x-slot>
    <section class="text-gray-600 body-font relative">
        <form method="post" action="{{ route('questionnaires.store') }}">
            @csrf
            <div class=" container px-5 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div id="parentDiv" class="flex flex-wrap -m-2">
                        <div class="p-2 w-full">
                            <div class="relative">
                                <label for="questionnaires_name" class="leading-7 text-sm text-gray-600">アンケート名</label>
                                <input type="text" id="questionnaire_name" name="questionnaire_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- 公開オプション -->
                            <label class="flex items-center">
                                <input type="radio" name="publish_flag" value="public" class="form-radio h-5 w-5 text-blue-600" checked>
                                <span class="ml-2 text-gray-700">公開</span>
                            </label>

                            <!-- 非公開オプション -->
                            <label class="flex items-center">
                                <input type="radio" name="publish_flag" value="private" class="form-radio h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-700">非公開</span>
                            </label>
                        </div>
                        <div class="p-2 w-full">
                            <button button type="button" id="add_opt_btn" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">選択肢を増やす</button>
                        </div>
                        <div class="p-4 w-full">
                            <div class="relative">
                                <label>選択肢 : <input type="text" name="option_name[]" required></label>
                            </div>
                        </div>
                        <div class="p-4 w-full">
                            <div class="relative">
                                <label>選択肢 : <input type="text" name="option_name[]" required></label>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 w-full">
                        <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">作成</button>
                    </div>
                </div>
            </div>
            </div>
    </section>
</x-app-layout>