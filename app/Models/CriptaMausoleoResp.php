<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class CriptaMausoleoResp extends Model
{
    use HasFactory;
    protected $table = 'cripta_mausoleo_responsable';
    protected $fillable = [
        'responsable_id',
        'cripta_mausole_id',            
        'estado',       
        'created_at',
        'ultima_gestion_pagada',  
        'documentos_recibidos', 
        'adjudicacion'
    ];
    protected $hiden = [
        'id',
        'updated_at'
    ];
  


    public function saveCriptaMausoleoResp(Request $request,  $responsable_id, $cripta_id){
        //dd($request->documentos_recibidos);
        $criptaMauseleo = New CriptaMausoleoResp;                                                  
        $criptaMauseleo->responsable_id = $responsable_id;
        $criptaMauseleo->cripta_mausole_id = $cripta_id;
        $criptaMauseleo->ultima_gestion_pagada=$request->ultima_gestion_pagada ?? null;
        $criptaMauseleo->documentos_recibidos=json_encode($request->documentos_recibidos) ?? null;
        $criptaMauseleo->adjudicacion=$request->adjudicacion ?? null;
        $criptaMauseleo->estado='ACTIVO';
        $criptaMauseleo->created_at= date("Y-m-d H:i:s");
        $criptaMauseleo->updated_at = date("Y-m-d H:i:s");      
        $criptaMauseleo->save();  
        return $criptaMauseleo->id; 
    }
    public function upCriptaMausoleoResp(Request $request,  $responsable_id, $cripta_id, $id){
       
       
        $criptaMauseleo= CriptaMausoleoResp::where('id', $id)->first();
       
      
        $criptaMauseleo->responsable_id = $responsable_id;
        $criptaMauseleo->cripta_mausole_id = $cripta_id;
        $criptaMauseleo->ultima_gestion_pagada=$request->ultima_gestion_pagada ?? null;
        $criptaMauseleo->documentos_recibidos=$request->documentos_recibidos ?? null;
        $criptaMauseleo->adjudicacion=$request->adjudicacion ?? null;
        $criptaMauseleo->estado=$request->estado;
        $criptaMauseleo->updated_at = date("Y-m-d H:i:s");
        $criptaMauseleo->save();  
        return $criptaMauseleo->id; 

    }
}
