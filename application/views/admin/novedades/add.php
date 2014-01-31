<div class="container top">
  <ul class="breadcrumb">
    <li>
      <a href="<?php echo site_url("admin"); ?>">
        <?php echo ucfirst($this->uri->segment(1));?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li>
      <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
        Novedades
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">Nueva</li>
  </ul>
  
  <div class="page-header">
    <h2>
      Creando Novedad
    </h2>
  </div>

  <?php
  //flash messages
  if(isset($flash_message)){
    if($flash_message == TRUE)
    {
      echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo 'La Novedad fue creada correctamente.';
      echo '</div>';       
    }else{
      echo '<div class="alert alert-error">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<strong>Se ha detectado un problema!</strong> cambiar los datos y tratar de enviar nuevamente.';
        if(!empty($data["error"])){
          echo $data["error"];
        }
      echo '</div>';          
    }
  }
  ?>
  
  <?php
  //form data
  $attributes = array('class' => 'form-horizontal', 'id' => '');

  //form validation
  echo validation_errors();
  
  echo form_open_multipart('admin/novedades/add', $attributes);
  ?>
    <fieldset>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Salvar</button>
        <button class="btn" type="reset">Cancelar</button>
      </div>
      
      <div class="control-group">
        <label for="inputError" class="control-label">Título</label>
        <div class="controls">
          <input type="text" id="titulo_esp" name="titulo_esp" value="<?php echo set_value('titulo_esp'); ?>" >
          
        </div>
      </div>
      
      <div class="control-group">
        <label for="inputError" class="control-label">Título (eng)</label>
        <div class="controls">
          <input type="text" id="titulo_eng" name="titulo_eng" value="<?php echo set_value('titulo_eng'); ?>" >
          
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Visible</label>
        <div class="controls">
          <input type="checkbox" id="visible" name="visible" value="1" <?php echo set_checkbox('visible', '1', true); ?> />
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Cabezal</label>
        <div class="controls">
          <textarea id="cabezal_esp" name="cabezal_esp" style="margin: 0px;height: 150px;width: 400px;"><?php echo set_value('cabezal_esp'); ?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Cabezal (eng)</label>
        <div class="controls">
          <textarea id="cabezal_eng" name="cabezal_eng" style="margin: 0px;height: 150px;width: 400px;"><?php echo set_value('cabezal_eng'); ?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Texto</label>
        <div class="controls">
          <textarea id="texto_esp" name="texto_esp" style="margin: 0px;height: 200px;width: 400px;"><?php echo set_value('texto_esp'); ?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Texto (eng)</label>
        <div class="controls">
          <textarea id="texto_eng" name="texto_eng" style="margin: 0px;height: 200px;width: 400px;"><?php echo set_value('texto_eng'); ?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Archivo de imagen</label>
        <div class="controls">
          <input type="file" id="imagen_esp" name="imagen_esp" size="40">
        </div>
      </div>
      
      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Salvar</button>
        <button class="btn" type="reset">Cancelar</button>
      </div>
    </fieldset>

  <?php echo form_close(); ?>

</div>