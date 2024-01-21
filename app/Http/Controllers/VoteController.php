<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Option;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        //dd($request);
    }

    public function vote(Request $request, $optionId)
    {
        // 投票ロジック
        $option = Option::find($optionId);
        $option->increment('vote_count');

        return response()->json(['newVoteCount' => $option->vote_count]);
    }
}
