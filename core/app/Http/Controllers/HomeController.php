<?php

namespace App\Http\Controllers;

use App\Form;

class HomeController extends Controller
{
    public function index()
    {
        $form = Form::where('default', '=', 1)->first();

        return view('home.index')
            ->with('form', $form);
    }
}
