<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Difunto;
use App\Models\Responsable;
use Illuminate\Support\Facades\DB;


class ResponsableDifunto extends Model
{
    use HasFactory;

    protected $table = 'responsable_difunto';
    protected $fillable = [
        'id',
        'responsable_id',
        'difunto_id',
        'codigo_nicho',
        'fecha_adjudicacion',
        'tiempo',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

    public function searchResponsableDifunt(Request $request ,$idresp, $difuntoid ){

            if( $difuntoid &&   $idresp  ){
                $respdif = DB::table('responsable_difunto')
                ->select('responsable_difunto.*')
                ->where(['responsable_id' => trim($idresp) , 'difunto_id' => trim($difuntoid) ])
                ->first();
              //  dd($respdif);
                if($respdif!=null){
                    return $respdif->id;

                }else{
                    return null;
                }


            }else{

                return null;
            }



    }

    public function info($cod, $bloque, $nicho, $fila)
    {

        // dd($cod);
    //    $cod=$cuartel.".".$bloque.".".$nicho.".".$fila;
                        $busq = DB::table('responsable_difunto')
                        ->select(
                        "responsable_difunto.*",
                        "responsable.segundo_apellido as segap_resp",
                        "responsable.fecha_nacimiento as nacimiento_resp",
                        "responsable.telefono",
                        "responsable.celular",
                        "responsable.estado_civil as ecivil_resp",
                        "responsable.genero as genero_resp",
                        "responsable.email as email_resp",
                        "responsable.domicilio as domicilio_resp",
                        "responsable.ci as ci_resp",
                        "responsable.nombres as nombre_resp",
                        "responsable.primer_apellido as paterno_resp",
                        "responsable.segundo_apellido as segap_resp",
                        "difunto.ci as ci_dif",
                        "difunto.nombres as nombre_dif",
                        "difunto.primer_apellido as primerap_dif",
                        "difunto.segundo_apellido as segap_dif",
                        "difunto.segundo_apellido as segap_dif",
                        "difunto.fecha_nacimiento as nacimiento_dif",

                        "difunto.causa as causa_dif",
                        "difunto.fecha_defuncion as fecha_defuncion",
                        "difunto.tipo as tipo_dif",
                        "difunto.certificado_defuncion",
                        "difunto.genero as genero_dif",
                        "difunto.certificado_file", //certificado_defuncion
                        "difunto.funeraria",
                       "nicho.tipo as tipo_nicho",
                        "nicho.codigo as nicho",
                        "nicho.codigo_anterior as anterior",
                        "bloque.codigo as bloque",
                        "cuartel.codigo as cuartel",
                        "nicho.nro_nicho",
                        "nicho.cantidad_cuerpos")
                        ->leftJoin('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
                        ->leftJoin('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
                        ->leftJoin('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
                        ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                        ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                        // ->where('responsable_difunto.codigo_nicho',  'ilike', '%'.$cod.'%' )
                        ->where('bloque.codigo','=',''.$bloque.'')
                        ->where('nicho.nro_nicho','=',''.$nicho.'')
                        ->where('nicho.fila','=',''.$fila.'')
                        ->where('responsable_difunto.estado', '=', 'ACTIVO')
                        ->orderBy('responsable_difunto.id', 'DESC')
                        ->first();

                        // dd($busq);
                                if($busq){
                                    $mensaje=true;
                                }
                                else{
                                    $mensaje= false;
                                }

                                $respu= [
                                    "mensaje" => $mensaje,
                                    "response"=>$busq
                                    ];

                                return response()->json($respu);
                    }






}
