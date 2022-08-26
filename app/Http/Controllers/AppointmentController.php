<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialty;
use App\University;
use App\Careers;
use App\Appointment;
use App\CancelledAppointment;
use Carbon\Carbon;
use App\Interfaces\ScheduleServiceInterface;
use App\Services\ScheduleService;
use Validator;

class AppointmentController extends Controller
{
    public function index(){

        $role = auth()->user()->role;


        if($role == 'admin'){
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->paginate(10);

        } elseif( $role == 'doctor'){
            // si es doctor
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('doctor_id', auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('doctor_id', auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('doctor_id', auth()->id())
                ->paginate(10);
        }else{
             // En el caso de un paciente
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('patient_id', auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('patient_id', auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('patient_id', auth()->id())
                ->paginate(10);

        }

        return view('appointments.index', compact('pendingAppointments', 'confirmedAppointments', 'oldAppointments', 'role'));
    }

    public function show(Appointment $appointment){
        $role = auth()->user()->role;
        return view('appointments.show', compact('appointment', 'role'));
    }

    public function create(ScheduleServiceInterface $scheduleService){
        $specialties = Specialty::all();
        $careers = Careers::all();
        $universitys = University::all();
        // $specialty = Specialty::all();
        // $universitys = University::all();
        $specialtyId = 1;
        // $specialty = Specialty::find($specialtyId);
        // dd($specialty);

        
         if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
            //  dd($specialty->users);
        }else{
            $doctors = collect();
        }

        // $careersId = old('careers_id');
        // if($careersId){
        //     $careers = Careers::find($careersId);
        //     $doctors = $careers->users;
        // }else{
        //     $doctors = collect();
        // }

        $date = old('scheduled_date');
        $doctorId = 2;
        if($date && $doctorId){
            $intervals = $scheduleService->getAvailableIntervals($date, $doctorId);
        }else{
            $intervals = null;
        }

        return view('appointments.create', compact('specialties', 'careers','universitys', 'doctors', 'intervals'));

    } 

    public function store(Request $request, ScheduleServiceInterface $scheduleService){

        $rules = [
        
             'specialty_id' => 'exists:specialties,id',
             'doctor_id' => 'exists:users,id',
             'careers_id' => 'exists:careers,id',
             'university_id' => 'exists:universities,id',
            'scheduled_time' => 'required'
        ];
        $messages = [
            'scheduled_time.required' => 'Por favor seleccione una hora válida para su tutoria.'
        ];
        $this->validate($request, $rules, $messages);
        // cuando usas el validator make se pasa como primer parametro el dato que se quiere dalivar.
        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request, $scheduleService){
            $date = $request->input('scheduled_date');
            $doctorId = $request->input('doctor_id');
            $scheduled_time = $request->input('scheduled_time');
            if($date && $doctorId && $scheduled_time){
                $start = new Carbon($scheduled_time);
            }else{
                return;
            }
            
            if(!$scheduleService->isAvailableInterval($date, $doctorId, $start)){
                $validator->errors()
                    ->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro estudiante.');
            }
        });

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // $data = $request->only([
        //      'specialty_id',
        //      'university_id',
        //      'doctor_id',
        //      'careers_id',
        //     'scheduled_date',
        //     'scheduled_time',
        //     'type'
        // ]);
        //  $data['patient_id'] = auth()->id();
        //  $data['type'] = "individual";

        // // dar formato al valor que viene del formulario
         
// dd($data);
// $appointment = new Appointment();
//     $appointment->save($data);

//         $notification = 'La tutoria se ha registrado correctamente';
//         return back()->with(compact('notification'));

        // $this->performValidation($request);

        $appointment = new Appointment();
        $appointment->specialty_id = $request->input('specialty_id');
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->patient_id = auth()->id();
        $appointment->university_id = $request->input('university_id');
        $appointment->careers_id = $request->input('careers_id');
        $appointment->scheduled_date = $request->input('scheduled_date');
        $appointment->scheduled_time = $request->input('scheduled_time');
        $appointment->type = "Individual";
        $carbonTime = Carbon::createFromFormat('g:i A', $appointment->scheduled_time);
        $appointment->scheduled_time = $carbonTime->format('H:i:s');
         
        $appointment->save(); // INSERT
 
        $notification = 'La tutoria se ha registrado correctamente';
            return back()->with(compact('notification'));
    }

    public function showCancelForm(Appointment $appointment)
    {
        if($appointment->status == 'Confirmada'){
            $role = auth()->user()->role;
            return view('appointments.cancel', compact('appointment', 'role'));
        }

        return redirect('/appointments');
    }

    public function postCancel(Appointment $appointment, Request $request)
    {
        if($request->has('justification')){
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by_id = auth()->id();

            $appointment->cancellation()->save($cancellation);
        }

        $appointment->status = 'Cancelada';
        $appointment->save(); // update

        $notification = 'La tutoria se ha cancelado correctamente';
        return redirect('/appointments')->with(compact('notification'));

    }

    public function postConfirm(Appointment $appointment)
    {
        
        $appointment->status = 'Confirmada';
        $appointment->save(); // update

        $notification = 'La tutoria se ha confirmado correctamente';
        return redirect('/appointments')->with(compact('notification'));

    }
}
