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

            $hasVoted = Vote::where('questionnaire_id', $questionnaireId)
                ->where('vote_user_id', auth()->id())
                ->exists();

            return response()->json([
                'newVoteCount' => $option->vote_count,
                'hasVoted' => $hasVoted
            ]);
        } catch (QueryException $e) {
            // ユニーク制約違反を検出した場合の処理
            // 例: エラーメッセージを返す
            Log::info($e);
            $option = Option::find($optionId);
            $vote_count = $option->vote_count;
            return response()->json(['error' => '一意制約違反でした。', 'newVoteCount' => $vote_count], 409);
            //return response()->json(['error' => '一意制約違反でした。'], 409);
        }
    }
}
