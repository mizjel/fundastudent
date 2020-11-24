<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoPagesController extends Controller
{
    public function about(){
        return view('info_pages.about');
    }

    public function faq(){
        return view('info_pages.faq');
    }

    //Algemene voorwaarden
    public function tac(){
        return view('info_pages.tac');
    }
}
