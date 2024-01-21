<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        //dd($request);
        $questionnaire = Questionnaire::create([
            'user_id' => Auth::id(),
            'questionnaire_name' => $request->questionnaire_name,
            'public_flag' => $request->publish_flag == 'public' ? 1 : 0,
        ]);

        $questionnaireId = $questionnaire->id;

        $optionNames = $request->input('option_name');
        foreach ($optionNames as $optionName) {
            // 選択肢をデータベースに保存
            Option::create([
                'questionnaire_id' => $questionnaireId,
                'option_name' => $optionName,
            ]);
        }
        //dd($optionNames);

        return to_route('index');
    }
}
