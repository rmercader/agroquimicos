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
    <li class="active">Editar</li>
  </ul>
  
  <div class="page-header">
    <h2>
      Editando Categoría de Productos
    </h2>
  </div>


  <?php
  //flash messages
  if($this->session->flashdata('flash_message')){
    if($this->session->flashdata('flash_message') == 'updated')
    {
      echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo 'La Categoría fue editada correctamente.';
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

  echo form_open_multipart('admin/categorias_productos/update/'.$this->uri->segment(4).'', $attributes);
  ?>
    <fieldset>
      <div class="control-group">
        <label for="inputError" class="control-label">Nombre</label>
        <div class="controls">
          <input type="text" id="nombre_esp" name="nombre_esp" value="<?php echo $categoria_producto[0]['nombre_esp']; ?>" >
          <!--<span class="help-inline">Woohoo!</span>-->
        </div>
      </div>
      <div class="control-group">
        <label for="inputError" class="control-label">Nombre (eng)</label>
        <div class="controls">
          <input type="text" id="nombre_eng" name="nombre_eng" value="<?php echo $categoria_producto[0]['nombre_eng']; ?>" >
          <!--<span class="help-inline">Woohoo!</span>-->
        </div>
      </div>

      <div class="control-group">
        <label for="inputError" class="control-label">Archivo de imagen</label>
        <div class="controls">
          <input type="file" id="imagen_esp" name="imagen_esp" size="40">
        </div>
      </div>

      <div class="control-group">
          <label for="inputError" class="control-label">Vista previa</label>
          <div class="controls">
            <img src="<?php echo site_url().'/uploads/categorias-productos/' . $categoria_producto[0]['id_categoria_producto'] . '-esp' . $previewMarker . '.jpg'; ?>" width="<?=$previewWidth?>" height="<?=$previewHeight?>" />
          </div>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Salvar cambios</button>
        <button class="btn" type="reset">Cancelar</button>
      </div>
    </fieldset>

  <?php echo form_close(); ?>

</div>