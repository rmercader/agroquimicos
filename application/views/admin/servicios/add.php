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
        Servicios - Información técnica
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">Nuevo</li>
  </ul>
  
  <div class="page-header">
    <h2>
      Creando Servicio
    </h2>
  </div>

  <?php
  //flash messages
  if(isset($flash_message)){
    if($flash_message == TRUE)
    {
      echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo 'El servicio fue creado correctamente.';
      echo '</div>';       
    }else{
      echo '<div class="alert alert-error">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<strong>Se ha detectado un problema!</strong> cambiar los datos y tratar de enviar nuevamente.';
      echo '</div>';          
    }
  }
  ?>
  
  <?php
  //form data
  $attributes = array('class' => 'form-horizontal', 'id' => '');

  //form validation
  echo validation_errors();
  
  echo form_open_multipart('admin/servicios/add', $attributes);
  ?>
    <fieldset>
      
      <div class="control-group">
        <label for="inputError" class="control-label">Nombre</label>
        <div class="controls">
          <input type="text" id="nombre_esp" name="nombre_esp" value="<?php echo set_value('nombre_esp'); ?>" >
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Nombre (eng)</label>
        <div class="controls">
          <input type="text" id="nombre_eng" name="nombre_eng" value="<?php echo set_value('nombre_eng'); ?>" >
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Descripción</label>
        <div class="controls">
          <textarea id="descripcion_esp" name="descripcion_esp" style="margin: 0px;height: 150px;width: 400px;"><?=set_value('descripcion_esp');?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Descripción (eng)</label>
        <div class="controls">
          <textarea id="descripcion_eng" name="descripcion_eng" style="margin: 0px;height: 150px;width: 400px;"><?=set_value('descripcion_eng');?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Archivo PDF</label>
        <div class="controls">
          <input type="file" id="file_esp" name="file_esp" size="40">
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Archivo PDF (eng)</label>
        <div class="controls">
          <input type="file" id="file_eng" name="file_eng" size="40">
        </div>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Salvar</button>
        <button class="btn" type="reset">Cancelar</button>
      </div>
    </fieldset>

  <?php echo form_close(); ?>

</div>     