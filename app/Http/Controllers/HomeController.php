<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Poll;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $conteo= null;
        $polls = Poll::all();
        foreach ($polls as $polls){
            $conteo= $polls -> user_id;
        }
         // dd($conteo);
        
if($conteo == null){
    return redirect('/polls/create');
       
    }else{
        return view('home', compact('polls')) ;
    }


   
 }
}
 