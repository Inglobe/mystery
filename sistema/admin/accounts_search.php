<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link_ferozo,"accounts","accounts","username","Hosting","Cuentas","SELECT *, DATE_FORMAT(created,'%d/%m/%Y') AS created_f, AES_DECRYPT(password,CONCAT(username,'_FRZ')) AS pass FROM accounts",$paginacion);
//Filtros
$abm->addFilter("textField","domain","Dominio",40);
$abm->addFilter("textField","username","Usuario",40);
//Listado
$abm->addCol("domain","domain","Dominio",200,"left","left",true);
$abm->addCol("username","username","Usuario",50,"left","left",true);
$abm->addCol("pass","pass","Password",50,"left","left",true);
$abm->addCol("created","created_f","Fecha alta",50,"left","left",true);
$abm->addCol("reseller","reseller","Reseller",50,"left","left",true);
$abm->addButtonCol("accounts_add.pop.php","imagenes/btn_edit.gif","Contactos",660,450);

$abm->readOnly = true;

$abm->show();
?>