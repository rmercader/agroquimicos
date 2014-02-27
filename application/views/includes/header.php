<!DOCTYPE html> 
<html lang="en-US">
<head>
	<title>Administración :: Proquimur</title>
	<meta charset="utf-8">
	<link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="<?=base_url()?>images/favicon.ico"  />
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/admin.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.numeric.js"></script>  	
	
</head>
<body>
	
	<script type="text/javascript">
		$(document).ready(function(){

		    $(".btn-danger").click(function(evt){
		      if(!confirm('¿Está seguro de querer eliminar el elemento seleccionado?')){
		        evt.stopPropagation();
		        evt.preventDefault();
		      }      
		    });

		  });
	</script>
	
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
	      <a class="brand">Proquimur Web</a>
	      <ul class="nav">
	      	<li <?php if($this->uri->segment(2) == 'novedades'){echo 'class="active"';}?>>
	        	<a href="<?php echo base_url(); ?>admin/novedades">Novedades</a>
	        </li>
	      	<li <?php if($this->uri->segment(2) == 'categorias_productos'){echo 'class="active"';}?>>
	        	<a href="<?php echo base_url(); ?>admin/categorias_productos">Categorías de Productos</a>
	        </li>
	        <li <?php if($this->uri->segment(2) == 'productos'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/productos">Productos</a>
	        </li>
	        <li <?php if($this->uri->segment(2) == 'servicios'){echo 'class="active"';}?>>
	          <a href="<?php echo base_url(); ?>admin/servicios">Servicios</a>
	        </li>
	        <li class="dropdown">
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sistema <b class="caret"></b></a>
	         	<ul class="dropdown-menu">
		            <li>
		            	<a href="<?php echo base_url(); ?>admin/mensajes">Mensajes de Contacto</a>
		            </li>
		            <li>
		            	<a href="<?php echo base_url(); ?>admin/logout">Salir</a>
		            </li>
	          	</ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</div>	
