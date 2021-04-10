<?php

  use app\assets\PluginAsset;

  PluginAsset::register($this)->add(['datatables']);
  if (!isset($table)):
    echo "DATA NOT FOUND!";
  else:
    $tableID = (isset($table['id'])?$table['id']:'');
    ?>
      <div class="card">
          <div class="card-header bg-cyan">
              <h4 class="card-title"><?= $table['title']; ?></h4>
            <?php
              if(isset($table['tools'])):
                ?>
                  <div class="card-tools">
                      <div class="input-group input-group-sm" style="width: 150px;">
                          <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                          <div class="input-group-append">
                              <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                          </div>
                      </div>
                  </div>
              <?php
              endif;
            ?>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
              <div id="<?=$tableID;?>_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                      <div class="col-sm-12 table-responsive">
                          <table id="<?=$tableID;?>" class="table table-hover table-striped" role="grid">
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
                                                  }else if($col){
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
                      </div>
                  </div>
                <?php
                  if(!isset($table['page']) || $table['page'] === false):

                  else:
                    $currentPage = intval($table['page']['current']);
                    $maxPage = intval($table['page']['total'])-1;
                    ?>
                      <div class="row">
                          <div class="col-sm-12 col-md-5">
                              <div class="dataTables_info" id="<?=$tableID;?>_info" role="status" aria-live="polite">Page <?=$currentPage+1;?> of
                                <?= $table['page']['total']; ?>
                              </div>
                          </div>
                          <div class="col-sm-12 col-md-7">
                              <div class="dataTables_paginate paging_simple_numbers" id="<?=$tableID;?>_paginate">
                                  <ul class="pagination">
                                      <li class="paginate_button page-item previous <?=$currentPage == 0?'disabled':'';?>" id="<?=$tableID;?>_previous">
                                          <a href="#" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                      </li>
                                    <?php

                                      if($maxPage < 6){
                                        $startPage = 0;
                                        $endPage = $maxPage;
                                      }else{
                                        $startPage = $currentPage > 2? $currentPage - 2: 0;
                                        $endPage = $currentPage < $maxPage - 2? $currentPage+2: $maxPage;
                                        $totalShown = $endPage - $startPage;
                                        if($totalShown < 4){
                                          if($endPage != $maxPage){
                                            $endPage = $endPage + 4 - $totalShown;
                                            if($endPage > $maxPage){
                                              $endPage = $maxPage;
                                            }
                                          }else if($startPage != 0){
                                            $startPage = $startPage - 4 + $totalShown;
                                            if($startPage < 0){
                                              $startPage = 0;
                                            }
                                          }
                                        }
                                      }
                                      for($i = $startPage; $i <= $endPage; $i++):
                                        ?>
                                          <li class="paginate_button page-item <?=$currentPage == $i?'active':'';?>">
                                              <a href="#" data-dt-idx="<?=$i;?>" tabindex="0" class="page-link"><?=($i+1);?></a>
                                          </li>
                                      <?php
                                      endfor;
                                    ?>
                                      <li class="paginate_button page-item next <?=$currentPage == $maxPage?'disabled':'';?>" id="<?=$tableID;?>_next">
                                          <a href="#" data-dt-idx="<?=$maxPage;?>" tabindex="0" class="page-link">Next</a>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  <?php
                  endif;
                ?>
              </div>
          </div>
          <!-- /.card-body -->
      </div>
  <?php
  endif;
?>