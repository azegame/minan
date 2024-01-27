<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Vote;
use App\Models\Option;

class VoteController extends Controller
{
    public function vote(Request $request, $questionnaireId, $optionId)
    {
        try {
            Vote::create([
                'questionnaire_id' => $questionnaireId,
                'vote_user_id' => Auth::id(),
                'option_id' => $optionId,
            ]);

            // 投票ロジック
            $option = Option::find($optionId);
            $option->increment('vote_count');

            // $hasVoted = Vote::where('questionnaire_id', $questionnaireId)
            //     ->where('vote_user_id', auth()->id())
            //     ->exists();

            return response()->json([
                'newVoteCount' => $option->vote_count,
            ]);
        } catch (QueryException $e) {
            Log::info($e);
            $option = Option::find($optionId);
            $vote_count = $option->vote_count;

            if ($e->errorInfo[1] == 1062) {
                return response()->json(['error' => 'すでに投票済みです。', 'newVoteCount' => $vote_count], 409);
            } else {
                Log::error($e);
                return response()->json(['error' => 'データベースエラーが発生しました。', 'newVoteCount' => $vote_count], 500);
            }
        }
    }
}
