<?
	function dosDigitos($nro){
		if(strlen($nro) <= 1){
			$nro = "0".$nro;
		}
		return($nro);
	}

	function calcularHora($x){
	
		$horas = floor($x/3600);
		$minutos = floor(($x%3600)/60);
		$segundos = ($x%3600)%60;
		
		$tiempo = dosDigitos($horas).":".dosDigitos($minutos).":".dosDigitos($segundos);
		
		return($tiempo);
	}
?>