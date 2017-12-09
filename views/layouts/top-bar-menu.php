<?php
use \yii\helpers\Url;
?>
<div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
    <div>
        <div>
        <ul class="site-menu ">
            <?php
            if (\Yii::$app->user->can('admin')) {
            ?>
                <li class="site-menu-category">Super admin</li>
                <li class="dropdown site-menu-item has-sub">
                    <a class="dropdown-toggle" href="javascript:void(0)" data-dropdown-toggle="false">
                        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">Usuarios call center</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub site-menu-normal-list">
                        <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/super-admin/index">
                            <span class="site-menu-title">Lista de usuarios</span>
                        </a>
                        </li>
                        <li class="site-menu-item">
                        <a class="animsition-link" href="../dashboard/v2.html">
                            <span class="site-menu-title">Roles</span>
                        </a>
                        </li>
                        <li class="site-menu-item">
                        <a class="animsition-link" href="../dashboard/ecommerce.html">
                            <span class="site-menu-title">Permisos</span>
                        </a>
                        </li>
                    </ul>
                </li>
            <?php    
            }
            ?>

            <?php 
            //if(\Yii::$app->user->can(Yii::$app->params ['roles'] ['ejecutivoTelcel'])){
            ?>
            <li class="site-menu-category">Call center</li>
            <!-- <li class="dropdown site-menu-item has-sub">
                <a class="dropdown-toggle" href="javascript:void(0)" data-dropdown-toggle="false">
                    <i class="site-menu-icon wb-calendar" aria-hidden="true"></i>
                    <span class="site-menu-title">Citas</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="site-menu-scroll-wrap is-list">
                        <div>
                            <div>
                                <ul class="site-menu-sub site-menu-normal-list">
                                    <li class="site-menu-item">
                                    <a class="animsition-link" href="<?=Url::base()?>/citas">
                                        <i class="site-menu-icon wb-list" aria-hidden="true"></i>
                                        <span class="site-menu-title">Listado de citas</span>
                                    </a>
                                    </li>
                                    
                                    <li class="site-menu-item">
                                    <a class="animsition-link" href="<?=Url::base()?>/citas/create">
                                        <i class="site-menu-icon wb-plus" aria-hidden="true"></i>
                                        <span class="site-menu-title">Agregar nueva cita</span>
                                    </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>   -->
        </ul>
       
        </div>
    </div>
    </div>
    
</div>
