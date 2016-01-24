<?php 
Load::models("escaner");
class EscanerController extends AppController{
	public function crear(){
		if (Input::haspost("codigo","fecha")) {
			$escaner = new Escaner();
			$escaner->codigo = Input::post("codigo");
			$escaner->created = $escaner->formatFecha($_POST["fecha"]);
			View::select(null,"json");
			//$this->data = $escaner->formatFecha($_POST["fecha"]);die;
			if ($escaner->save()) {
				$this->data = array("response"=>true,'id'=>$escaner->last_id());
			}else{
				$this->data = array("response"=>false);
			}
		}
	}
	public function borrar($id_escaner){
		$escaner = Load::model("escaner")->find($id_escaner);
		View::select(null,'json');
		if ($escaner->delete()) {
			$this->data = array("response"=>true);
		}else{
			$this->data = array("response"=>false);
		}
	}
	public function index(){
		View::select(null,null);
		$escaners = Load::model("escaner")->find("order: created desc");
		$html = "";
		foreach ($escaners as $key => $value) {
			$html.='<tr><td>'.$value->codigo.'</td><td>'.$value->created.'</td><td id="'.$value->id.'" class="boton_borrar">Borrar</span></td></tr>';
			//$html.='<li class="list-group-item"><span class="badge boton_borrar" id="'.$value->id.'">Borrar</span><span class="badge">'.$value->created.'</span>'.$value->codigo.'</li>';
		}
		echo $html;
	}
	public function buscar(){
		if (Input::haspost("desde","hasta")) {
			$desde = Input::post("desde");
			$hasta = Input::post("hasta");
			$result = Load::model("escaner")->buscarEntre($desde,$hasta);
			if ($result) {
				View::select(null,null);
				echo $result;
			}else{
				View::select(null,'json');
				$this->data = false;
			}

		}
	}

	public function exportar(){
		View::select(null,null);
		$desde = Input::get("desde");
		$hasta = Input::get("hasta");
		if (!$desde) {
			$desde = Date("Y-m-d");
		}
		if (!$hasta) {
			$hasta = Date("Y-m-d");
		}
		$escaner = Load::model("escaner");
		$result = $escaner->buscarEntre($desde,$hasta,1);
		$escaner->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo $escaner->array2csv($result);
		die();
	}
}

 ?>