<?
	require_once('procesos_globales.php');
?>
<html>
	<head>
		<title>Reporte de proyectos</title>
		<style>
			body{
				font-family:Verdana, Arial, Helvetica, sans-serif;
				font-size:11px;
				color:#666666;
			}
			h2{
				margin-top:3px;
				margin-bottom:0px;
			}
			h3{
				margin-top:0px;
				margin-bottom:5px;
				float:right;
			}
			h2,h3,p,ul{
				clear:both;
			}
			ul{
				margin:0px;
				padding:0px;
			}
			li{
				float:left;
				list-style:none;
				margin-left:10px;
			}
			.usuarios{
			}
			.proyecto{
				padding:5px;
				border-bottom:1px solid;
				margin-bottom:-1px;
			}
			.cont_usuario{
				width:40px;;
			}
			.cont_usuario a{
				clear:both;
			}
			.cont_usuario span{
				clear:both;
			}
		</style>
	</head>
	<body>
		<h1>Reporte de proyectos</h1>
		<?
			$sql = "
				SELECT
					proyectos.id_proyecto AS id_proyecto,
					proyectos.nombre AS proyecto,
					clientes.nombre AS cliente,
					proyectos.obs AS observacion
				FROM
					proyectos INNER JOIN clientes ON (
						proyectos.id_cliente = clientes.id_cliente
					)
				WHERE
					proyectos.id_estado_proyecto <> 3
			";
			
			$result = mysql_query($sql,$link);
			
			while($row = mysql_fetch_assoc($result)){
		?>
		<div class="proyecto">
			<h2><?=$row['cliente']?></h2>
			<h3><?=$row['proyecto']?></h3>
			<p><?=$row['observacion']?></p>
			<?
				$_GET['id_proyecto'] = $row['id_proyecto'];
				
				include('reporte_proyectos_abiertos_usuarios.inc.php');
			?>
			<div style="clear:both"></div>
		</div>
		<?
			}
		?>
	</body>
</html>