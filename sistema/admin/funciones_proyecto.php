<?php
function ordenar(&$orden,$columna){
	/*$encontrado=FALSE;
	for($i=0;$i<sizeof($orden);$i++){
		if($orden[$i]["CLAVE"]==$columna){
			if($i==0){
				if($orden[$i]["DIRECCION"]=="ASC")
					$orden[$i]["DIRECCION"]="DESC";
				else
					$orden[$i]["DIRECCION"]="ASC";
			}
			else{
				$aux[0]["CLAVE"]=$orden[$i]["CLAVE"];
				$aux[0]["DIRECCION"]=$orden[$i]["DIRECCION"];
				$encontrado=TRUE;
			}
		}
		if($encontrado){
			$orden[$i]["CLAVE"]=$orden[$i+1]["CLAVE"];
			$orden[$i]["DIRECCION"]=$orden[$i+1]["DIRECCION"];
		}
	}
	if($encontrado){
		$temp=array_pop($orden);
		$orden=array_merge($aux,$orden);
	}
	$salida.= $orden[0]["CLAVE"]." ".$orden[0]["DIRECCION"];
	for($i=1;$i<sizeof($orden);$i++){
		$salida.= ", ".$orden[$i]["CLAVE"]." ".$orden[$i]["DIRECCION"];
	}
	return $salida;*/
	return true;
}
function poner_flecha($columna_original,$orden,$skin){
	/*for($i=0;$i<sizeof($orden);$i++){
		if($columna_original == $orden[$i]["CLAVE"]){
			if($i==0){
				if($orden[$i]["DIRECCION"]=="DESC")
					return "<img src=\"skins/$skin/imagenes/flecha_arriba_negra.gif\" width=\"8\" height=\"6\" border=\"0\">";
				else
					return "<img src=\"skins/$skin/imagenes/flecha_abajo_negra.gif\" width=\"8\" height=\"6\" border=\"0\">";
			}
			else{
				if($orden[$i]["DIRECCION"]=="DESC")
					return "<img src=\"skins/$skin/imagenes/flecha_arriba_blanca.gif\" width=\"8\" height=\"6\" border=\"0\">";
				else
					return "<img src=\"skins/$skin/imagenes/flecha_abajo_blanca.gif\" width=\"8\" height=\"6\" border=\"0\">";
			}
		}
	}*/
	return true;
}
function poner_tilde($valor_logico){
	/*global $idioma;
	if($valor_logico==1){
		if($idioma=="es")
			return "Sí";
		else
			return "Yes";
	}
	else{
		return "No";
	}*/
	return true;
}
function actualizar_tareas($id_proyecto){
	global $link;

	$consulta_nivel1 = "SELECT * FROM tareas WHERE id_proyecto = ".$id_proyecto." AND id_tarea_padre = 0";
	$result_nivel1 = mysql_query($consulta_nivel1,$link);

	while($fila_nivel1 = mysql_fetch_assoc($result_nivel1)){
		if(tiene_hijos($fila_nivel1["id_tarea"])){

			$consulta_nivel2 = "SELECT * FROM tareas WHERE id_tarea_padre = ".$fila_nivel1["id_tarea"];
			$result_nivel2 = mysql_query($consulta_nivel2, $link);

			$pendiente_nivel2 = true;
			$proceso_nivel2 = false;
			$finalizado_nivel2 = true;

			while($fila_nivel2 = mysql_fetch_assoc($result_nivel2)){
				switch($fila_nivel2["id_estado_tarea"]){
					case 1:
						$finalizado_nivel2 = false;
						$proceso_nivel2 = true;
					break;
					case 2:
						$proceso_nivel2 = true;
						$finalizado_nivel2 = false;
						$pendiente_nivel2 = false;
					break;
					case 3:
						$proceso_nivel2 = true;
						$pendiente_nivel2 = false;
					break;
				}

				if(tiene_hijos($fila_nivel2["id_tarea"])){
					$consulta_nivel3 = "SELECT * FROM tareas WHERE id_tarea_padre = ".$fila_nivel2["id_tarea"];
					$result_nivel3 = mysql_query($consulta_nivel3, $link);

					$pendiente_nivel3 = true;
					$proceso_nivel3 = false;
					$finalizado_nivel3 = true;

					while($fila_nivel3 = mysql_fetch_assoc($result_nivel3)){
						switch($fila_nivel3["id_estado_tarea"]){
							case 1:
								$finalizado_nivel3 = false;
								$proceso_nivel3 = true;
							break;
							case 2:
								$proceso_nivel3 = true;
								$finalizado_nivel3 = false;
								$pendiente_nivel3 = false;
							break;
							case 3:
								$proceso_nivel3 = true;
								$pendiente_nivel3 = false;
							break;
						}

						if(tiene_hijos($fila_nivel3["id_tarea"])){
							$consulta_nivel4 = "SELECT * FROM tareas WHERE id_tarea_padre = ".$fila_nivel3["id_tarea"];
							$result_nivel4 = mysql_query($consulta_nivel4, $link);

							$pendiente_nivel4 = true ;
							$proceso_nivel4 = false;
							$finalizado_nivel4 = true;

							while($fila_nivel4 = mysql_fetch_assoc($result_nivel4)){
								switch($fila_nivel4["id_estado_tarea"]){
									case 1:
										$finalizado_nivel4 = false;
										$proceso_nivel4 = true;
									break;
									case 2:
										$proceso_nivel4 = true;
										$finalizado_nivel4 = false;
										$pendiente_nivel4 = false;
									break;
									case 3:
										$proceso_nivel4 = true;
										$pendiente_nivel4 = false;
									break;
								}
							}//nivel 4

							if($pendiente_nivel4 && !$finalizado_nivel4){
								mysql_query("UPDATE tareas SET id_estado_tarea = 1, fecha_inicio_real='0000-00-00', fecha_fin_real='0000-00-00' WHERE id_tarea = ".$fila_nivel3["id_tarea"], $link);
							}

							if($proceso_nivel4 && !$finalizado_nivel4 && !$pendiente_nivel4){
								$consulta = "SELECT * FROM tareas WHERE id_tarea = ".$fila_nivel3["id_tarea"];
								$result_consulta = mysql_query($consulta,$link);

								$fila_tmp = mysql_fetch_assoc($result_consulta);

								$stringq = "UPDATE tareas SET id_estado_tarea = 2 ";

								if($fila_tmp["fecha_inicio_real"] == "0000-00-00"){
									$stringq .= ", fecha_inicio_real=NOW() ";
								}

								$stringq.=", fecha_fin_real='0000-00-00' ";
								$stringq.="WHERE id_tarea = '".$fila_nivel3["id_tarea"]."'";

								mysql_query($stringq,$link);
							}

							if($finalizado_nivel4 && !$pendiente_nivel4){
								$consulta = "SELECT * FROM tareas WHERE id_tarea = ".$fila_nivel3["id_tarea"];
								$result_consulta = mysql_query($consulta,$link);
								$fila_tmp = mysql_fetch_assoc($result_consulta);

								$stringq = "UPDATE tareas SET id_estado_tarea = 3 ";
								if($fila_tmp["fecha_inicio_real"] == "0000-00-00"){
									$stringq .= ", fecha_inicio_real=NOW() ";
								}
								if($fila_tmp["fecha_fin_real"] == "0000-00-00"){
									$stringq .= ", fecha_fin_real = NOW() ";
								}

								$stringq .= "WHERE id_tarea='".$fila_nivel3["id_tarea"]."'";
								mysql_query($stringq,$link);
							}
						}
					}//nivel 3

					if($pendiente_nivel3 && !$finalizado_nivel3){
						mysql_query("UPDATE tareas SET id_estado_tarea = 1, fecha_inicio_real='0000-00-00', fecha_fin_real='0000-00-00' WHERE id_tarea = ".$fila_nivel2["id_tarea"],$link);
					}

					if($proceso_nivel3 && !$finalizado_nivel3 && !$pendiente_nivel3){
						$consulta = "SELECT * FROM tareas WHERE id_tarea = ".$fila_nivel2["id_tarea"];
						$result_consulta = mysql_query($consulta,$link);
						$fila_tmp = mysql_fetch_assoc($result_consulta);

						$stringq = "UPDATE tareas SET id_estado_tarea = 2 ";

						if($fila_tmp["fecha_inicio_real"] == "0000-00-00"){
							$stringq .= ", fecha_inicio_real=NOW() ";
						}

						$stringq.=", fecha_fin_real='0000-00-00' ";
						$stringq.="WHERE id_tarea = '".$fila_nivel2["id_tarea"]."'";
						mysql_query($stringq,$link);
					}

					if($finalizado_nivel3 && !$pendiente_nivel3){
						$consulta = "SELECT * FROM tareas WHERE id_tarea = ".$fila_nivel2["id_tarea"];
						$result_consulta = mysql_query($consulta,$link);
						$fila_tmp = mysql_fetch_array($result_consulta);

						$stringq = "UPDATE tareas SET id_estado_tarea = 3 ";

						if($fila_tmp["fecha_inicio_real"] == "0000-00-00"){
							$stringq .= ", fecha_inicio_real = NOW() ";
						}

						if($fila_tmp["fecha_fin_real"] == "0000-00-00"){
							$stringq .= ", fecha_fin_real=NOW() ";
						}

						$stringq .= "WHERE id_tarea='".$fila_nivel2["id_tarea"]."'";

						mysql_query($stringq,$link);
					}
				}
			}//nivel 2

			if($pendiente_nivel2 && !$finalizado_nivel2){
				mysql_query("UPDATE tareas SET id_estado_tarea = 1, fecha_inicio_real='0000-00-00', fecha_fin_real='0000-00-00' WHERE id_tarea = '".$fila_nivel1["id_tarea"]."'",$link);
			}

			if($proceso_nivel2 && !$finalizado_nivel2 && !$pendiente_nivel2){
				$consulta = "SELECT * FROM tareas WHERE id_tarea = '".$fila_nivel1["id_tarea"]."'";
				$result_consulta = mysql_query($consulta,$link);

				$fila_tmp = mysql_fetch_assoc($result_consulta);

				$stringq="UPDATE tareas SET id_estado_tarea = 2 ";

				if($fila_tmp["fecha_inicio_real"] == "0000-00-00"){
					$stringq.=", fecha_inicio_real = NOW() ";
				}

				$stringq.=", fecha_fin_real = '0000-00-00' ";
				$stringq.="WHERE id_tarea = '".$fila_nivel1["id_tarea"]."'";

				mysql_query($stringq,$link);
			}

			if($finalizado_nivel2 && !$pendiente_nivel2){
				$consulta = "SELECT * FROM tareas WHERE id_tarea = '".$fila_nivel1["id_tarea"]."'";
				$result_consulta = mysql_query($consulta,$link);

				$fila_tmp = mysql_fetch_assoc($result_consulta);

				$stringq="UPDATE tareas SET id_estado_tarea = 3 ";

				if($fila_tmp["fecha_inicio_real"] == "0000-00-00"){
					$stringq .= ", fecha_inicio_real = NOW() ";
				}
				if($fila_tmp["fecha_fin_real"] == "0000-00-00"){
					$stringq .= ", fecha_fin_real = NOW() ";
				}

				$stringq.="WHERE id_tarea='".$fila_nivel1["id_tarea"]."'";
				mysql_query($stringq,$link);
			}
		}
	}//nivel 1
}
function tiene_hijos($id_tarea){
	global $link;

	$fila = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM tareas WHERE id_tarea_padre = ".$id_tarea,$link));
	echo mysql_error($link);

	if($fila["nro"]>0){
		return true;
	}
	else {
		return false;
	}
}
/*function chequear_permiso($nombre_permiso){
	global $link;
	global $_SESSION;
	$CadenaSQL="SELECT * FROM USUARIOS WHERE ID_USUARIO = ".$_SESSION["id_usr"];
	$result_consulta = mysql_query($CadenaSQL,$link);
	if($result_consulta)
		$fila=mysql_fetch_array($result_consulta);
	if($fila[strtoupper("SEG_".$nombre_permiso)]==1)
		return true;
	else
		return false;
}*/
function chequear_permiso($nombre_permiso){
	/*global $link;
	global $_SESSION;
	$CadenaSQL="SELECT 		COUNT(*) AS nro
				FROM 		usuarios_permisos UP,
							permisos P
				WHERE 		UP.id_usuario = ".$_SESSION["id_usr"]."
				AND			UP.id_permiso = P.id_permiso
				AND			P.abr LIKE '".strtoupper("SEG_".$nombre_permiso)."'
				";

	$result_consulta = mysql_query($CadenaSQL,$link);
	echo mysql_error($link);
	if($result_consulta)
		$fila=mysql_fetch_array($result_consulta);
	return ($fila["nro"] == 1);*/
	return true;
}
function checkOwnerTarea($id_tarea,$id_usuario){
	/*global $link;

	$fila_tmp=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM tareas WHERE id_tarea = ".$id_tarea." AND id_usuario_owner = ".$id_usuario,$link));

	if($fila_tmp["nro"]==1){
		return true;
	}
	else{
		return false;
	}*/
	return true;
}
function chequear_permiso_tarea($nombre_permiso,$id_tarea,$id_proyecto_param){
	/*global $link;
	global $_SESSION;

	$CadenaSQL="SELECT * FROM proyectos WHERE id_proyecto = $id_proyecto_param";
	$result_consulta = mysql_query($CadenaSQL,$link);
	$fila_proyecto=mysql_fetch_array($result_consulta);

	$CadenaSQL="SELECT * FROM tareas WHERE id_tarea = ".$id_tarea;
	$result_consulta = mysql_query($CadenaSQL,$link);
	$fila_tarea=mysql_fetch_array($result_consulta);

	if($fila_proyecto["id_usuario_owner"]==$_SESSION["id_usr"]){
		return true;
	}
	else{
		if($fila_proyecto["id_usuario_responsable"]==$_SESSION["id_usr"]){
			//ES RESPONSABLE
			switch($nombre_permiso){
				case "agregar_tareas":
				case "editar_tareas":
					return chequear_permiso("proyectos_".$nombre_permiso);
				break;
				case "borrar_tareas":
					return (chequear_permiso("proyectos_".$nombre_permiso) && !($fila_tarea["id_usuario_owner"] == $fila_proyecto["id_usuario_owner"]));
				break;
			}
		}
		else{
			//ES TRABAJADOR
			switch($nombre_permiso){
				case "agregar_tareas":
					return chequear_permiso("proyectos_".$nombre_permiso);
				break;
				case "editar_tareas":
					return (chequear_permiso("proyectos_".$nombre_permiso) && ($fila_tarea["id_usuario_owner"]==$_SESSION["id_usr"] || $fila_tarea["id_usuario_owner"]==$_SESSION["id_usr"]));
				case "borrar_tareas":
					return (chequear_permiso("proyectos_".$nombre_permiso) && $fila_tarea["id_usuario_owner"]==$_SESSION["id_usr"]);
				break;
			}
		}
	}*/
	return true;
}
function avance_ponderado($id_proyecto){
	global $link;

	$cont_nivel1 = 0;
	$cont_nivel1_finalizadas = 0;

	$consulta_nivel1 = "SELECT * FROM tareas WHERE id_proyecto = '".$id_proyecto."' AND id_tarea_padre = 0";
	$result_nivel1 = mysql_query($consulta_nivel1,$link);
	while($fila_nivel1 = mysql_fetch_assoc($result_nivel1)){
		$cont_nivel1 ++;

		if($fila_nivel1["id_estado_tarea"] == 3){
			$cont_nivel1_finalizadas ++;
		}

		if($fila_nivel1["id_estado_tarea"]==2 && tiene_hijos($fila_nivel1["id_tarea"])){
			$cont_nivel2 = 0;
			$cont_nivel2_finalizadas = 0;

			$consulta_nivel2 = "SELECT * FROM tareas WHERE id_tarea_padre = ".$fila_nivel1["id_tarea"];

			$result_nivel2 = mysql_query($consulta_nivel2,$link);
			while($fila_nivel2 = mysql_fetch_assoc($result_nivel2)){
				$cont_nivel2 ++;

				if($fila_nivel2["id_estado_tarea"] == 3){
					$cont_nivel2_finalizadas++;
				}

				if($fila_nivel2["id_estado_tarea"] == 2 && tiene_hijos($fila_nivel2["id_tarea"])){
					$cont_nivel3 = 0;
					$cont_nivel3_finalizadas = 0;

					$consulta_nivel3 = "SELECT * FROM tareas WHERE id_tarea_padre = ".$fila_nivel2["id_tarea"];

					$result_nivel3 = mysql_query($consulta_nivel3,$link);
					while($fila_nivel3 = mysql_fetch_array($result_nivel3)){
						$cont_nivel3 ++;

						if($fila_nivel3["id_estado_tarea"] == 3){
							$cont_nivel3_finalizadas ++;
						}

						if($fila_nivel3["id_estado_tarea"] == 2 && tiene_hijos($fila_nivel3["id_tarea"])){
							$cont_nivel4 = 0;
							$cont_nivel4_finalizadas = 0;

							$consulta_nivel4 = "SELECT * FROM tareas WHERE id_tarea_padre = ".$fila_nivel3["id_tarea"];

							$result_nivel4 = mysql_query($consulta_nivel4,$link);
							while($fila_nivel4 = mysql_fetch_array($result_nivel4)){
								$cont_nivel4 ++;

								if($fila_nivel4["id_estado_tarea"] == 3){
									$cont_nivel4_finalizadas++;
								}

							}//nivel 4
							if($cont_nivel4!=0){
								$cont_nivel3_finalizadas += ($cont_nivel4_finalizadas/$cont_nivel4);
							}
						}

					}//nivel 3
					if($cont_nivel3!=0){
						$cont_nivel2_finalizadas += ($cont_nivel3_finalizadas/$cont_nivel3);
					}
				}
			}//nivel 2
			if($cont_nivel2!=0){
				$cont_nivel1_finalizadas += ($cont_nivel2_finalizadas/$cont_nivel2);
			}
		}
	}//nivel 1
	if($cont_nivel1!=0){
		$porcentaje=number_format(($cont_nivel1_finalizadas/$cont_nivel1)*100,2);
	}
	return $porcentaje;
}
function checkExistsUsuario($id_proyecto_param){
	/*global $link;
	global $_SESSION;

	$consulta="SELECT COUNT(*) NRO FROM tareas WHERE id_proyecto = ".$id_proyecto_param." AND id_usuario_responsable = ".$_SESSION["id_usr"];
	$fila_tmp = mysql_fetch_assoc(mysql_query($consulta,$link));
	if($fila_tmp["nro"] > 0){
		return true;
	}
	else{
		return false;
	}*/
	return true;
}
function tiene_archivos($id_tarea){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM archivos_tarea WHERE id_tarea = ".$id_tarea,$link));

	if($fila_tmp["nro"]>0){
		return true;
	}
	else{
		return false;
	}
}
function getHorasProyectos ($id_proyecto){
	global $link;

	$consulta = "SELECT SUM(tiempo) AS sum_tiempo FROM tareas WHERE id_proyecto = ".$id_proyecto;
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);

	$fila = mysql_fetch_assoc($result);

	$tiempo = $fila["sum_tiempo"] / 60;

	return ceil($tiempo);
}
function getHorasEstimadasProyectos ($id_proyecto){
	global $link;

	$consulta = "SELECT SUM(tiempo_estimado) AS sum_tiempo FROM tareas WHERE id_proyecto = ".$id_proyecto;
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);

	$fila = mysql_fetch_assoc($result);

	$tiempo = $fila["sum_tiempo"] / 60;

	return ceil($tiempo);
}
function getTareasOcultas ($id_tarea, $id_usuario){
	global $link;

	$consulta = "SELECT COUNT(*) AS nro FROM tareas_ocultas WHERE id_tarea = '".$id_tarea."' AND id_usuario = '".$id_usuario."'";
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);

	$fila = mysql_fetch_assoc($result);

	if($fila["nro"] > 0){
		return true;
	}
	else {
		return false;
	}
}
function getProyecto($id_proyecto){
	global $link;

	$consulta = "SELECT nombre FROM proyectos WHERE id_proyecto = ".$id_proyecto;
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);

	$fila = mysql_fetch_assoc($result);

	return $fila["nombre"];
}
function getNombreTarea($id_tarea){
	global $link;

	$consulta = "SELECT descripcion FROM tareas WHERE id_tarea = ".$id_tarea;
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);

	$fila = mysql_fetch_assoc($result);

	return $fila["descripcion"];
}
function getTareaPadre($id_tarea, $ruta){
	global $link;

	$consulta = "SELECT id_tarea_padre, id_proyecto FROM tareas t WHERE id_tarea = ".$id_tarea;
	$result = mysql_query($consulta, $link);
	echo mysql_error($link);

	$fila = mysql_fetch_assoc($result);

	if($fila["id_tarea_padre"] != 0){
		$ruta_i = getNombreTarea($fila["id_tarea_padre"]).($ruta != ""?" / ":"").$ruta;
		return getTareaPadre($fila["id_tarea_padre"], $ruta_i);
	}
	else {
		return getProyecto($fila["id_proyecto"]).($ruta != ""?" / ":"").$ruta;
	}
}
function getTareasPadres($id_tarea){
	global $link;

	$ruta = "";

	return getTareaPadre($id_tarea, $ruta);
}
?>