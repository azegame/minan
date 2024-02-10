<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Questionnaire;
use App\Models\Option;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort');
        if ($sort == 'created_at') {
            $questionnaires = Questionnaire::where('public_flag', 1)->orderBy('created_at', 'desc')->get();
        } elseif ($sort == 'votes') {
        } else {
            $questionnaires = Questionnaire::where('public_flag', 1)->orderBy('created_at', 'asc')->get();
        }

        $voteCounts = [];
        foreach ($questionnaires as $questionnaire) {
            $voteCounts[$questionnaire->id] = Option::where('questionnaire_id', $questionnaire->id)->sum('vote_count');
        }

        // return view('index', ['items' => $items]);
        return view('index', compact('questionnaires', 'voteCounts'));
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
            'public_flag' => $request->publish_flag == 'public' ? 1 : 0, // mysqlのboolean型は内部的に1, 0
            'vote_flag' => 1,
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


    public function show($id)
    {
        $questionnaire = Questionnaire::find($id);
        // リレーション
        $options = $questionnaire->options;
        $userId = Auth::id();
        $hasVoted = Vote::where('questionnaire_id', $questionnaire->id)
            ->where('vote_user_id', $userId)
            ->exists();

        $selectedOptionId = null;
        if ($hasVoted) {
            $vote = Vote::where('questionnaire_id', $questionnaire->id)
                ->where('vote_user_id', $userId)
                ->first();
            $selectedOptionId = $vote->option_id;
        }

        return view('questionnaires.show', compact('questionnaire', 'options', 'hasVoted', 'selectedOptionId'));
    }

    public function minePage()
    {
        $userId = Auth::id();
        $questionnaires = Questionnaire::where('user_id', $userId)->get();
        return view('questionnaires.mine', compact('questionnaires'));
    }

    public function destroy($id)
    {
        $votes = Vote::where('questionnaire_id', $id)->get();
        if ($votes) {
            Vote::where('questionnaire_id', $id)->delete();
        } else {
            Log::info('削除対象のvotesのデータが見つからなかった');
        }

        Option::where('questionnaire_id', $id)->delete();
        Questionnaire::where('id', $id)->delete();

        return to_route('index');
    }
}
