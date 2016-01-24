<?php 
class Escaner extends ActiveRecord{
	public function formatFecha($fecha){
		/*01-22-2016 09:58:56 asi viene*/
		$fecha_iz = explode(" ",$fecha);
		$hora =$fecha_iz[1];
		$trozos = explode("-",$fecha_iz[0]);
		$fecha_formateada = $trozos[2].'-'.$trozos[0]."-".$trozos[1]." ".$hora;
		return $fecha_formateada;
	}
	public function buscarEntre($f1,$f2,$array = false){
		$result = $this->buscarFechaSinHora();
		$fechas = array();
		foreach ($result as $key => $value) {

			if (strtotime($value->created) >= strtotime($f1) and strtotime($value->created) <= strtotime($f2)) {

				$fechas[] = $value;
			}
		}
		if ($fechas) {
			if (!$array) {
				$html = "<thead>
							<th>Codigo</th>
							<th>Fecha</th>
							<th>Acción</th>
						</thead>";
				foreach ($fechas as $key => $value) {
					$html.='<tr><td>'.$value->codigo.'</td><td>'.$value->created.'</td><td id="'.$value->id.'" class="boton_borrar">Borrar</span></td></tr>';
					//$html.='<li class="list-group-item"><span class="badge boton_borrar" id="'.$value->id.'">Borrar</span><span class="badge">'.$value->created.'</span>'.$value->codigo.'</li>';
				}
				return $html;
			}else{
				return $fechas;
			}
		}else{
			return false;
		}
	}

	public function buscarFechaSinHora(){
		$query="SELECT id, codigo, CAST(created as DATE) as created FROM `escaner`";
		$result = $this->find_all_by_sql($query);
		return $result;
	}

	public function array2csv($array)
	{	
		$array = json_decode(json_encode($array));
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		//fputcsv($df, array_keys(reset($array)));
		foreach ($array as $row) {
			fputcsv($df, (array)$row);
		}
		fclose($df);
		return ob_get_clean();
	}
	public function download_send_headers($filename) {
	    // disable caching
	    $now = gmdate("D, d M Y H:i:s");
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download  
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    header("Content-Disposition: attachment;filename={$filename}");
	    header("Content-Transfer-Encoding: binary");
	}
}

 ?>