<div class="pages clearfix">
  <h2><?=lang('productos_titulo_general')?></h2>

  <?php foreach($categorias as $row): ?>
  <div class="rec-prod">
    <a href="<?=base_url() . $idioma . '/' . lang('uri_categorias') . '/' . $row['ficha']?>"> 
      <img src="<?=base_url()?>uploads/categorias-productos/<?=$row['id_categoria_producto'] . CATEGORIA_PRODUCTO_IMAGE_PREVIEW_MARKER?>.jpg" width="{$prvW}" height="{$prvH}" />
      <div class="eti-prod"><?=$row['nombre']?></div>
    </a>
  </div>
  <?php endforeach; ?>

</div>