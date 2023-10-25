<?php

namespace App\Http\Controllers;

use Lang;
use App\Acl;
use App\User;
use App\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "usuario";
    }

    // Muesta la vista home
    public function index(){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return view('/home');
            }
        }
        # Fin de validación usuario activo
        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);

        $usuario = User::find(Auth::user()->id);
        $usuarios = User::Where('name','!=','Root')->get();

        return view('/usuarios/listar')->with([
                                                'usuario'  => $usuario,
                                                'usuarios' => $usuarios, 
                                                'perm'     => $perm[0]
                                            ]);
    }

    // Muestra la vista para registra un nuevo usuario
    public function create(){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return view('/home');
            }
        }
        # Fin de validación usuario activo
        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);

        $recursos = DB::table('recursos')
                        ->select(
                                    'recursos.id' , 
                                    'recursos.nombre' ,
                                    'menus.id as menus' ,
                                    'menus.id_padre' ,
                                    'menus.url'
                                )
                        ->leftJoin('menus' , 'recursos.id' , '=' , 'menus.id_recursos')
                        ->where('menus.url','!=','#')
                        ->where('recursos.estatus','!=','0')
                        ->where('menus.estatus','!=','0')
                        ->distinct()
                        ->get();
        $data['rows'] = $recursos;

        return view('/usuarios/registrar', [
                                                'recursos' => $recursos, 
                                                'data'     => $data,
                                                'perm'     => $perm[0],
                                               ]);
    }

    // Transacción de registro de usuario
    public function store(Request $request){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return redirect('home');
            }
        }
        # Fin de validación usuario activo

        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);
        if($perm[0]['I'] == 0){
            return redirect(Route('home'))->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.errorPermisos')
            ]);
        }

        $this->validate($request, [
            'name'  => 'required',
            'email'   => 'required|email',
            'password' => 'required|min:6|confirmed',

        ]);

        $conductor = 1;
        if($request['conductor']){
            $conductor = $request['conductor'];
        }
         //Insertamos el usuarios
        $user = User::create([
            'name'          => $request['name'],
            'email'         => $request['email'],
            'password'      => bcrypt($request['password']),
            'estatus'       => $request['estatus'],
            'id_tipo_users' => 1
        ]);

        //Retorna el ID del último usuario registrado
        //$user   = User::all();
        //$idUser = $user->last()['attributes']['id'];
        $idUser = $user->id;

        /********************************************
         Permisos para los módulos
        ********************************************/

        $acldata = array();
        $template = array('R'=>0,'I'=>0,'U'=>0,'D'=>0,'SF'=>0,'DF'=>0);

        if ( isset($request->R) ){
            $data = $request->R;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['R'] = 1;
            }
        }

        if ( isset($request->I) ){
            $data = $request->I;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['I'] = 1;
            }
        }
        if ( isset($request->U) ){
            $data = $request->U;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['U'] = 1;
            }
        }
        if ( isset($request->D) ){
            $data = $request->D;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['D'] = 1;
            }
        }
        if ( isset($request->SF) ){
            $data = $request->SF;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['SF'] = 1;
            }
        }
        if ( isset($request->DF) ){
            $data = $request->DF;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['DF'] = 1;
            }
        }

        //Borra todos los permisos asociados al grupo
        $borra = DB::table('lista_control_accesos')->where('id_users', '=', $idUser)->delete();

        //obtenemos las llaves de un arreglo
        $idRecursos = array_keys($acldata);

        //obtenemos los id's padres de los elementos seleccionado
        $padres = DB::table('menus')
                    ->select('menus.id_padre')
                    ->whereIn('id_recursos', $idRecursos)
                    ->distinct()
                    ->get();

        //Guardamos permisos de menus padres
        foreach ($padres as $key) {
            $recurso_padre = DB::table('menus')
                        ->select('menus.id_padre','menus.id_recursos')
                        ->where('id' , '=' , $key->id_padre)
                        ->get();

            foreach ($recurso_padre as $value) {
                Acl::create([
                    'id_users' =>$idUser,
                    'id_recursos' => $value->id_recursos,
                    'R' => '1',
                    'I' => '0',
                    'U' => '0',
                    'D' => '0',
                    'SF' => '0',
                    'DF' => '0',
                ]);
            }       
        }     

        //Guardamos permisos por modulos para el grupo
        foreach ($acldata as $key => $value) {
            Acl::create([
                'id_users'    =>$idUser,
                'id_recursos' => $key,
                'R'  => $value['R'],
                'I'  => $value['I'],
                'U'  => $value['U'],
                'D'  => $value['D'],
                'SF' => $value['SF'],
                'DF' => $value['DF'],
            ]);
         }

        //return redirect('/usuarios')->with('msj', 'Los datos se actualizaron con éxito.');
        return redirect('/usuarios')->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
    }

    // Muestra la vista para editar un usuario
    public function  edit($id){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return view('/home');
            }
        }
        # Fin de validación usuario activo
        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);

        $usuario = User::find($id);
        $recursos = DB::table('recursos')
                        ->select(
                                    'recursos.id' , 
                                    'recursos.nombre' ,
                                    'menus.id as menus' ,
                                    'menus.id_padre' ,
                                    'menus.url'
                                )
                        ->leftJoin('menus' , 'recursos.id' , '=' , 'menus.id_recursos')
                        ->where('menus.url','!=','#')
                        ->where('recursos.estatus','!=','0')
                        ->where('menus.estatus','!=','0')
                        ->distinct()
                        ->get();

        $data = array();
        
        $sql = DB::table('recursos')
                ->select(DB::raw('recursos.id,recursos.nombre,lista_control_accesos.*'))
                ->leftJoin('lista_control_accesos', 'recursos.id', '=', 'lista_control_accesos.id_recursos')
                ->leftJoin('menus','recursos.id','=','menus.id_recursos')
                ->where('lista_control_accesos.id_users','=',$id)
                ->where('menus.url','!=','#')
                ->get();

        $data['rows'] = $sql;

        $idRecursos = array();
        if ($sql != '[]') {
            foreach ($sql as $value) {
                $idRecursos[] = $value->id_recursos;
            }

            $sql_faltantes = DB::table('recursos')
                ->select(DB::raw('recursos.id,recursos.nombre'))
                ->leftJoin('lista_control_accesos', 'recursos.id', '=', 'lista_control_accesos.id_recursos')
                ->leftJoin('menus','recursos.id','=','menus.id_recursos')
                ->whereNotIn('recursos.id', $idRecursos)
                ->where('menus.url','!=','#')
                ->distinct()
                ->get();
        } else {
            $sql_faltantes = DB::table('recursos')
                ->select(DB::raw('recursos.id,recursos.nombre'))
                ->leftJoin('lista_control_accesos', 'recursos.id', '=', 'lista_control_accesos.id_recursos')
                ->leftJoin('menus','recursos.id','=','menus.id_recursos')
                ->where('menus.url','!=','#')
                ->distinct()
                ->get();
        }

        $faltantes = $sql_faltantes;

        $sql_user = DB::table('users')
                ->select(DB::raw('
                                    lista_control_accesos.id_recursos, 
                                    bit_or(lista_control_accesos.R) as R, 
                                    bit_or(lista_control_accesos.I) as I, 
                                    bit_or(lista_control_accesos.U) as U, 
                                    bit_or(lista_control_accesos.U) as D, 
                                    bit_or(lista_control_accesos.SF) as SF, 
                                    bit_or(lista_control_accesos.DF) as DF
                                '))
                ->leftJoin('lista_control_accesos', 'lista_control_accesos.id_users', '=', 'users.id')
                ->where('users.id','=',$id)
                ->groupBy('lista_control_accesos.id_recursos')
                ->orderBy('lista_control_accesos.id_recursos','asc')
                ->get();

        $groupacl = array();
        $groupacl = $sql_user;

            foreach ($data['rows'] as $row) {
                foreach ($groupacl as $res) {
                    if ($row->id == $res->id_recursos){
                        if ($row->R == 0 and $res->R == 1){
                            $row->R = 1;
                            $row->R_G = 1;
                        }
                        if ($row->I == 0 and $res->I == 1){
                            $row->I = 1;
                            $row->I_G = 1;
                        }
                        if ($row->U == 0 and $res->U == 1){
                            $row->U = 1;
                            $row->U_G = 1;
                        }
                        if ($row->D == 0 and $res->D == 1){
                            $row->D = 1;
                            $row->D_G = 1;
                        }
                        if ($row->SF == 0 and $res->SF == 1){
                            $row->SF = 1;
                            $row->SF_G = 1;
                        }
                        if ($row->DF == 0 and $res->DF == 1){
                            $row->DF = 1;
                            $row->DF_G = 1;
                        }
                    }
                }
            }

         return view('/usuarios/modificar', [   'usuario'  => $usuario,
                                                'recursos' => $recursos, 
                                                'data'     => $data,
                                                'faltantes'=>$faltantes,
                                                'perm'     => $perm[0],
                                               ]);
    }

    // Transacción de actualización de usuario
    public function update(Request $request, $id){
        //dd($request);
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return view('/home');
            }
        }
        # Fin de validación usuario activo
        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);
        if($perm[0]['U'] == 0){
            $mensaje = 'No cuentas con permiso para realizar esta acción';
            return redirect('/usuario')->with(["Error" => $mensaje]);
        }

        if ($request->password) {
            if($request->email == $request->emailOriginal){
                $this->validate($request, [
                    'name'   => 'required|max:255',
                    //'email'    => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                ]);
            }else{
                $this->validate($request, [
                    'name'   => 'required|max:255',
                    'email'    => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                ]);
            }
        }else{
            if($request->email == $request->emailOriginal){
                $this->validate($request, [
                    'name'   => 'required|max:255',
                    //'email'    => 'required|email|max:255|unique:users',
                    //'password' => 'required|min:6|confirmed',
                ]);
            }else{
                $this->validate($request, [
                    'name'   => 'required|max:255',
                    'email'    => 'required|email|max:255|unique:users',
                    //'password' => 'required|min:6|confirmed',
                ]);
            }
        }

        $idUser = $id;

        $conductor = 1;
        if($request['conductor']){
            $conductor = $request['conductor'];
        }

        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->estatus = $request->estatus;
        $usuario->id_tipo_users = $conductor;
        //$usuario->db_users = $request->cliente;
        
        if ($request->password) {
            if($request->email == $request->emailOriginal){
                $usuario->password = bcrypt($request->password);
            }else{
                $usuario->password = bcrypt($request->password);
                $usuario->email  = $request->email; 
            }
        }else{
            if($request->email != $request->emailOriginal){
                $usuario->email  = $request->email;
            }
        }

        /********************************************
         Permisos para los módulos
        ********************************************/

        $acldata = array();
        $template = array('R'=>0,'I'=>0,'U'=>0,'D'=>0,'SF'=>0,'DF'=>0);

        if ( isset($request->R) ){
            $data = $request->R;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['R'] = 1;
            }
        }

        if ( isset($request->I) ){
            $data = $request->I;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['I'] = 1;
            }
        }
        if ( isset($request->U) ){
            $data = $request->U;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['U'] = 1;
            }
        }
        if ( isset($request->D) ){
            $data = $request->D;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['D'] = 1;
            }
        }
        if ( isset($request->SF) ){
            $data = $request->SF;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['SF'] = 1;
            }
        }
        if ( isset($request->DF) ){
            $data = $request->DF;
            foreach ($data as $item) {
                if (!array_key_exists($item, $acldata))
                    $acldata[$item] = $template;
                $acldata[$item]['DF'] = 1;
            }
        }

        //Borra todos los permisos asociados al grupo
        $borra = DB::table('lista_control_accesos')->where('id_users', '=', $idUser)->delete();

        //obtenemos las llaves de un arreglo
        $idRecursos = array_keys($acldata);

        //obtenemos los id's padres de los elementos seleccionado
        $padres = DB::table('menus')
                    ->select('menus.id_padre', 'menus.id_recursos')
                    ->whereIn('id_recursos', $idRecursos)
                    ->distinct()
                    ->get();

        //Guardamos permisos de menus padres
        foreach ($padres as $key) {
            /*Acl::create([
                    'id_users' =>$idUser,
                    'id_recursos' => $key->id_recursos,
                    'R' => '1',
                    'I' => '0',
                    'U' => '0',
                    'D' => '0',
                    'SF' => '0',
                    'DF' => '0',
                ]);*/
            
            $recurso_padre = DB::table('menus')
                        ->select('menus.id_padre','menus.id_recursos')
                        ->where('id' , '=' , $key->id_padre)
                        ->distinct()
                        ->get();

            foreach ($recurso_padre as $value) {
                Acl::create([
                    'id_users' =>$idUser,
                    'id_recursos' => $value->id_recursos,
                    'R' => '1',
                    'I' => '0',
                    'U' => '0',
                    'D' => '0',
                    'SF' => '0',
                    'DF' => '0',
                ]);

                $recurso_hijo = DB::table('menus')
                        ->select('menus.id_padre','menus.id_recursos')
                        ->where('id' , '=' , $value->id_padre)
                        ->distinct()
                        ->get();

                foreach ($recurso_hijo as $valor) {
                    Acl::create([
                        'id_users' =>$idUser,
                        'id_recursos' => $valor->id_recursos,
                        'R' => '1',
                        'I' => '0',
                        'U' => '0',
                        'D' => '0',
                        'SF' => '0',
                        'DF' => '0',
                    ]);
                }      
            }       
        }     

        //Guardamos permisos por modulos para el grupo
        foreach ($acldata as $key => $value) {
            Acl::create([
                'id_users'    =>$idUser,
                'id_recursos' => $key,
                'R'  => $value['R'],
                'I'  => $value['I'],
                'U'  => $value['U'],
                'D'  => $value['D'],
                'SF' => $value['SF'],
                'DF' => $value['DF'],
            ]);
         }
        if ($usuario->save()) {
            return redirect('/usuarios')->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect('/usuarios')->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjDanger'),
            ]);
        }
    }

    // Borrado logico
    public function destroy($id){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return view('/home');
            }
        }
        # Fin de validación usuario activo
        
        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);
        if($perm[0]['D'] == 0){
            $mensaje = 'No cuentas con permiso para realizar esta acción';
            return redirect('/usuario')->with(["Error" => $mensaje]);
        }

        $usuario = User::find($id);
        $usuario->estatus = 0;

        if ($usuario->save()) {
            return redirect()->back()->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect()->back()->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjErrorBorrar').$replaced,
            ]);
        }
    }

    public function imagen($id){
        $datos = DB::table('contenidos')
                    ->where('id','=',$id)
                    ->get();

        echo '<!DOCTYPE html>
                <head>
                    <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
                <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
                <meta name="author" content="Themesbox">
                <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
                <title>Holomex</title>
                <!-- Fevicon -->
                <link rel="shortcut icon" href="assets/images/favicon.ico">
                <!-- Start css -->
                <!-- Switchery css -->
                <link href="/assets/plugins/switchery/switchery.min.css" rel="stylesheet">
                <!-- Apex css -->
                <link href="/assets/plugins/apexcharts/apexcharts.css" rel="stylesheet">
                <!-- Slick css -->
                <link href="/assets/plugins/slick/slick.css" rel="stylesheet">
                <link href="/assets/plugins/slick/slick-theme.css" rel="stylesheet">
                <link href="/assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
                <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                <link href="/assets/css/icons.css" rel="stylesheet" type="text/css">
                <link href="/assets/css/flag-icon.min.css" rel="stylesheet" type="text/css">
                <link href="/assets/css/style.css" rel="stylesheet" type="text/css">

                <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css"
                >
                <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                <link rel="stylesheet" type="text/css" href="/hotspot/jquery.hotspot.css">
                <!-- End css -->
            </head>
            <body class="vertical-layout">';



            echo "<div class='row' style='background-color: grey; margin: 0; padding:30px'>";
            echo "<div class='col-sm-8 mt-2 text-center offset-2 divImagen' id='theElement-0'>";
            echo "<img class='img-fluid' src='". asset('imagenesPaginas'). "/".json_decode($datos[0]->contenido)->seccionDos->imagen."' style='margin:0; padding:0; border: 1px solid;' id='imagen'>";
            echo "</div>";
            echo "</div>";
            echo '    <script
              src="https://code.jquery.com/jquery-3.4.1.min.js"
              integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>
                <script src="/assets/js/popper.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.js" integrity="sha256-FYpdV7ChCZtW4xZWtO5QNyY5ynaAm843CE8jjyJzCAw=" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.24.1/dist/feather.min.js"></script>

                <script src="/assets/js/bootstrap.min.js"></script>
                <script src="/assets/js/modernizr.min.js"></script>
                <script src="/assets/js/detect.js"></script>
                <script src="/assets/js/jquery.slimscroll.js"></script>
                <script src="/assets/js/vertical-menu.js"></script>
                <!-- Switchery js -->
                <script src="/assets/plugins/switchery/switchery.min.js"></script>
                <!-- Apex js -->
                <script src="/assets/plugins/apexcharts/apexcharts.min.js"></script>
                <script src="/assets/plugins/apexcharts/irregular-data-series.js"></script>
                <!-- Slick js -->
                <script src="/assets/plugins/slick/slick.min.js"></script>
                <!-- Custom Dashboard js -->   
                <script src="/assets/js/custom/custom-dashboard.js"></script>
                <!-- Sweet-Alert js -->
                <script src="/assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
                <script src="/assets/js/custom/custom-sweet-alert.js"></script>
                <!-- Core js -->
                <script src="/assets/js/core.js"></script>
                <script src="/assets/js/bootstrap.min.js"></script>
                <script src="/assets/js/modernizr.min.js"></script>
                <script type="text/javascript" src="/hotspot/jquery.hotspot.js"></script>
                <!-- End js -->
            </body>
            </html>';
            echo "<script> 
                $('#imagen').click(function(event) { 
                    /*var top = parseInt(event.clientY) - 15
                    var left = parseInt(event.clientX) - 15*/

                    var widget = this;
                    // Get coordinates
                    var offset = $(this).offset(),
                        relativeX = (event.pageX - offset.left),
                        relativeY = (event.pageY - offset.top);

                    var height = $(widget).height(),
                        width = $(widget).width();

                    var hotspot = { x: relativeX/width*100, y: relativeY/height*100 };
                    var htmlTop = hotspot.y
                    var htmlLeft = hotspot.x

                    //alert('Valor X '+ hotspot.x + ' Valor Y '+ hotspot.y )

                    swal({
                        title:'Posición del marker',
                        text:\"Por favor copia el texto de abajo y pega en el campo de marker seleccionado <br><br> <b><p id='p2'>x: \" +  htmlLeft + \", y: \" + htmlTop + \" </p></b>\",
                        type:'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Copiar texto',
                        cancelButtonText: 'Cerrar'
                    })
                    .then((value) => {
                        copiarAlPortapapeles('p2')
                        swal(`Texto copiado`);
                    });
                });

                function copiarAlPortapapeles(id_elemento) {
                  var aux = document.createElement('input');
                  aux.setAttribute('value', document.getElementById(id_elemento).innerHTML);
                  document.body.appendChild(aux);
                  aux.select();
                  document.execCommand('copy');
                  document.body.removeChild(aux);
                }
                
                
            </script>";
    }
}
?>
