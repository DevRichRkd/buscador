<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*$proxy_url    = getenv('PROXY_URL');
$proxy_schema = getenv('PROXY_SCHEMA');

if (!empty($proxy_url)) {
   URL::forceRootUrl($proxy_url);
}

if (!empty($proxy_schema)) {
   URL::forceScheme($proxy_schema);
}*/

//Muestra la vista web principal
Route::get('/','VistaController@index');
//Muestra la vista de búsqueda avanzada
Route::get('/busqueda-avanzada','VistaController@busqueda');
// metodo que realiza la búsqueda avanzada
Route::get('/buscar','VistaController@buscar');
//Muestra los resultados por nivel
Route::get('/nivel/{id}','VistaController@show');
//realiza la búsqueda general
Route::get('/busqueda-general','VistaController@general');

Route::get('/filtros/{buscar}/{nivel}/{ejercicio}/{tema}/{pais}/{pertencia}/{procedencia}/{clave}/{autor}/{titulo}','VistaController@filtros');
 
Route::get('/resultados','VistaController@resultados');



//Muestra todos los Expedientes por ID
Route::get('/expedientes/{id}','VistaController@getTipoExpedienteById');

Route::get('/filters/{buscar}/{expediente}/{entidad}/{anio}/{tipo}/{epoca}/{materia}/{seccion}','VistaController@filters');

Route::get('/result','VistaController@result');


Auth::routes();
Route::get('/home',function () {
   if(isset(Auth::user()->id)){
		return view("home");

	}else{
    	return view('auth.login');
	}
});
//Route::get('/home', 'ClientesController@index');

Route::resource('/usuarios','HomeController');
Route::resource('/recursos','RecursosController');
Route::resource('/menu','MenuController');
Route::get('/iconos', function(){
	return view("menu.iconos");
})->name('iconos');

Route::resource('/niveles','NivelController');
Route::resource('/pais','PaisController');
Route::resource('/temas','TemaController');
Route::resource('/ejercicios','EjercicioController');
Route::resource('/consultas','ConsultaController');
Route::resource('/glosario','GlosarioController');
Route::resource('/pertenencia','PertenenciaController');
Route::resource('/procedencia','ProcedenciaController');
Route::resource('/ajustes','AjusteController');

Route::resource('/expedientes','ExpedientesController');
Route::resource('/entidades','EntidadesController');
Route::resource('/anios','AniosController');
Route::resource('/materias','MateriasController');
Route::resource('/criterios','CriteriosController');
Route::resource('/epocas','EpocasController');
Route::resource('/secciones','SeccionesController');
Route::resource('/organismos','OrganismosController');
Route::resource('/informacion','InformacionController');

Route::get('/organismosByentidad/{id}','OrganismosController@getOrganismosByIdEntidad');
Route::get('/expedientesByClave/{clave}/{id}','VistaController@getExpedientesByClave');
Route::get('/expediente/{id}/{clave}','VistaController@getExpedienteById');

Route::resource('/loadcsv', 'PagesController');
Route::post('/uploadFile', 'PagesController@uploadFile');


