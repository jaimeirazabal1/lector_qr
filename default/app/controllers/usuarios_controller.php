<?php 
Load::models("usuarios");
class UsuariosController extends AppController{
	public function index(){
		$usuarios = new Usuarios();
		$this->usuarios = $usuarios->find();
	}
	public function new_(){

        if (Input::post("usuarios")) {
            $post_usuarios = Input::post("usuarios");
            if ($post_usuarios['clave'] != $post_usuarios['clave2']) {
                Flash::error("Las Claves no coinciden");
                Router::redirect("usuarios/");
                
                return;
            }
            $new_user = new Usuarios(Input::post("usuarios"));
            /*usuario por default*/
            $new_user->clave = $new_user->cript($new_user->clave);
       
            if ($new_user->save()) {
                Flash::valid("Usuario Creado!");
  
            }else{
                Flash::error("No se Creó el Usuario");
 

            }
        }
	}
	public function edit($id){
        if (Input::post("usuarios")) {
        	// echo "<pre>";
        	// var_dump(Input::post('usuarios'));
        	// echo "</pre>";

            $post_usuarios = Input::post("usuarios");
            if ($post_usuarios['clave11'] != $post_usuarios['clave22']) {
                Flash::error("Las Claves no coinciden");
                // Router::redirect("usuarios/");
                return;
            }
            $new_user = new Usuarios(Input::post("usuarios"));
            /*usuario por default*/
            $new_user->clave = $new_user->cript($post_usuarios['clave11']);
       
            if ($new_user->save()) {
                Flash::valid("Usuario Editado!");
  
            }else{
                Flash::error("No se Editar el Usuario");
 

            }
        }
		$usuarios = new Usuarios();
        $this->usuarios = $usuarios->find($id);
	}
	public function del($id){
		$usuarios = new Usuarios();
        $usuario = $usuarios->find($id);
        if ($usuario) {
        	if ($usuario->delete()) {
        		Flash::valid("Usuario Borrado");
        	}else{
        		Flash::error("El Usuario no se pudo borrar");
        	}
        }else{
        	Flash::error("El usuario no existe");
        }		
        Router::redirect("usuarios/");
	}
	
}
 ?>