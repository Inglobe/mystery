<?
	function tiene_hijos($id_tarea){
		$db = new database;
		$db->query("SELECT COUNT(*) AS nro FROM tareas WHERE id_tarea_padre = ".$id_tarea);
		$db->fetch();
		$nro = $db->getValue("nro");
		
		if($nro>0){
			return true;
		}
		else {
			return false;
		}
	}
	
	function porcRamaGralByDesc($desc, $id_cliente, $desc_padre = "", $id_sucursal = 0){
		$db = new database;
		$sql = "
			SELECT 
				t.id_tarea,
				t.tiempo,
				t.tiempo_estimado,
				t.descripcion
			FROM
				tareas t
				JOIN proyectos p ON t.id_proyecto = p.id_proyecto
			WHERE
				t.descripcion LIKE '".$desc."' AND
				t.ocultar = 0 AND
				p.id_cliente = ".$id_cliente." AND
				p.id_estado_proyecto = 3 AND
				p.plantilla = 0
		";
		
		if(!empty($id_sucursal)){
			$sql.=" AND
				p.id_sucursal = ".$id_sucursal." 
			";
		}
		
		if(!empty($desc_padre)){
			$sql.=" AND
				'".$desc_padre."' LIKE (
					SELECT tp.descripcion FROM tareas tp WHERE tp.id_tarea = t.id_tarea_padre
				)
			";
		}

		$db->query($sql);
		
		$total = 0;
		$cantidad = 0;
		while($db->fetch()){
			//echo $db->getValue("id_tarea")." - ".$db->getValue("descripcion");
			$cantidad++;
			if(tiene_hijos($db->getValue("id_tarea"))){
				$porc = porcRamaById($db->getValue("id_tarea"));
			}
			else{
				$puntajes_perm = $db->getValue("tiempo_estimado");
				$aux = explode(",", $puntajes_perm);
				$puntos_max = array_pop($aux);
				$porc = $db->getValue("tiempo")*100/ $puntos_max;
			}
			//echo " = ".$porc." | ";
			$total+= $porc;
			//echo $total;
			//echo "<hr />";
		}
		if(!empty($total) && !empty($cantidad)){
			return number_format($total/$cantidad,1);
		}
		else{
			return 0;
		}
	}
	
	function porcTareaGralByDesc($desc, $id_cliente, $desc_padre = "", $id_sucursal = 0){
		$db = new database;
		$sql = "
			SELECT 
				t.id_tarea,
				t.tiempo,
				t.tiempo_estimado,
				t.descripcion
			FROM
				tareas t
				JOIN proyectos p ON t.id_proyecto = p.id_proyecto
			WHERE
				t.descripcion LIKE '".$desc."' AND
				t.ocultar = 0 AND
				p.id_cliente = ".$id_cliente." AND
				p.id_estado_proyecto = 3 AND
				p.plantilla = 0
		";
		
		if(!empty($id_sucursal)){
			$sql.=" AND
				p.id_sucursal = ".$id_sucursal." 
			";
		}
		
		if(!empty($desc_padre)){
			$sql.=" AND
				'".$desc_padre."' LIKE (
					SELECT tp.descripcion FROM tareas tp WHERE tp.id_tarea = t.id_tarea_padre
				) 
			";
		}
		else{
			$sql.=" AND
				t.id_tarea_padre = 0 
			";
		}

		$db->query($sql);
		
		$total = 0;
		$total_max = 0;
		$cantidad = 0;
		while($db->fetch()){
			if(!tiene_hijos($db->getValue("id_tarea"))){
				//echo $db->getValue("id_tarea")." - ".$db->getValue("descripcion");
				$cantidad++;
				$porc = $db->getValue("tiempo");
				//echo " = ".$porc." | ";
				$total+= $porc;
				
				$puntajes_perm = $db->getValue("tiempo_estimado");
				$aux = explode(",", $puntajes_perm);
				$puntos_max = array_pop($aux);
				
				$total_max+= $puntos_max;
				//echo $total;
				//echo "<hr />";
			}
		}
		if(!empty($total) && !empty($cantidad)){
			return number_format($total*100/$total_max,1);
		}
		else{
			return 0;
		}
	}
	
	function porcAtencionBySucursal($id_sucursal){
		$db = new database;
		$sql = "
			SELECT 
				t.id_tarea
			FROM
				tareas t
				JOIN proyectos p ON t.id_proyecto = p.id_proyecto
			WHERE
				p.id_sucursal = ".$id_sucursal." AND
				t.ocultar = 0 AND
				p.id_estado_proyecto = 3 AND
				p.plantilla = 0
			";
		
		$db->query($sql);
		$cantidad = 0;
		$total = 0;
		while($db->fetch()){
			$cantidad++;
			
			$total+= porcRamaById($db->getValue("id_tarea"));
		}
		
		return $total / $cantidad;
	}
	
	function porcRamaById($id_padre,&$datos = array("total"=>0,"total_max"=>0,"cantidad"=>0)){
		$db = new database;
		$sql = "
			SELECT 
				t.id_tarea,
				t.tiempo,
				t.tiempo_estimado
			FROM
				tareas t
			WHERE
				t.id_tarea_padre = ".$id_padre." AND
				t.ocultar = 0
		";

		$db->query($sql);
		
		while($db->fetch()){
			//echo $db->getValue("tiempo").", ";
			
			$puntajes_perm = $db->getValue("tiempo_estimado");
			$aux = explode(",", $puntajes_perm);
			$puntos_max = array_pop($aux);
			//echo "pmax: ".$puntos_max ."\n<br />";
			if(!empty($puntos_max)){
				//$porc = $db->getValue("tiempo")*100/$puntos_max;
				$puntos = $db->getValue("tiempo");
			
				$datos["total"]+= $puntos;
				$datos["total_max"]+= $puntos_max;
				$datos["cantidad"]++;
			}
			porcRamaById($db->getValue("id_tarea"),$datos);
		}
		
		if(!empty($datos["total"]) && !empty($datos["total_max"]) && !empty($datos["cantidad"])){
			//return $datos["total"]/$datos["cantidad"];
			return $datos["total"]*100/$datos["total_max"];
		}
		else{
			return 0;
		}
		
		return $datos["total"];
	}
	
	function porcTotalByAuditoria($id_proyecto, $desc_padre){
		$db = new database;
		$sql = "
				SELECT 
					t.tiempo,
					t.tiempo_estimado
				FROM 
					tareas t 
				WHERE
					t.id_proyecto = ".$id_proyecto." AND
					t.ocultar = 0
				";
		
		if(!empty($desc_padre)){
			$sql.=" AND
				'".$desc_padre."' LIKE (
					SELECT tp.descripcion FROM tareas tp WHERE tp.id_tarea = t.id_tarea_padre
				)
			";
		}
				
		$db->query($sql);
		$total = 0;
		$cantidad = 0;
		while($db->fetch()){
			
			$puntajes_perm = $db->getValue("tiempo_estimado");
			$aux = explode(",", $puntajes_perm);
			$puntos_max = array_pop($aux);
			if(!empty($puntos_max)){
				$cantidad++;
				
				$total+= $db->getValue("tiempo")*100/$puntos_max;
			}
		}
		
		if(!empty($total) && !empty($cantidad)){
			return $total/$cantidad;
		}
		else{
			return 0;
		}
	}
	
	function porcTotalByCliente($id_cliente){
		$db = new database;
		$sql = "
				SELECT 
					p.id_proyecto
				FROM 
					proyectos p
				WHERE
					p.id_cliente = ".$id_cliente." AND
					p.id_estado_proyecto = 0 AND
					p.plantilla = 0
				";
		$db->query($sql);

		$total = 0;
		$cantidad = 0;
		while($db->fetch()){
			$cantidad++;
			$total+= porcTotalByAuditoria($db->getValue("id_proyecto"));
		}
		
		return $total / $cantidad;
	}
	
	function porcTotalBySucursal($id_sucursal, $desc_padre =""){
		$db = new database;
		$sql = "
				SELECT 
					p.id_proyecto
				FROM 
					proyectos p
				WHERE
					p.id_sucursal = ".$id_sucursal."  AND
					p.id_estado_proyecto = 3 AND
					p.plantilla = 0
				";
		$db->query($sql);
		
		$total = 0;
		$cantidad = 0;
		while($db->fetch()){
			$cantidad++;
			$total+= porcTotalByAuditoria($db->getValue("id_proyecto"), $desc_padre);
		}
		
		return $total / $cantidad;
	}
	
	function ventasBySucursal($id_sucursal){
		$db = new database;
		$sql = "
				SELECT 
					SUM(p.monto_compra) AS total
				FROM 
					proyectos p
				WHERE
					p.id_sucursal = ".$id_sucursal."  AND
					p.id_estado_proyecto = 3 AND
					p.plantilla = 0
				";
		$db->query($sql);
		$db->fetch();
		
		return $db->getValue("total");
	}
?>