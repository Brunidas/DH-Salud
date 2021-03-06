<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Patient;
use App\MedicalInsurance;

class PatientsController extends Controller
{
    public function listado( ){
        // $id_usuario = $id;
        // echo $id_usuario;

        $pacientes = Patient::all();
        $obrasSociales = MedicalInsurance::all();

        $vac = compact( "pacientes","obrasSociales" );
            
        return view("cuenta", $vac);
    }

    
    public function agregarPaciente( $id ){
        
        $obrasSociales = MedicalInsurance::all();
        $pacientes = Patient::all();
        // $pacientesDeUsuario = DB::table('patients')->where('user_id', $formulario["user_id"])->get();

        $vac = compact( "obrasSociales" ,"id","pacientes");
            
        return view("agregarPaciente", $vac);
    
    }


    public function completarAgregado( Request $formulario ){
     
        // $user_id = $formulario["user_id"];
        // $medical_insurances_id = $formulario["medical_insurances_id"];

        // $name = $formulario["name"];
        // $lastname = $formulario["lastname"];
        // $dni = $formulario["dni"];
        // $membership_number = $formulario["membership_number"];
        // $adress= $formulario["adress"];
        // $province = $formulario["province"];
        // $phone_number = $formulario["phone_number"];


        $mensajes =[
            "string" => "El campo :attribute debe ser de texto",
            "unique" => ":attribute ya esta en uso",
            "integer" => "El campo :attribute deber ser un entero",
            "required" => "El campo :attribute es obligatorio",
            "max" => "El campo :attribute tiene un maximo de :max",
            "email" => "El campo :attribute debe ser un correo electronico",
            "min" => "El campo :attribute tiene un minimo de :min",
        ];


        $reglas = [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => [ 'required' ,'string','max:255'],
            'dni'=>['required', 'integer','min:0','unique:patients' ],
            'membership_number' => ['required', 'integer','min:0','unique:patients' ],
            'adress' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'phone_number'=>['required', 'integer','min:0','unique:patients' ],
        ];

        $this->validate( $formulario, $reglas, $mensajes);

        $nuevoPaciente = new Patient();

        $nuevoPaciente->user_id = $formulario["user_id"];
        
        $nuevoPaciente->name = $formulario["name"];
        $nuevoPaciente->lastname = $formulario["lastname"];
        $nuevoPaciente->dni = $formulario["dni"];
        $nuevoPaciente->membership_number = $formulario["membership_number"];
        $nuevoPaciente->adress = $formulario["adress"];
        $nuevoPaciente->province = $formulario["province"];
        $nuevoPaciente->phone_number = $formulario["phone_number"];

        
        
        $pacientesDeUsuario = DB::table('patients')->where('user_id', $formulario["user_id"])->get();
        // echo $ver . "<br>";
        // echo $ver->isEmpty() . "<br>"; 

        if ( $pacientesDeUsuario->isEmpty() ) {
            $nuevoPaciente->account_holder = True;
            $nuevoPaciente->medical_insurances_id = $formulario["medical_insurances_id"];

        }else{
            $nuevoPaciente->account_holder = False;
            
            $A = DB::table('patients')->where('user_id', $formulario["user_id"])->first();
            
            $id_obraSocial = $A->medical_insurances_id;

            // $obrasSocial = MedicalInsurance::find( $id_obraSocial );

            $nuevoPaciente->medical_insurances_id = $id_obraSocial;
            // echo $obrasSocial->name;
        }

        
        $nuevoPaciente->save();

        return redirect("/cuenta");
    }


    public function borrar( Request $formulario ){
        $id = $formulario["id"];
        
        $paciente = Patient::find( $id );

        $paciente->delete();

        return redirect("/cuenta");
    }


    public function editar( $id ){

        $paciente = Patient::find( $id );

        $obrasSociales = MedicalInsurance::all();
        
        $vac = compact( "paciente" , "obrasSociales" );

        return view("editarPaciente", $vac);

    }



    public function completarEdicion( Request $formulario ){
        
        
        $mensajes =[
            "string" => "El campo :attribute debe ser de texto",
            "unique" => ":attribute ya esta en uso",
            "integer" => "El campo :attribute deber ser un entero",
            "required" => "El campo :attribute es obligatorio",
            "max" => "El campo :attribute tiene un maximo de :max",
            "email" => "El campo :attribute debe ser un correo electronico",
            "min" => "El campo :attribute tiene un minimo de :min",
        ];
        
        $reglas = [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => [ 'required' ,'string','max:255'],
            'dni'=>['required', 'integer','min:0' ],
            'membership_number' => ['required', 'integer','min:0' ],
            'adress' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'phone_number'=>['required', 'integer','min:0' ],
        ];

        $this->validate( $formulario, $reglas, $mensajes);

        $id = $formulario["id"];

        $paciente = Patient::find( $id );

        $paciente->name = $formulario["name"];
        $paciente->lastname = $formulario["lastname"];
        $paciente->dni = $formulario["dni"];
        $paciente->membership_number = $formulario["membership_number"];
        $paciente->adress = $formulario["adress"];
        $paciente->province = $formulario["province"];
        $paciente->phone_number = $formulario["phone_number"];
        


        if ( $paciente['account_holder'] == True ){

            echo $formulario["medical_insurances_id"] . "<br>";
            
            
            $todosLosPacientes = Patient::all();

            foreach ( $todosLosPacientes as $unPaciente) {
                if ( $unPaciente->user_id = $formulario["user_id"] ){
                    echo $unPaciente->name ." :";
                    echo $unPaciente->medical_insurances_id ."<br>";
                    
                    $unPaciente->medical_insurances_id = $formulario["medical_insurances_id"];
                    
                    $unPaciente->save();
                    
                }
            }


        }

        $paciente->save();


        return redirect("/cuenta");
    }


}
