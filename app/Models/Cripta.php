<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cripta extends Model
{
    use HasFactory;

    protected $table = 'cripta_mausoleo';
    protected $fillable = [
        'cuartel_id',
        'bloque_id',
        'sitio',
        'codigo',
        'codigo_antiguo',
        'familia',
        'superficie',
        'enterratorios_ocupados',
        'total_enterratorios',
        'osarios',
        'total_osarios',
        'cenisarios',
        'estado_construccion',
        'observaciones',
        'foto',
        'estado',
        'tipo_registro',
        'tipo_cripta',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];



    public function addCripta(Request $request){
        $cripta = New Cripta;
        $cripta->user_id = auth()->id();
       $cripta->cuartel_id = trim($request->id_cuartel);
       $cripta->bloque_id = trim(strtoupper($request->bloque));
       $cripta->sitio = trim($request->sitio);
       $cripta->codigo = trim( strtoupper($request->codigo));
       $cripta->codigo_antiguo = trim( strtoupper($request->codigo_ant)) ?? null;
       // $cripta->nombre = trim($request->nombres_resp)." ".trim($request->paterno_resp)." ".trim($request->materno_resp);
       $cripta->superficie = trim($request->superficie);
       $cripta->enterratorios_ocupados = trim($request->enterratorios_ocupados) ?? 0;
       $cripta->total_enterratorios = trim($request->total_enterratorios) ?? 0;

       $cripta->osarios = trim($request->osarios)?? 0;
       $cripta->total_osarios = trim($request->total_osarios)?? 0;

       $cripta->cenisarios = trim($request->cenisarios) ?? 0;
       $cripta->estado_construccion = trim($request->estado_construccion);
       $cripta->observaciones = trim($request->observaciones)?? null;
       $cripta->foto = trim($request->foto)?? null;
       $cripta->estado = 'ACTIVO';
       $cripta->tipo_registro = $request->tipo_reg;
       $cripta->tipo_cripta = $request->tipo_cripta;
       $cripta->familia = $request->familia;
       $cripta->notable = $request->notable;
       $cripta->altura = $request->altura;

       $cripta->list_ant_difuntos =  $cripta->difuntos;
       $cripta->ult_gestion_pagada_ant = $cripta->ultima_gestion_pagada;
       $cripta->gestiones_pagadas_ant = $cripta->gestiones_pagadas;

       $cripta->created_at = date("Y-m-d H:i:s");
       $cripta->updated_at = date("Y-m-d H:i:s");
       $cripta->save();
       return $cripta->id;
}

public function upCripta(Request $request, $id){
    //dd($request);
   $cripta= Cripta::where('id', $id)->first();
   $cripta->user_id = auth()->id();
   $cripta->cuartel_id = trim($request->id_cuartel);
   $cripta->bloque_id = trim(strtoupper($request->bloque));
   $cripta->sitio = trim($request->sitio);
   $cripta->codigo = trim( strtoupper($request->codigo));
   $cripta->codigo_antiguo = trim( strtoupper($request->codigo_ant)) ?? null;
   // $cripta->nombre = trim($request->nombres_resp)." ".trim($request->paterno_resp)." ".trim($request->materno_resp);
   $cripta->superficie = trim($request->superficie);
   $cripta->enterratorios_ocupados = trim($request->enterratorios_ocupados) ?? 0;
   $cripta->total_enterratorios = trim($request->total_enterratorios) ?? 0;

   $cripta->osarios = trim($request->osarios)?? 0;
   $cripta->total_osarios = trim($request->total_osarios)?? 0;

   $cripta->cenisarios = trim($request->cenisarios) ?? 0;

   $cripta->estado_construccion = trim($request->estado_construccion);
   $cripta->observaciones = trim($request->observaciones) ?? null;
   if(($request->foto=="" || $request->foto==null) && ($request->foto_edit!="" || $request->foto_edit!=null)){
     $foto=$request->foto_edit;
   }
   else if(($request->foto!="" || $request->foto!=null) && ($request->foto_edit!="" || $request->foto_edit!=null)){
    $foto=$request->foto;
   }
   else if(($request->foto!="" || $request->foto!=null) && ($request->foto_edit=="" || $request->foto_edit==null)){
    $foto=$request->foto;
   }
   else if(($request->foto=="" || $request->foto!=null) && ($request->foto_edit=="" || $request->foto_edit==null)){
    $foto='';
   }
   $cripta->foto = trim($foto) ?? null;
   $cripta->estado = $request->estado ?? 'ACTIVO';
   $cripta->tipo_registro = $request->tipo_reg;
   $cripta->tipo_cripta = $request->tipo_cripta;
   $cripta->familia = $request->familia;
   $cripta->notable = $request->notable;
   $cripta->altura = $request->altura;

   $cripta->list_ant_difuntos =  $cripta->difuntos;
   $cripta->ult_gestion_pagada_ant = $cripta->ultima_gestion_pagada;
   $cripta->gestiones_pagadas_ant = $cripta->gestiones_pagadas;

   $cripta->created_at = date("Y-m-d H:i:s");
   $cripta->updated_at = date("Y-m-d H:i:s");
   $cripta->save();
   return $cripta->id;
}
}
