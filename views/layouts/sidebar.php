<?php

  use app\helpers\AdminHelpers;
  use app\plugins\ActionEvent;
  use app\widgets\Menu;

?>
<aside class="main-sidebar elevation-4 sidebar-light-info">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$directoryAsset;?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$directoryAsset;?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=Yii::$app->user->identity->username;?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
              $GetMenu = AdminHelpers::GetMenu([-1,0], []);
              $listMenuEvents = \app\plugins\EventHelpers::GetEvents(ActionEvent::OnMenuLoader);
              foreach($listMenuEvents as $event){
                $menu = $event();
                $GetMenu = array_merge($GetMenu, $menu);
              }
              $BuildWidget = AdminHelpers::BuildMenuWidget($GetMenu);
              echo Menu::widget(['items'=>$BuildWidget]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>