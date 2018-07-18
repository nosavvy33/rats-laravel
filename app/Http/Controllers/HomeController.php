<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SampleLine as Registro;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    
    public function avance_supervision(){
        
        try
        {
        $avance = Registro::count();
        return response()->json(["avance"=>$avance],200); 
        }catch(\Exception $e)
        {
            return response()->json(["error"=>$e->getMessage()],400);
        }
        
    }

    public function avance_estado(){
        try{
        $avance = DB::table('sample_lines')
                    ->select(DB::raw("sum(if(state='Sin Acceso',1,0)) as TOT_SIN_ACCESO, sum(if(state='Retirado/Cliente',1,0)) as TOT_RETIRADO_CLIENTE, sum(if(state='Operativo',1,0)) as TOT_OPERATIVO, sum(if(state='Perdido',1,0)) as TOT_PERDIDO, sum(if(state='Dañado',1,0)) as TOT_DANADO, sum(if(state='Sustituido',1,0)) as TOT_SUSTITUIDO"))
                    ->get()->toArray();
        return response()->json($avance,200);
        }catch(\Exception $e)
        {
            return response()->json(["error"=>$e->getMessage()],400);
        }
    }

    public function avance_captura(){
        try{
            $si = Registro::where('captura','=','SI')->count();
            $no = Registro::where('captura','=','NO')->count();
            $tot = Registro::count();
        return response()->json(["SI"=>$si,"NO"=>$no,"TOTAL"=>$tot],200);
        }catch(\Exception $e)
        {
            return response()->json(["error"=>$e->getMessage()],400);
        }
    }   



}
