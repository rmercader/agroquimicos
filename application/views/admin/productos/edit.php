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
        Productos
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">
      Editar
    </li>
  </ul>
  
  <div class="page-header">
    <h2>
      Editando Producto
    </h2>
  </div>


  <?php
  //flash messages
  if($this->session->flashdata('flash_message')){
    if($this->session->flashdata('flash_message') == 'updated')
    {
      echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo 'El producto fue editado correctamente.';
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
  echo form_open_multipart('admin/productos/update/'.$this->uri->segment(4).'', $attributes);

  ?>

  <fieldset>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Salvar</button>
      <button class="btn" type="reset">Cancelar</button>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Categoría</label>
      <div class="controls">
        <?=form_dropdown('id_categoria_producto', $opts_categorias, $producto[0]['id_categoria_producto'])?>
      </div>
    </div>
    
    <div class="control-group">
      <label for="inputError" class="control-label">Nombre</label>
      <div class="controls">
        <input type="text" id="nombre_esp" name="nombre_esp" value="<?php echo $producto[0]['nombre_esp']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Nombre (eng)</label>
      <div class="controls">
        <input type="text" id="nombre_eng" name="nombre_eng" value="<?php echo $producto[0]['nombre_eng']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Formulación</label>
      <div class="controls">
        <input type="text" id="formulacion_esp" name="formulacion_esp" value="<?php echo $producto[0]['formulacion_esp']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Formulación (eng)</label>
      <div class="controls">
        <input type="text" id="formulacion_eng" name="formulacion_eng" value="<?php echo $producto[0]['formulacion_eng']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Generalidades</label>
      <div class="controls">
        <textarea id="generalidades_esp" name="generalidades_esp" style="width: 400px;" rows="8"><?php echo $producto[0]['generalidades_esp']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Generalidades (eng)</label>
      <div class="controls">
        <textarea id="generalidades_eng" name="generalidades_eng" style="width:400px" rows="8"><?php echo $producto[0]['generalidades_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Principio activo</label>
      <div class="controls">
        <input type="text" id="principio_activo_esp" name="principio_activo_esp" value="<?php echo $producto[0]['principio_activo_esp']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Principio activo (eng)</label>
      <div class="controls">
        <input type="text" id="principio_activo_eng" name="principio_activo_eng" value="<?php echo $producto[0]['principio_activo_eng']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">% en peso</label>
      <div class="controls">
        <input type="text" id="porcentaje_en_peso" name="porcentaje_en_peso" style="width:40px" value="<?php echo $producto[0]['porcentaje_en_peso']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">g/L</label>
      <div class="controls">
        <input type="text" id="gramos_por_litro" name="gramos_por_litro" style="width:60px" value="<?php echo $producto[0]['gramos_por_litro']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Instrucciones</label>
      <div class="controls">
        <textarea id="instrucciones_esp" name="instrucciones_esp" style="width:400px" rows="8"><?php echo $producto[0]['instrucciones_esp']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Instrucciones (eng)</label>
      <div class="controls">
        <textarea id="instrucciones_eng" name="instrucciones_eng" style="width:400px" rows="8"><?php echo $producto[0]['instrucciones_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Momento de aplicación</label>
      <div class="controls">
        <textarea id="momento_aplicacion_esp" name="momento_aplicacion_esp" style="width:400px" rows="8"><?php echo $producto[0]['momento_aplicacion_esp']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Momento de aplicación (eng)</label>
      <div class="controls">
        <textarea id="momento_aplicacion_eng" name="momento_aplicacion_eng" style="width:400px" rows="8"><?php echo $producto[0]['momento_aplicacion_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Frecuencia de aplicación</label>
      <div class="controls">
        <textarea id="frecuencia_aplicacion_esp" name="frecuencia_aplicacion_esp" style="width:400px" rows="8"><?php echo $producto[0]['frecuencia_aplicacion_esp']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Frecuencia de aplicación (eng)</label>
      <div class="controls">
        <textarea id="frecuencia_aplicacion_eng" name="frecuencia_aplicacion_eng" style="width:400px" rows="8"><?php echo $producto[0]['frecuencia_aplicacion_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Compatibilidad y Fitotoxicidad</label>
      <div class="controls">
        <textarea id="comp_fito_esp" name="comp_fito_esp" style="width:400px" rows="8"><?php echo $producto[0]['comp_fito_esp']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Compatibilidad y Fitotoxicidad (eng)</label>
      <div class="controls">
        <textarea id="comp_fito_eng" name="comp_fito_eng" style="width:400px" rows="8"><?php echo $producto[0]['comp_fito_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Modo preparación</label>
      <div class="controls">
        <textarea id="modo_preparacion_esp" name="modo_preparacion_esp" style="width:400px" rows="8"><?php echo $producto[0]['modo_preparacion_esp']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Modo preparación (eng)</label>
      <div class="controls">
        <textarea id="modo_preparacion_eng" name="modo_preparacion_eng" style="width:400px" rows="8"><?php echo $producto[0]['modo_preparacion_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Clasificación Toxicológica</label>
      <div class="controls">
        <input type="text" id="clase_toxicologica_esp" name="clase_toxicologica_esp" value="<?php echo $producto[0]['clase_toxicologica_esp']; ?>" >
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Clasificación Toxicológica (eng)</label>
      <div class="controls">
        <input type="text" id="clase_toxicologica_eng" name="clase_toxicologica_eng"  value="<?php echo $producto[0]['clase_toxicologica_eng']; ?>" >
      </div>
    </div>

    <div class="control-group">
    <label for="inputError" class="control-label">Antídoto</label>
    <div class="controls">
      <textarea id="antidoto_esp" name="antidoto_esp" style="width:400px" rows="8"><?php echo $producto[0]['antidoto_esp']; ?></textarea>
    </div>
  </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Antídoto (eng)</label>
      <div class="controls">
        <textarea id="antidoto_eng" name="antidoto_eng" style="width:400px" rows="8"><?php echo $producto[0]['antidoto_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Primeros auxilios</label>
      <div class="controls">
        <textarea id="primeros_auxilios_esp" name="primeros_auxilios_esp" style="width:400px" rows="8"><?php echo $producto[0]['primeros_auxilios_esp']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Primeros auxilios (eng)</label>
      <div class="controls">
        <textarea id="primeros_auxilios_eng" name="primeros_auxilios_eng" style="width:400px" rows="8"><?php echo $producto[0]['primeros_auxilios_eng']; ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Archivo de imagen (JPG)</label>
      <div class="controls">
        <input type="file" id="imagen" name="imagen" size="40">
      </div>
    </div>

    <div class="control-group">
        <label for="inputError" class="control-label">Vista previa</label>
        <div class="controls">
          <img src="<?php echo site_url().'uploads/productos/' . $producto[0]['id_producto'] . $previewMarker . '.jpg'; ?>" width="<?=$previewWidth?>" height="<?=$previewHeight?>" />
        </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Ficha de seguridad (PDF)</label>
      <div class="controls">
        <input type="file" id="ficha_seguridad_esp" name="ficha_seguridad_esp" size="40">
        &nbsp;
        <a href="<?php echo site_url().'uploads/productos/' . $producto[0]['id_producto'] . '-esp.pdf'; ?>">Descargar ficha</a>
      </div>
    </div>

    <div class="control-group">
      <label for="inputError" class="control-label">Ficha de seguridad (eng) (PDF)</label>
      <div class="controls">
        <input type="file" id="ficha_seguridad_eng" name="ficha_seguridad_eng" size="40">
        &nbsp;
        <a href="<?php echo site_url().'uploads/productos/' . $producto[0]['id_producto'] . '-eng.pdf'; ?>">Descargar ficha</a>
      </div>
    </div>
    
    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Salvar</button>
      <button class="btn" type="reset">Cancelar</button>
    </div>
  </fieldset>

  <?php echo form_close(); ?>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/productos.js"></script>