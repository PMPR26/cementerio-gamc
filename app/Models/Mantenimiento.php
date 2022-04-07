<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento_nicho';
    protected $fillable = [
        'id',
        'date_in', // fecha ingreso al nicho
        'gestion',
        'pagado',
        'fecha_pago',
        'fur',
        'responsable_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

    public function store(Request $request)
    {
                if($request->isJson())
                {            
                    $this->validate($request, [
                        'gestion'=> 'required',
                        'pagado'=> 'required',
                        'fecha_pago'=> 'required',
                        'fur'=> 'required',
                        'fechadef_dif'=> 'required',               
                        'respdifunto_id'=> 'required',
                        'cantidad_gestiones'=> 'required',
                        'monto'=> 'required',
                        'ultimo_pago'=> 'required',               
                    // 'sel'=>'required',                
                    ], [
                        'gestion.required'=> 'El campo nicho es obligatorio',
                        'pagado.required'=> 'El campo bloque es obligatorio',
                        'fecha_pago.required'=> 'El campo cuartel es obligatorio',
                        'fur.required'=> 'El fila nicho es obligatorio',
                        'fechadef_dif.required'=> 'El campo tipo de nicho es obligatorio',    
                        'respdifunto_id.required'=> 'El campo nombres del difunto es obligatorio',
                        'cantidad_gestiones.required'=> 'El campo apellido paterno es obligatorio',               
                        'monto.required'=> 'El campo genero del difunto es obligatorio',
                        'ultimo_pago.required'=> 'El campo ci del responsable es obligatorio',
                    ]);

        
                $mant = new Mantenimiento; 
                $mant->gestion = $request->sel; 
                $mant->fur=$request->fur;
                $mant->date_in=$request->fechadef_dif;
                $mant->respdifunto_id=$request->respdifunto_id;
                $mant->cantidad_gestiones=$request->cantidad_gestiones;
                $mant->monto=$request->monto;
                $mant->ultimo_pago=$request->ultimo_pago;
                $mant->save();
                return  $mant->id;
            }
          
    }
    public function updatePay(Request $request){
          
        if($request->isJson()){
            $this->validate($request,[
                "fur"=> 'required',
                "id_usuario_caja" => 'required'
            ]);

            $pago = Mantenimiento::select('id', 'fur')
            ->where(['fur' => trim($request->fur), 'pagado' => false, 'estado' => 'ACTIVO'])
            ->first();

            if($pago){
                Mantenimiento::where('fur', trim($request->fur))
                ->update([      
                   'pagado' => true,
                   'id_usuario_caja' => $request->id_usuario_caja,
                   'fecha_pago'=> date('Y-m-d h:i:s')
                ]);
                return response([
                    'status'=> true
                   // 'message'=> 'El nro fur  no existe o ya fue pagado por favor recargue la pagina'
                 ],200);

            }else{
                return response([
                    'status'=> false,
                    'message'=> 'El nro fur  no existe o ya fue pagado por favor recargue la pagina'
                 ],200);
            }
        }else{
            return response([
                'status'=> false,
                'message'=> 'No autorizado'
             ],401); 
        }
        
    }

}
