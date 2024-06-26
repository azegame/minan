<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            わたしのアンケート
        </h2>
    </x-slot>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">

            <a href="{{ route('questionnaires.create') }}" class="flex mx-auto text-white bg-teal-300 border-0 py-2 px-4 mb-4 focus:outline-none hover:bg-teal-400 rounded text-lg w-1/2">アンケートを作成する</a>
            <div class="flex flex-wrap -m-4">
                @foreach($questionnaires as $questionnaire)
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-sky-200 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/720x400" alt="content">
                        <h3 class="tracking-widest text-blue-500 text-xs font-medium title-font">
                            <a href="{{ route('questionnaires.show', $questionnaire->id) }}">投票する</a>
                        </h3>
                        <h3 class="tracking-widest text-blue-500 text-xs font-medium title-font">
                            <form action="{{ route('questionnaires.mine.destroy', $questionnaire->id) }}" method="POST">
                                @csrf
                                <button type="submit">アンケートを削除する</button>
                            </form>
                            <!-- <a href="{{ route('questionnaires.mine.destroy', $questionnaire->id) }}"> アンケートを削除する</a> -->
                        </h3>
                        <h2 class="text-lg text-gray-900 font-medium title-font">{{ $questionnaire->questionnaire_name }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">投票された数：{{ $voteCounts[$questionnaire->id] ?? '？'  }}</h2>
                        <h2 class="text-sm text-gray-900 font-medium ">作成日：{{ $questionnaire->created_at }}</h2>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>