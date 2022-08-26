<?php

namespace App\Http\Controllers\Admin;

use App\careers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CareersController extends Controller
{
    // Middleware
  // public function __construct()
   //{
    //   $this->middleware('auth');
   //}
   
   public function index(){

       // mandamos llamar todo los datos de Carreras
       $careers = Careers::all();
       // hacemos una inyección de los datos Carreras
       return view('careers.index', compact('careers'));
   }

   public function create(){
       return view('careers.create');
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

       $careers = new Careers();
       $careers->name = $request->input('name');
       $careers->description = $request->input('description');
       $careers->save(); // INSERT

       $notification = 'La Carrera se ha registrdo correctamente';
       return redirect('/careers')->with(compact('notification'));
   }

   public function edit(Careers $careers){
       
       return view('careers.edit', compact('careers'));
   }

   public function update(Request $request, Careers $careers){
       //dd($request->all());

       $this->performValidation($request);

       $careers->name = $request->input('name');
       $careers->description = $request->input('description');
       $careers->save(); // UPDATE

       $notification = 'La Carrera se ha actualizado correctamente';
       return redirect('/careers')->with(compact('notification'));
   }

   public function destroy(Careers $careers){

       $deletedCareers = $careers->name;
       $careers->delete();

       $notification = 'La Carrera '. $deletedCareers .' se ha eliminado correctamente';
       return redirect('/careers')->with(compact('notification'));

   }
}
