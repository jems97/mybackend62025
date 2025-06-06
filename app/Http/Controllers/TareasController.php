<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tareas;
use Illuminate\Support\Facades\DB;


class TareasController extends Controller
{
    public function newtask(Request $request)
    {        
        //Con procedimiento almacenado para insertar tareas
        DB::statement('CALL insertarTarea(?, ?, ?, ?);', [
            $request->titulo,
            $request->descripcion,
            $request->fecha_limite,
            $request->user_id,
        ]);

        return response()->json([
            "status" => "success",
            "msg" => "Tarea creada exitosamente"
        ]);
    }

    public function gettask($user_id)
    {
        $tareas = Tareas::where('user_id', '=', $user_id)
        ->orderBy('fecha_limite', 'asc')
        ->get();
        return response()->json([
            'tareas' => $tareas
        ]);
    }

    public function deletetask($id)
    {
        $tarea = Tareas::find($id);
        //verificar que la tarea le pertenezca al usuario 
        if($tarea->user_id !== auth()->id()){
            return response()->json([
                "status" => "error",
                "msg" => "No autenticado"
            ]);
        }
        //uso de procedimientos almacenados para borra una tarea
        DB::statement('CALL eliminarTarea(?)', [$id]);

        return response()->json([
            "status" => "success",
            "msg" => "Tarea eliminada exitosamente"
        ]);
    }
}
