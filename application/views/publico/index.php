<div class="pages clearfix">
	<div class="bienvenido">
		<h1><?=lang('label_bienvenidos')?></h1>
		<div class="ima-home"><img src="<?=base_url()?>images/ima-home.jpg"/></div>
		<div class="text-home"><?=lang('static_bienvenidos');?></div>
	</div>
	<h2><?=lang('label_novedades')?></h2>

<?php foreach($novedades as $novedad): ?>
	<div class="fondo_noticias clearfix">
		<div class="tit_not_chicas"><?=$novedad['titulo']?></div>
		<img width="<?=$previewWidth?>" height="<?=$previewHeight?>" src="<?=base_url()?>uploads/novedades/<?=$novedad['id_novedad']?>.prv.jpg" />
		<div class="text_not_chicas"><?=$novedad['cabezal']?></div>
		<div class="leer_mas">
		<a href="<?=base_url()?>novedades/<?=$novedad['ficha']?>"><?=lang('label_mas_informacion')?></a></div>
	</div>
<?php endforeach; ?>

</div>