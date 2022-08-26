<?php

namespace App\Http\Controllers\Admin;

use App\University;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UniversityController extends Controller
{
    // Middleware
  // public function __construct()
   //{
    //   $this->middleware('auth');
   //}
   
   public function index(){

       // mandamos llamar todo los datos de Universidad
       $universitys = University::all();
       // hacemos una inyección de los datos Carreras
       return view('universitys.index', compact('universitys'));
   }

   public function create(){
       return view('universitys.create');
   }

   // función para vailar formulario. Se creo por que se repetia codigo y con esto ya solo mandamos llamar la función donde queramos hacer validación de formulario.
   private function performValidation(Request $request){

       $rules = [
           'name' => 'required|min:3'
       ];
       $messages = [
           'name.required' => 'Es necesario ingresar un nombre.',
           'name.min' => 'Como mínimo el nombre debe tener 3 caracteres'
       ]; 

       $this->validate($request, $rules, $messages);
   }

   public function store(Request $request){

       //dd($request->all());

       $this->performValidation($request);

       $universitys = new University();
       $universitys->name = $request->input('name');
       $universitys->description = $request->input('description');
       $universitys->save(); // INSERT

       $notification = 'La Universidad se ha registrdo correctamente';
       return redirect('/universitys')->with(compact('notification'));
   }

   public function edit(University $universitys){
       
       return view('universitys.edit', compact('universitys'));
   }

   public function update(Request $request, University $universitys){
       //dd($request->all());

       $this->performValidation($request);

       $universitys->name = $request->input('name');
       $universitys->description = $request->input('description');
       $universitys->save(); // UPDATE

       $notification = 'La Universidad se ha actualizado correctamente';
       return redirect('/universitys')->with(compact('notification'));
   }

   public function destroy(University $universitys){

       $deleteduniversitys = $universitys->name;
       $universitys->delete();

       $notification = 'La Universidad '. $deleteduniversitys .' se ha eliminado correctamente';
       return redirect('/universitys')->with(compact('notification'));

   }
}

