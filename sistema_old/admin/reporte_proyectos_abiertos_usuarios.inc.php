<?
            $result_usuarios = mysql_query("SELECT
												u.id_usuario,
												u.nombre,
												u.user,
												u.foto,
												t.id_tarea
											FROM
												tareas t,
												usuarios u
											WHERE
												t.id_usuario_responsable = u.id_usuario AND
												(t.id_estado_tarea = 1 OR t.id_estado_tarea = 2) AND
												t.id_proyecto = ".$_GET["id_proyecto"]."
											",$link);
			echo mysql_error($link);
			while($fila_usuario = mysql_fetch_assoc($result_usuarios)){
				if(!tiene_hijos($fila_usuario["id_tarea"])){
					$usuarios[$fila_usuario["id_usuario"]] = $fila_usuario;
				}
			}
            ?>
            <div class="usuarios">
			  <ul>
			<?
			if(is_array($usuarios)){
				foreach($usuarios as $usuario){
			?>
				<li><div class="cont_usuario"><a href="reporte_horas_proyecto.php?id_proyecto=<?=$_GET["id_proyecto"]?>&id_usuario=<?=$usuario["id_usuario"]?>" target="_blank"><img src="imagen.php?ruta=../imagenes/usuarios/fotos/<?=$usuario["foto"]?>&amp;ancho=40&amp;alto=35&amp;mantener_ratio=1" alt="<?=$usuario["nombre"]?>" border="0" /></a><span><?=ucfirst($usuario["user"])?></span></div></li>
			<?
				}
			}
			unset($usuarios);
			?>
			  </ul>
			</div>