<div class="pages bk-int clearfix">
    <h2><?=lang('productos_titulo_general')?></h2>
    <div class="lateral">
        <h3><?=lang('productos_categoria_titulo')?></h3>
        <div class="rec-prod">
          <img src="<?=base_url()?>uploads/categorias-productos/<?=$idCategoria . CATEGORIA_PRODUCTO_IMAGE_PREVIEW_MARKER?>.jpg" width="{$catPrvW}" height="{$catPrvH}" />
          <div class="eti-prod"><?=$nombreCategoria?></div>
        </div>
    </div>

    <div class="centro">
    	<h4><?=lang('productos_titulo')?>:</h4>
    	
        <?php foreach($productos as $prod): ?>
        
        <div class="rec-det">
            <div class="rec-titulo"><?=$prod['nombre']?></div>
            <div class="imagensector">
                <img src="<?=base_url()?>uploads/productos/<?=$prod['id_producto'] . PRODUCTO_IMAGE_PREVIEW_MARKER?>.jpg" width="{$prvW}" height="{$prvH}" />
            </div>
            <div class="sector">
            	<div class="tit-detalles azul"><?=lang('productos_formulacion')?>:</div>
            	<div class="text-formulacion"><?=$prod['formulacion']?></div>
                <div class="tit-detalles azul"><?=lang('productos_principio_activo')?>:</div>
            	<div class="text-formulacion"><?=$prod['principio_activo']?></div>
                <div class="bot-mas">
                    <a href="#"><?=lang('label_mas_informacion')?></a>
                </div>
            </div>
        </div>

        <?php endforeach; ?>
    </div>

</div>