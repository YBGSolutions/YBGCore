<?php

  use app\assets\PluginAsset;

  PluginAsset::register($this)->add(['datatables']);
  if (!isset($table)):
    echo "DATA NOT FOUND!";
  else:
    $tableID = (isset($table['id'])?$table['id']:'');
    ?>
    <table id="<?=$tableID;?>" class="table table-hover table-striped table-responsive-lg" role="grid">
      <thead>
      <tr role="row">
        <?php
          foreach ($table['column'] as $key => $col):
            ?>
            <th tabindex="<?= $key; ?>" rowspan="1" colspan="1">
              <?php
                if(is_array($col)){
                  if(count($col) == 1){
                    $keyArray = array_keys($col);
                    echo $keyArray[0];
                  }else if(isset($col['label'])){
                    echo $col['label'];
                  }else{
                    echo "Unknown";
                  }
                }else{
                  echo $col;
                }
              ?>
            </th>
          <?php
          endforeach;
          if (isset($table['button'])) {
            ?>
            <th tabindex="<?= count($table['column']); ?>" rowspan="1" colspan="1"></th>
            <?php
          }
        ?>
      </tr>
      </thead>
      <tbody>
      <?php
        if(count($table['data'])> 0):
          foreach ($table['data'] as $key => $data):
            ?>
            <tr role="row">
              <?php
                foreach ($table['column'] as $col):
                  ?>
                  <td><?php
                      if(is_array($col)){
                        if(count($col) == 1){
                          $keyArray = array_keys($col);
                          $valueArray = $col[$keyArray[0]];
                          if(is_string($valueArray)){
                            if(isset($data[$valueArray])){
                              echo $data[$valueArray];
                            }else{
                              if($valueArray == "index")
                                echo $key+1;
                              else
                                echo $valueArray;
                            }
                          }else if(is_callable($valueArray)){
                            echo $valueArray($data);
                          }
                        }else if(isset($col['display']) && is_callable($col['display'])){
                          echo $col['display']($data);
                        }else{
                          echo "Unknown";
                        }
                      }else if(isset($data[$col])){
                        echo $data[$col];
                      }else{
                        if($col == "index")
                          echo $key+1;
                        else
                            echo $col;
                      }?></td>
                <?php
                endforeach;
                if (isset($table['button'])) {
                  echo '<th class="sorting_asc" tabindex="' . count($table['column']) . '" rowspan="1" colspan="1">';
                  foreach ($table['button'] as $button):
                    ?>
                    <?= $button($data); ?>
                  <?php
                  endforeach;
                  echo '</th>';
                }
              ?>
            </tr>
          <?php
          endforeach;
        else:
          ?>
          <tr>
            <td colspan="<?=(isset($table['button']))?count($table['column'])+1:count($table['column']);?>" style="text-align: center;">NO DATA</td>
          </tr>
        <?php
        endif;
      ?>
      </tbody>
    </table>
  <?php
  endif;
?>