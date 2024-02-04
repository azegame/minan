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
    public function vote(Request $request, $questionnaireId)
    {
        $currentOptionId = $request->input('currentOptionId');
        $previousOptionId = $request->input('previousOptionId');
        try {
            $hasVoted = Vote::where('questionnaire_id', $questionnaireId)
                ->where('vote_user_id', auth()->id())
                ->exists();
            // 再投票時削除
            if ($hasVoted) {
                Vote::where('questionnaire_id', $questionnaireId)
                    ->where('vote_user_id', auth()->id())
                    ->where('option_id', $previousOptionId)
                    ->delete();
                $previousOption = Option::find($previousOptionId);
                if ($previousOption) {
                    $previousOption->decrement('vote_count');
                }
            }
            // 投票
            Vote::create([
                'questionnaire_id' => $questionnaireId,
                'vote_user_id' => Auth::id(),
                'option_id' => $currentOptionId,
            ]);

            $currentOption = Option::find($currentOptionId);
            $currentOption->increment('vote_count');

            if (isset($previousOption)) {
                $previousVoteCount = $previousOption->vote_count;
            } else {
                $previousVoteCount = null;
            }

            return response()->json([
                'previousVoteCount' => $previousVoteCount,
                'newVoteCount' => $currentOption->vote_count,
            ]);
        } catch (QueryException $e) {
            Log::info($e);
            $option = Option::find($currentOptionId);
            $vote_count = $option->vote_count;

            if ($e->errorInfo[1] == 1062) {
                return response()->json(['error' => 'すでに投票済みです。', 'newVoteCount' => $vote_count], 409);
            } else {
                Log::error($e);
                return response()->json(['error' => 'データベースエラーが発生しました。', 'newVoteCount' => $vote_count], 500);
            }
        }
    }


    public function revoke(Request $request, $questionnaireId)
    {
        $previousOptionId = $request->input('previousOptionId');
        Vote::where('questionnaire_id', $questionnaireId)
            ->where('vote_user_id', auth()->id())
            ->where('option_id', $previousOptionId)
            ->delete();

        $previousOption = Option::find($previousOptionId);
        if ($previousOption) {
            $previousOption->decrement('vote_count');
        }

        if (isset($previousOption)) {
            $previousVoteCount = $previousOption->vote_count;
        } else {
            $previousVoteCount = null;
        }

        return response()->json([
            'previousVoteCount' => $previousVoteCount,
        ]);
    }
}
