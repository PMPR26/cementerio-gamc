<?php

namespace App\Http\Controllers\Deposito;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposito\DepositoModel;
use App\Models\Nicho;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Servicios\ServicioNicho;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\Http;

class DepositoController extends Controller
{


    // Mostrar todos los registros
    public function index()
    {
        $depositos = DepositoModel::orderBy('id', 'desc')->get();
        return view('depositos.index', compact('depositos'));
    }

    // Mostrar el formulario para crear un nuevo registro
    public function create()
    {

       // $nichos=Nicho::where('estado','ACTIVO')->select('id', 'codigo')->get();
        return view('depositos.create');
    }

    // Almacenar un nuevo registro
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id(); // Retrieve authenticated user's ID and assign it to user_id column

        DepositoModel::create($data);
        return redirect()->route('deposito');
    }

    // Mostrar un registro específico
    public function show(Request $request)
    {
        $deposito = DepositoModel::findOrFail($request->deposito_id);
        return view('depositos.mostrar', compact('deposito'));
    }

    // Mostrar el formulario para editar un registro
    public function edit($id)
    {
        $deposito = DepositoModel::findOrFail($id);
        return view('depositos.edit', compact('deposito'));
    }

    // Actualizar un registro específico
    public function update(Request $request)
    {
        $deposito = DepositoModel::findOrFail($request->id);
        $deposito->update($request->all());
        return redirect()->route('deposito')->with('success', 'Modificacion exitosa');
    }

    // Eliminar un registro específico
    public function destroy($id)
    {
        $deposito = DepositoModel::findOrFail($id);
        $deposito->delete();
        return redirect()->route('depositos.index');
    }

    public function formPago(Request $request)
    {
        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();

        // $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/525', [
        $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-servicios-nicho/525', [

        'json' => [
            ],
            'headers' => $headers,
        ]);
        $data = json_decode((string) $response->getBody(), true);


       if($data['status']==true){
            $precio = $data['response'][0]['monto1'];
            $cuenta = $data['response'][0]['cuenta'];
            $descrip = $data['response'][0]['descripcion'];
            $num_sec = $data['response'][0]['num_sec'];
        }else{
            $precio =0;
        }
        $deposito = DepositoModel::findOrFail($request->deposito_id);
        $impuesto= $deposito->impuesto;
        $year=Date('Y');
        $cuotas=$year-$impuesto;
        $total_adeudado=$precio*$cuotas;

        return view('depositos.formpago', compact('deposito', 'precio', 'cuenta','descrip','num_sec', 'cuotas', 'total_adeudado'));
    }

    public function preliquidacion(Request $request){
       // dd($request);

        $datos_cajero=User::select()
        ->where('id',auth()->id())
        ->first();
        $cajero= $datos_cajero->user_sinot;

        $deposito = DepositoModel::findOrFail($request->deposito_id);
        $nombre_difunto=$deposito->nombre_difunto;
        $cuartel=$deposito->cuartel;
        $bloque=$deposito->bloque;
        $nicho=$deposito->nicho;
        $fila=$deposito->fila;

        $nombre_adjudicatario= $request->nombre_pago." ".$request->primer_apellido_pago." ".$request->segundo_apellido_pago;
        $ci_adjudicatario=$request->ci_responsable_pago;
        $total_adeudado=$request->precio*$request->cant_cuotas_adeudadas;

        $obj= new ServicioNicho;
        $response=$obj->GenerarFurDeposito($request->ci_responsable_pago,$request->nombre_pago, $request->primer_apellido_pago, $request->segundo_apellido_pago,  $nombre_difunto,
        $cuartel,$bloque, $nicho, $fila, $request->cuenta, $request->precio, $request->descripcion,  $request->num_sec, $request->cant_cuotas_adeudadas,  $cajero,
        $nombre_adjudicatario, $ci_adjudicatario , $request->glosa);
        if($response['status']==true){
            $fur = $response['response'];
        }
       // dd($response);

        //guardar boleta

        $deposito->cant_cuotas_adeudadas=$request->cant_cuotas_adeudadas;
        $deposito->precio_unitario=$request->precio;
        $deposito->total_adeudado=$total_adeudado;
        $deposito->fur=$fur;
        $deposito->fecha_pago=date('Y-m-d');
        $deposito->glosa=$request->glosa;
        $deposito->nombre_pago=$request->nombre_pago;
        $deposito->primer_apellido_pago=$request->primer_apellido_pago;
        $deposito->segundo_apellido_pago=$request->segundo_apellido_pago;
        $deposito->ci_pago=$request->ci_responsable_pago;
        $deposito->save();
        return redirect()->route('deposito')->with('success', 'Registro  con éxito');
      }
      public function print(Request $request){

        $data = DepositoModel::findOrFail($request->deposito_id);
        $arrayBusqueda = [];
        $arrayBusqueda[] = (string)2;
        $arrayBusqueda[] = (string)$request->fur;
        $arrayBusquedaString = json_encode($arrayBusqueda);
        //$response = Http::asForm()->post('http://192.168.104.117/cb-dev/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
        // $response = Http::asForm()->post('http://192.168.104.117/cb-dev/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
        $response = Http::asForm()->post(env('URL_SEARCH_FUR'), [

            'buscar' => $arrayBusquedaString
        ]);

//dd( $response->object()->data->cobrosVarios[0]);
        if ($response->successful()) {
            if($response->object()->status == true) {
                $deposito = $response->object()->data->cobrosVarios[0];
                $pdf = PDF::setPaper('A4', 'landscape');
                $pdf = PDF::loadView('depositos/print', compact('deposito','data'));
                return  $pdf-> stream("Pago_deposito.pdf", array("Attachment" => false));

            }
           }


      }
}
