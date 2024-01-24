<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

use App\Models\Vote;
use App\Models\Option;

class VoteController extends Controller
{
    public function vote(Request $request, $optionId)
    {
        try {
            Vote::create([
                'vote_user_id' => Auth::id(),
                'option_id' => $optionId,
            ]);

            // 投票ロジック
            $option = Option::find($optionId);
            $option->increment('vote_count');

            return response()->json(['newVoteCount' => $option->vote_count]);
        } catch (QueryException $e) {
            // ユニーク制約違反を検出した場合の処理
            // 例: エラーメッセージを返す
            return response()->json(['error' => 'You have already voted for this option.'], 409);
        }
    }
}
