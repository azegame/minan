<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Questionnaire;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function create()
    {
        return view('questionnaires.create');
    }

    public function store(Request $request)
    {
        //dd($request);
        Questionnaire::create([
            'user_id' => Auth::id(),
            'questionnaire_name' => $request->questionnaire_name,
            'public_flag' => $request->publish_setting == 'public' ? 1 : 0,
        ]);



        // Options::create([
        //     'questionnaire_id' => ,
        //     'option_name' => $request->option_name,
        // ]);

        return to_route('index');
    }
}
