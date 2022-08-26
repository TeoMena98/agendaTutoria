<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Poll;
use App\Http\Controllers\Controller;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        // mandamos llamar todo los datos de specialty
        $polls = Poll::all();
        // hacemos una inyección de los datos specialty
        return view('polls.index', compact('polls'));
    }

    public function create(){
        return view('polls.create');
    }

    // función para vailar formulario. Se creo por que se repetia codigo y con esto ya solo mandamos llamar la función donde queramos hacer validación de formulario.
    private function performValidation(Request $request){

        $rules = [
            'answer' => 'required|min:3'
        ];
        $messages = [
            'answer.required' => 'Es necesario ingresar una respuesta.',
            'answer.min' => 'Como mínimo el nombre debe tener 3 caracteres'
        ]; 
 
        $this->validate($request, $rules, $messages);
    }

    public function store(Request $request){

        //dd($request->all());

        $this->performValidation($request);

        $poll = new Poll();
        $poll->answer = $request->input('answer');
        $poll->message = $request->input('message');
        $poll->user_id= $request->input('user_id');;
        $poll->save(); // INSERT

        $notification = 'La encuesta se ha registrdo correctamente';
        return redirect('/home')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        //
    }
}
