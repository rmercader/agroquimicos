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
        Servicios - información técnica
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">Editar</li>
  </ul>
  
  <div class="page-header">
    <h2>
      Editando Servicio
    </h2>
  </div>

  <?php
  //flash messages
  if($this->session->flashdata('flash_message')){
    if($this->session->flashdata('flash_message') == 'updated')
    {
      echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo 'El servicio fue editado correctamente.';
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

  echo form_open_multipart('admin/servicios/update/'.$this->uri->segment(4).'', $attributes);
  ?>
    <fieldset>
      <div class="control-group">
          <label for="inputError" class="control-label">Nombre</label>
          <div class="controls">
            <input type="text" id="nombre_esp" name="nombre_esp" value="<?php echo $servicio[0]['nombre_esp']; ?>" >
          </div>
      </div>

      <div class="control-group">
          <label for="inputError" class="control-label">Nombre (eng)</label>
          <div class="controls">
            <input type="text" id="nombre_eng" name="nombre_eng" value="<?php echo $servicio[0]['nombre_eng']; ?>" >
          </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Descripción</label>
        <div class="controls">
          <textarea id="descripcion_esp" name="descripcion_esp" style="margin: 0px;height: 150px;width: 400px;"><?=$servicio[0]['descripcion_esp'];?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Descripción (eng)</label>
        <div class="controls">
          <textarea id="descripcion_eng" name="descripcion_eng" style="margin: 0px;height: 150px;width: 400px;"><?=$servicio[0]['descripcion_eng'];?></textarea>
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Archivo PDF</label>
        <div class="controls">
          <input type="file" id="file_esp" name="file_esp" size="40">
        </div>
      </div>

      <div class="control-group">
          <div class="controls">
            <a href="<?php echo site_url().'uploads/servicios/' . $fichaEsp; ?>">Descargar</a>
          </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Archivo PDF (eng)</label>
        <div class="controls">
          <input type="file" id="file_eng" name="file_eng" size="40">
        </div>
      </div>

      <div class="control-group">
          <div class="controls">
            <a href="<?php echo site_url().'uploads/servicios/' . $fichaEng; ?>">Download</a>
          </div>
      </div>

      <div class="form-actions">
          <button class="btn btn-primary" type="submit">Salvar cambios</button>
          <button class="btn" type="reset">Cancelar</button>
       </div>
    </fieldset>

  <?php echo form_close(); ?>

</div>  