<?
	require(PATH_ABM_ADDEDIT);
	
	$abm = new ABMAddEdit("properties","inmuebles","id_inmueble","Sistema","Inmuebles",$data->get('abm_accion'),$data->get('id',DATA_EX_TYPE_INT,false),false);
	
	//Tab datos	
	$abm->addDate("Fecha de alta","fecha","");
	$abm->addCombo("Tipo","id_categoria","SELECT * FROM inmuebles_categorias ORDER BY titulo ASC","id_categoria","titulo",0,"--seleccionar--",true,"Categoría es requerida.");

	$abm->addSeparator("Atributos");
	
	$abm->addCheckBox("Alquiler","alquiler",0);
	$abm->addCheckBox("Venta","venta",0);
	$abm->addCheckBox("Alquiler temporario","alquiler_temporario",0);
	$abm->addCheckBox("Alquilado","alquilado",0);
	$abm->addCheckBox("Vendido","vendido",0);
	
	$abm->addSeparator("Valor");
	
	$abm->addTextField("Precio","precio","","\\\\.","",10,0,false,"Precio es requerido.");
	$abm->addCheckBox("Precio en Dolares","dolares",0);
	
	$abm->addSeparator("Información");
	
	$abm->addTextArea("Descripci&oacute;n","comodidades","","\\\\.","",70,4,false,"requerida.");
	$abm->addTextArea("Observación interna","obs","","\\\\.","",70,4,false,"requerida.");
	
	$abm->addSeparator();
	
	$abm->addRichText("Detalles","descripcion","",400);
	
	$abm->addSeparator();
	
	$abm->addCheckBox("Newsletters","newsletters",0);
	$abm->addCheckBox("Activo","activo",0);
	
	//Tab ubicacion
	$abm->addTextField("Nombre / Ubicación","nombre","","\\\\.","",70,0,false,"Nombre es requerido.",1);
	$abm->addCombo("Barrio","id_barrio","SELECT * FROM barrios ORDER BY descripcion ASC","id_barrio","descripcion",0,"--seleccionar--",true,"Barrio es requerido.",1);
	$abm->addTextField("Localidad","localidad","","\\\\.","",70,0,false,"Localidad es requerido.",1);
	
	$abm->addSeparator("Mapa",1);
	
	$html_mapa = '<iframe width="550" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/?ie=UTF8&amp;t=h&amp;vpsrc=0&amp;ll=-31.39216,-64.219873&amp;spn=0.001832,0.002945&amp;z=18&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/?ie=UTF8&amp;t=h&amp;vpsrc=0&amp;ll=-31.39216,-64.219873&amp;spn=0.001832,0.002945&amp;z=18&amp;source=embed" style="color:#0000FF;text-align:left">Ver mapa más grande</a></small>';
	$abm->addHTML("",$html_mapa,1);
	
	//Tab fotos
	$abm->addPhotoGallery("",2);	
	
	//Tab SEO
	$abm->addTextField("Título","nombre","","\\\\.","",70,0,false,"Nombre es requerido.",3);
	$abm->addSeparator("",3);
	$abm->addTextArea("Descripci&oacute;n","comodidades","","\\\\.","",70,2,false,"requerida.",3);
	
	$abm->setTabLabel(0,"Datos");
	$abm->setTabLabel(1,"Ubicación");
	$abm->setTabLabel(2,"Fotos");
	$abm->setTabLabel(3,"SEO");
	
	$abm->show();
?>