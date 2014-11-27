<?
	define('PATHS',true);
	
	define('PATH_IDIOMA',$_SERVER['DOCUMENT_ROOT'].'/admin/lang/'.IDIOMA.'/idioma.php');

	// GLOBALES	
	define('PATH_CONFIG',$_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
	define('PATH_DATABASE',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/database/database.'.ENGINE.'.php');
	define('PATH_DATABASE_FORMAT',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/database_format.php');	
	define('PATH_PARAMETROS',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/parametros.php');
	define('PATH_FILESYSTEM',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/filesystem.php');
	define('PATH_LOGS',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/logs.php');
	define('PATH_DATA_EXCHANGE',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/data_exchange.php');
	define('PATH_DATA_VALIDATION',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/data_validation.php');
	define('PATH_FUNCIONES_GENERALES',$_SERVER['DOCUMENT_ROOT'].'/includes/funciones_generales.php');

	// ADMIN	
	define('PATH_ADMIN_MAIN',$_SERVER['DOCUMENT_ROOT'].'/admin/main.php');
	define('PATH_ADMIN_LOGIN',$_SERVER['DOCUMENT_ROOT'].'/admin/login.php');
	define('PATH_ADMIN_PROCESOS_GLOBALES',$_SERVER['DOCUMENT_ROOT'].'/admin/procesos_globales.php');
	define('PATH_LOGIN',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/login.php');
	define('PATH_ABM_ADDEDIT',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABM/ABMAddEdit.class.php');
	define('PATH_ABM_CONTROLS',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABM/ABMControls.class.php');
	define('PATH_ABM_PROCESS',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABM/ABMProcess.class.php');
	define('PATH_ABM_SEARCH',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABM/ABMSearch.class.php');
	
	// VENTAS	
	define('PATH_VENTAS_MAIN',$_SERVER['DOCUMENT_ROOT'].'/ventas/main.php');
	define('PATH_VENTAS_LOGIN',$_SERVER['DOCUMENT_ROOT'].'/ventas/login.php');
	define('PATH_VENTAS_PROCESOS_GLOBALES',$_SERVER['DOCUMENT_ROOT'].'/ventas/procesos_globales.php');

	// CONTROLS
	define('PATH_ABM_CONTROLS_TEXT',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/textField.inc.php');
	define('PATH_ABM_CONTROLS_PASS',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/passField.inc.php');
	define('PATH_ABM_CONTROLS_HIDDEN',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/hiddenField.inc.php');
	define('PATH_ABM_CONTROLS_TEXTAREA',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/textArea.inc.php');
	define('PATH_ABM_CONTROLS_RICHTEXT',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/richText.inc.php');
	define('PATH_ABM_CONTROLS_COMBO',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/combo.inc.php');
	define('PATH_ABM_CONTROLS_DATE',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/datePicker.inc.php');
	define('PATH_ABM_CONTROLS_PICTURE',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/pictureBox.inc.php');
	define('PATH_ABM_CONTROLS_FILE',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/fileBox.inc.php');
	define('PATH_ABM_CONTROLS_CHECK',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/checkBoxRadio.inc.php');
	define('PATH_ABM_PHOTO_GALLERY',$_SERVER['DOCUMENT_ROOT'].'/admin/clases/ABMControls/photoGallery.inc.php');
	
	// SITIO	
	define('PATH_SITIO_MAIN_PRINT',$_SERVER['DOCUMENT_ROOT'].'/main.print.php');
	define('PATH_SITIO_MAIN',$_SERVER['DOCUMENT_ROOT'].'/main.php');
	define('PATH_SITIO_PROCESOS_GLOBALES',$_SERVER['DOCUMENT_ROOT'].'/procesos_globales.php');
	define('PATH_CLASS_SITIO',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/sitio.php');
	define('PATH_CLASS_CARRERAS',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/sitio/carreras.php');
	define('PATH_CLASS_MODALIDADES',$_SERVER['DOCUMENT_ROOT'].'/includes/classes/sitio/modalidades.php');
?>