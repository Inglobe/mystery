<?
	require("procesos_globales.php");
	
	if(($handle = fopen("tmp/CUOTAS.TXT", "r")) !== FALSE){
		while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
			$num = count($data);
			
			$db_cuotas = new database;
			$query = "SELECT COUNT(*) AS nro FROM cuotas WHERE codigo = ".$data[2]." AND numero = ".$data[5];
			$db_cuotas->query($query);
			$db_cuotas->fetch();
			$aux = $db_cuotas->getValue("nro");
			if($aux > 0){
				//update
			}
			else{
				//insert
				
				$db_insert = new database;
				$query = "INSERT INTO 
								cuotas(
									empresa,
									emprendimiento,
									codigo,
									fechaemision,
									detalle,
									numero,
									cuota,
									importe1,
									fechavto1,
									importe2,
									fechavto2,
									importe3,
									fechavto3
								)
								VALUES(
									'".$data[0]."',
									".$data[1].",
									".$data[2].",
									STR_TO_DATE('".$data[3]."',''),
									'".$data[4]."',
									".$data[5].",
									'".$data[6]."',
									".$data[7].",
									STR_TO_DATE('".$data[8]."',''),
									".$data[9].",
									STR_TO_DATE('".$data[10]."',''),
									".$data[11].",
									STR_TO_DATE('".$data[12]."','')
								)
						";
						
				echo $query;
				//$db_insert->query($query);
			}
		}
		fclose($handle);
	}
?>