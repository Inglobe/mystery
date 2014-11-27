<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}
	
	require_once(PATH_DATABASE);
	
	class login extends database {
	
		private $id_usuario = -1;
		private $nombre = '';
		private $apellido = '';
		private $usuario = '';
		private $foto = '';
		private $admin = 0;
		
		private $existe_usuario = false;
		
		function __construct($usuario,$password){
		
			parent::__construct();

			$sql = "
				SELECT 
					*
				FROM
					contactos
				WHERE
					user LIKE '".$usuario."' AND
					pass LIKE '".md5($password)."'
			";
			
			$this->query($sql);
			
			if($this->getRows() > 0){
				
				$this->fetch();
				
				$this->id_usuario = $this->getValue('id_contacto');
				$this->nombre = $this->getValue('nombre');
				$this->apellido = $this->getValue('apellido');
				$this->usuario = $usuario;
				$this->foto = $this->getValue('nombre');
				$this->admin = $this->getValue('id_cliente');
				
				$this->existe_usuario = true;
				
			}else{
				$this->login_error($usuario);
			}
		}
		
		function getIdUsuario(){
			return($this->id_usuario);
		}
		
		function getNombre(){
			return($this->nombre);
		}
		
		function getApellido(){
			return($this->apellido);
		}
		
		function getUsuario(){
			return($this->usuario);
		}
		
		function getFoto(){
			return($this->foto);
		}
		
		function isAdmin(){
			return($this->admin);
		}
		
		function existe(){
			return($this->existe_usuario);
		}
	}
?>