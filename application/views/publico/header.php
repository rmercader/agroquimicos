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
	<li class="bot_inicio_activo"><?=lang('menu_inicio')?></li>
	<li class="bot_empresa">
  	<a href="#" title="empresa" target="_self"><?=lang('menu_empresa')?></a>
  	<ul>
        <li><a href="<?=base_url() . lang('uri_quienes_somos')?>"><?=lang('menu_quienes_somos')?></a></li>
        <li><a href="<?=base_url() . lang('uri_mision_y_vision')?>"><?=lang('menu_mision_y_vision')?></a></li>
        <li><a href="<?=base_url() . lang('uri_politica_ambiental')?>"><?=lang('menu_politica_ambiental')?></a></li>
        <li><a href="<?=base_url() . lang('uri_politica_calidad')?>"><?=lang('menu_politica_calidad')?></a></li>
        <li><a href="<?=base_url() . lang('uri_politica_seguridad')?>"><?=lang('menu_politica_seguridad')?></a></li>
        <li><a href="<?=base_url() . lang('uri_planta_industrial')?>"><?=lang('menu_planta_industrial')?></a></li>
    </ul>
  </li>

	<li class="bot_productos">
    <a href="<?=base_url() . lang('uri_productos')?>" title="<?=lang('menu_productos')?>" target="_self"><?=lang('menu_productos')?></a>
    <ul>
      <?php foreach($categorias_menu as $categoria): ?>
      <li>
        <a href="#"><?=$categoria['nombre']?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </li>      
	<li class="bot_serv"><a href="#" title="servicios" target="_self"><?=lang('menu_servicios')?></a>
    <ul>
				<li><a href="<?=base_url() . lang('uri_informacion_tecnica')?>"><?=lang('menu_informacion_tecnica')?></a></li>
				<li><a href="<?=base_url() . lang('uri_fichas_seguridad')?>"><?=lang('menu_fichas_seguridad')?></a></li>
		</ul>
  </li>
	<li class="bot_nov">
    	<a href="#" title="novedades" target="_self"><?=lang('menu_novedades')?></a>
 				<ul>
  				<?php foreach($novedades_menu as $novedad): ?>
          <li>
            <a href="#"><?=$novedad['titulo']?></a>
          </li>
          <?php endforeach; ?>
			  </ul>   
        </li>
 	<li class="bot_contacto"><a href="<?=base_url() . lang('uri_contacto')?>" title="<?=lang('menu_contacto')?>" target="_self"><?=lang('menu_contacto')?></a></li>
	</ul>
</div>