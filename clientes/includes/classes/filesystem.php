<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	define('FILESYSTEM',true);

	require_once(PATH_LOGS);
	
	class filesystem extends logs {
		
		private $fd;
		private $open_file = false;
		
		function __construct(){
			$this->open_file = false;
		}
		
		function __destruct(){
			if($this->open_file){
				$this->closefile();
			}
		}
		
		function exists($file){
			return(file_exists($file));
		}
		
		function openfile($file,$modo){
		
			if($this->exists($file)){
				$this->fd = fopen($file,$modo);
				$this->open_file = true;
			}else{
				$this->filesystem_error("Error al intentar abrir el archivo ".$file);
			}
			
			return($this->open_file);
		}
		
		function closefile(){
			if($this->open_file){
				fclose($this->fd);
			}
		}
		
		function write($txt){
			if($this->open_file){
				fwrite($this->fd,$txt);
			}
		}
		
		function upload($local_file,$to_upload){
		
			$ret = true;
			
			if(!move_uploaded_file($local_file,$to_upload)){
				$this->filesystem_error("Error al subir el archivo ".$local_file);
				$ret = false;
			}
			
			return($ret);
		}
		
		function delete($file){
		
			$ret = true;
			
			if($this->exists($file)){
				if(!unlink($file)){
					$this->filesystem_error("Error al borrar el archivo ".$file);
					$ret = false;
				}
			}else{
				$this->filesystem_error("Error al borrar el archivo ".$file);
				$ret = false;
			}
			
			return($ret);
		}
	}
?>