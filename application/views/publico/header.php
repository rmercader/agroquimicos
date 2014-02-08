<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Proquimur</title>
<link href="<?=base_url()?>css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>css/style-proquimur.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="bgheader">
<div class="contenedor_sitio clearfix">
  <div class="header">
   	<div class="rec-bus">
    	<div class="lang sinbor"><a href="<?=base_url()?>esp"><img src="<?=base_url()?>images/banesp.png" width="22" height="22" /></a></div>
        <div class="lang"><a href="<?=base_url()?>eng"><img src="<?=base_url()?>images/baning.png" width="22" height="22" /></a></div>
        <div class="lupa"><img src="<?=base_url()?>images/lupa.png" width="20" height="20" /></div><input name="" type="text" />
      </div>
    <div class="logo"><img src="<?=base_url()?>images/logo.png" width="380" height="150" /></div>
  </div>
 <!--arranca menu-->
 <div>
	<ul class="menu1">
	<li class="bot_inicio_activo"><?=$etiquetasMenu['menu_inicio']?></li>
	<li class="bot_empresa">
    	<a href="#" title="empresa" target="_self"><?=$etiquetasMenu['menu_empresa']?></a>
    	<ul>
          <li><a href="<?=base_url()?>quienes-somos">Quiénes somos?</a></li>
          <li><a href="<?=base_url()?>mision-y-vision">Misión y visión</a></li>
          <li><a href="<?=base_url()?>politica-ambiental">Política ambiental</a></li>
          <li><a href="<?=base_url()?>politica-calidad">Política de calidad</a></li>
          <li><a href="<?=base_url()?>politica-seguridad">Política de seguridad</a></li>
          <li><a href="<?=base_url()?>planta-industrial">Planta industrial</a></li>
        </ul>
    </li>
	<li class="bot_productos">
    <a href="productos.html" title="productos" target="_self"><?=$etiquetasMenu['menu_productos']?></a>
    <ul>
      <?php foreach($categorias_menu as $categoria): ?>
      <li>
        <a href="#"><?=$categoria['nombre']?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </li>      
	<li class="bot_serv"><a href="#" title="servicios" target="_self"><?=$etiquetasMenu['menu_servicios']?></a>
          <ul>
				<li><a href="#">Información técnica</a></li>
				<li><a href="#">Fichas de seguridad</a></li>
			  </ul>
    </li>
	<li class="bot_nov">
    	<a href="#" title="novedades" target="_self"><?=$etiquetasMenu['menu_novedades']?></a>
 				<ul>
  				<?php foreach($novedades_menu as $novedad): ?>
          <li>
            <a href="#"><?=$novedad['titulo']?></a>
          </li>
          <?php endforeach; ?>
			  </ul>   
        </li>
 	<li class="bot_contacto"><a href="contacto.html" title="contacto" target="_self"><?=$etiquetasMenu['menu_contacto']?></a></li>
	</ul>
</div>