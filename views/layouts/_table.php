<?php

  use app\assets\PluginAsset;

  PluginAsset::register($this)->add(['datatables']);
  if (!isset($table)):
    echo "DATA NOT FOUND!";
  else:
    $tableID = (isset($table['id'])?$table['id']:'');
    ?>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= $table['title']; ?></h3>
        <div class="card-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div id="<?=$tableID;?>_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6"></div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table id="<?=$tableID;?>" class="table table-bordered table-hover dataTable dtr-inline" role="grid">
                <thead>
                <tr role="row">
                  <?php
                    foreach ($table['column'] as $key => $col):
                      ?>
                      <th tabindex="<?= $key; ?>" rowspan="1" colspan="1">
                        <?= is_array($col)?$col['label']:$col; ?>
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
                  foreach ($table['data'] as $key => $data):
                    ?>
                    <tr role="row" class="<?= $key % 2 == 0 ? 'odd' : 'even'; ?>">
                      <?php
                        foreach ($table['column'] as $col):
                          ?>
                          <td><?= is_array($col)?$col['display']($data):$data[$col]; ?></td>
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