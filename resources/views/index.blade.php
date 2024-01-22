<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            みんなのアンケート
        </h2>
    </x-slot>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <a href="{{ route('questionnaires.create') }}">アンケートを作成する</a>
            <div class="flex flex-wrap -m-4">
                @foreach($questionnaires as $questionnaire)
                <div class="xl:w-1/4 md:w-1/2 p-4">
                    <div class="bg-sky-100 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="https://dummyimage.com/720x400" alt="content">
                        <h3 class="tracking-widest text-blue-500 text-xs font-medium title-font">
                            <a href="{{ route('questionnaires.show', $questionnaire->id) }}">投票する</a>
                        </h3>
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $questionnaire->questionnaire_name}}</h2>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>