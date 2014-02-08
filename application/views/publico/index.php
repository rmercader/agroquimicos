<div class="pages clearfix">
	<div class="bienvenido">
		<h1>Bienvenidos a Proquimur</h1>
		<div class="ima-home"><img src="<?=base_url()?>images/ima-home.jpg"/></div>
		<div class="text-home">Desde el año 1981 nuestra empresa se dedica a la producción de productos químicos de alta calidad para uso agropecuario. Instalados en Uruguay y sirviendo a clientes en la región y el mundo, Proquimur apunta a la mayor calidad en sus productos y servicios.<br /><br />
	Conozca en este sitio nuestros productos y servicios, por favor, no dude en contactarnos por cualquier consulta o sugerencia.<br />
	Muchas gracias.</div>
	</div>
	<h2>Novedades de Proquimur</h2>

<?php foreach($novedades as $novedad): ?>
	<div class="fondo_noticias clearfix">
		<div class="tit_not_chicas"><?=$novedad['titulo']?></div>
		<img width="<?=$previewWidth?>" height="<?=$previewHeight?>" src="<?=base_url()?>uploads/novedades/<?=$novedad['id_novedad']?>.prv.jpg" />
		<div class="text_not_chicas"><?=$novedad['cabezal']?></div>
		<div class="leer_mas">
		<a href="<?=base_url()?>novedades/<?=$novedad['ficha']?>">más información</a></div>
	</div>
<?php endforeach; ?>

</div>