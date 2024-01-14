<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
