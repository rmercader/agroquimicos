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
        Categorías de Productos
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">Nueva</li>
  </ul>
  
  <div class="page-header">
    <h2>
      Creando Categoría de Productos
    </h2>
  </div>

  <?php
  //flash messages
  if(isset($flash_message)){
    if($flash_message == TRUE)
    {
      echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo 'La Categoría fue creada correctamente.';
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
  
  echo form_open_multipart('admin/categorias_productos/add', $attributes);
  ?>
    <fieldset>
      <div class="control-group">
        <label for="inputError" class="control-label">Nombre</label>
        <div class="controls">
          <input type="text" id="nombre_esp" name="nombre_esp" value="<?php echo set_value('nombre_esp'); ?>" >
          <!--<span class="help-inline">Woohoo!</span>-->
        </div>
      </div>
      <div class="control-group">
        <label for="inputError" class="control-label">Nombre (eng)</label>
        <div class="controls">
          <input type="text" id="nombre_eng" name="nombre_eng" value="<?php echo set_value('nombre_eng'); ?>" >
          <!--<span class="help-inline">Woohoo!</span>-->
        </div>
      </div>
      <div class="control-group">
        <label for="inputError" class="control-label">Archivo de imagen</label>
        <div class="controls">
          <input type="file" id="imagen" name="imagen" size="40">
        </div>
      </div>
      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Salvar</button>
        <button class="btn" type="reset">Cancelar</button>
      </div>
    </fieldset>

  <?php echo form_close(); ?>

</div>   