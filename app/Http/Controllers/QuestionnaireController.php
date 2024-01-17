<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Questionnaire;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questionnaires = Questionnaire::select('id', 'questionnaire_name')->get();
        return view('index', compact('questionnaires'));
    }

    public function create()
    {
        return view('questionnaires.create');
    }

    public function store(Request $request)
    {
        //dd($request);
        $questionnaire = Questionnaire::create([
            'user_id' => Auth::id(),
            'questionnaire_name' => $request->questionnaire_name,
            'public_flag' => $request->publish_setting == 'public' ? 1 : 0,
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
        dd($optionNames);

        return to_route('index');
    }
}
