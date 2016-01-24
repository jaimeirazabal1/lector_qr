<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
class AppController extends Controller
{
	public $acl; //variable objeto ACL
	public $userRol = ""; //variable con el rol del usuario autenticado en la aplicación

	final protected function initialize()
	{
		$this->kumbia_title = "Lector de Códigos Qr";

		/*--------------------------------------------------*/
		
		$controlador_actual = Router::get("controller");
		$accion_actual = Router::get("action");
		$ruta_actual = $controlador_actual."/".$accion_actual;
		$rutas_sin_autenticacion = array("index/login","index/logout","index/newuser");
	
		if (Auth::is_valid()) {
			
		}else{
			/*echo "<pre>";
			print_r($rutas_sin_autenticacion);
			print_r($ruta_actual);
			var_dump(in_array($ruta_actual, $rutas_sin_autenticacion));*/
			if (!in_array($ruta_actual, $rutas_sin_autenticacion)) {
				Flash::warning("Es necesario autenticarse para acceder al sitio");
				Router::redirect("index/login");
			}
		}

		/*----------------------------------------------------*/

	}

	final protected function finalize()
	{

	}
	

}
