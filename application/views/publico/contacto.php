<? if($error != ""): ?>
<script type="text/javascript">
	alert('<?=$error?>');
</script>
<? endif ?>
<br />
<h2><?=lang('contacto_titulo')?></h2>
<form id="ContactForm" action="" method="post">
	<div>
		<div class="wrapper">
			<span><?=lang('contacto_nombre')?>:</span>
			<input type="text" class="input" name="nombre" id="nombre" value="<?=$nombre?>" />
		</div>
		<div  class="wrapper">
			<span><?=lang('contacto_email')?>:</span>
			<input type="text" class="input" name="email" id="email" value="<?=$email?>" />
		</div>
		<div  class="textarea_box">
			<span><?=lang('contacto_mensaje')?>:</span>
			<textarea name="mensaje" id="mensaje" cols="1" rows="1"><?=$mensaje?></textarea>
		</div>
		<div class="wrapper">
			<span>&nbsp;</span>
			<a href="#" class="button1" onClick="document.getElementById('ContactForm').reset()"><span></span><strong><?=lang('contacto_borrar')?></strong></a>
			<a href="#" class="button1" onClick="document.getElementById('ContactForm').submit()"><span></span><strong><?=lang('contacto_enviar')?></strong></a>
		</div>
	</div>
</form>