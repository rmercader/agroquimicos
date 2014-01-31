<script type="text/javascript">  
  
</script>

<div class="container top">

  <ul class="breadcrumb">
    <li>
      <a href="<?php echo site_url("admin"); ?>">
        <?php echo ucfirst($this->uri->segment(1));?>
      </a> 
      <span class="divider">/</span>
    </li>
    <li class="active">
      Novedades
    </li>
  </ul>

  <div class="page-header users-header">
    <h2>
      Novedades
      <a  href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success" style="margin-left: 5px;">Agregar nueva</a>
      <a  href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/ordenar" class="btn btn-info">Ordenar visibles</a>
    </h2>
  </div>
  
  <div class="row">
    <div class="span12 columns">
      <div class="well">
       
        <?php
       
        $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
       
        //save the columns names in a array that we will use as filter         
        $options_novedades = array('id_novedad' => 'Id', 'titulo_esp' => 'Título', 'visible' => 'Visible');

        echo form_open('admin/novedades', $attributes);
 
          echo form_label('Buscar:', 'search_string');
          echo form_input('search_string', $search_string_selected);

          echo form_label('Ordenar por:', 'order');
          echo form_dropdown('order', $options_novedades, $order, 'class="span2"');
          echo "&nbsp;";
          $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Ir', 'style' => 'margin-left:5px;');

          $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
          echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

          echo form_submit($data_submit);

        echo form_close();
        ?>

      </div>

      <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th class="header">#</th>
            <th class="yellow header headerSortDown">Título</th>
            <th class="yellow header headerSortDown">Visible</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($novedades as $row)
          {
            echo '<tr>';
            echo '<td>'.$row['id_novedad'].'</td>';
            echo '<td>'.$row['titulo_esp'].'</td>';
            echo '<td>'.($row['visible'] ? 'Si' : 'No').'</td>';
            echo '<td style="width:' . $thumbnailWidth . 'px;">';
            ?>
            <img src="<?php echo site_url().'uploads/novedades/' . $row['id_novedad'] . '-esp' . $thumbMarker . '.jpg'; ?>" style="width: <?=$thumbnailWidth?>px; height: <?=$thumbnailHeight?>px" />
            <?
            echo '</td>';
            echo '<td class="crud-actions">
              <a href="'.site_url("admin").'/novedades/update/'.$row['id_novedad'].'" class="btn btn-info">Ver & editar</a>  
              <a href="'.site_url("admin").'/novedades/delete/'.$row['id_novedad'].'" class="btn btn-danger">Eliminar</a>
            </td>';
            echo '</tr>';
          }
          ?>      
        </tbody>
      </table>

      <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

  </div>
</div>