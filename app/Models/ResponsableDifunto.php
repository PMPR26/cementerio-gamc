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

    public function searchResponsableDifunt(Request $request){
        $dif = Difunto::select()
        ->where(['ci' => trim($request->ci_dif)])
        ->first();

        $resp = Responsable::select()
                            ->where(['ci' => trim($request->ci_resp)])
                            ->first();

                          

            if( $dif &&   $resp  ){
                $respdif = DB::table('responsable_difunto')
                ->select('responsable_difunto.*')
                ->where(['responsable_id' => trim($resp->id) , 'difunto_id' => trim($dif->id) ])
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

}