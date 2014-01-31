<script type="text/javascript">
  var site_url_admin = '<?=site_url("admin")?>';
</script>
<script type="text/javascript" src="<?=base_url();?>assets/js/obras.js"></script>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
    html>body #sortable li { height: 1.5em; line-height: 1.2em; }
    .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
</style>
<script>

  $(function() {
    
    $("#sortable").sortable({
      cursor: "move",
      opacity: 0.5,
      revert: true,
      placeholder: "ui-state-highlight"
    });

    $("#sortable").disableSelection();
  });

  function rescatarOrdenacion(){
    // Recupero los id en el orden que fueron seteados
    var sortedIDs = $( "#sortable" ).sortable( "toArray" );
    $("#ids_ordenados").val(JSON.stringify(sortedIDs));
  }

  $(document).ready(function(){

    $("#btn-cancelar").click(function(){
      if(confirm("Los cambios que haya hecho se perderán. ¿Continuar de todos modos?")){
        $("#sortable").sortable("cancel");
      }
      return false;
    });

  });

</script>
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
    <li class="active">
      Ordenación
    </li>
  </ul>
  
  <div class="page-header">
    <h2>
      Ordenación de novedades visibles en el sitio
    </h2>
  </div>

  <?php
  //flash messages
  if(isset($flash_message)){
    if($flash_message == TRUE)
    {
      echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo 'Las novedades fueron ordenadas correctamente.';
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
  $attributes = array('class' => 'form-horizontal', 'id' => '', 'onsubmit' => 'rescatarOrdenacion();');

  //form validation
  echo validation_errors();
  if(isset($error)){
    echo "Errores adicionales: $error";
  }
  
  echo form_open_multipart('admin/novedades/ordenar', $attributes);
  ?>

  <fieldset>

    <div class="control-group">Arrastrar y soltar para ordenar</div>

    <div class="control-group">
      <div class="controls" style="margin-left: 5px;">
        <ul id="sortable">
        <?php foreach($visibles as $row): ?>
          <li class="ui-state-default" id="<?=$row['id_novedad']?>">
            <?=$row['titulo_esp']?>
          </li>
        <?php endforeach ?>
        </ul>
      </div>
    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Salvar</button>
      <button class="btn" id="btn-cancelar">Cancelar</button>
    </div>

    <input type="hidden" name="ids_ordenados" id="ids_ordenados" />

  </fieldset>

  <?php echo form_close(); ?>

</div>