<?php
use \yii\helpers\Url;
?>
<div class="site-menubar">
    <div class="site-menubar-body">
    <div>
        <div>
        <ul class="site-menu">
            <?php
            if (\Yii::$app->user->can('admin')) {
            ?>
                <li class="site-menu-category">Super admin</li>
                <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">Usuarios</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
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
            if(\Yii::$app->user->can(Yii::$app->params ['roles'] ['ejecutivoTelcel'])){
            ?>
            <li class="site-menu-category">Call center</li>
            <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon wb-calendar" aria-hidden="true"></i>
                    <span class="site-menu-title">Citas</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                    <li class="site-menu-item">
                    <a class="animsition-link" href="<?=Url::base()?>/citas">
                        <span class="site-menu-title">Listado de citas</span>
                    </a>
                    </li>
                    
                    <li class="site-menu-item">
                    <a class="animsition-link" href="<?=Url::base()?>/citas/create">
                        <span class="site-menu-title">Agregar nueva cita</span>
                    </a>
                    </li>
                </ul>
            </li>  
            <?php
            }
            
            if(\Yii::$app->user->can(Yii::$app->params ['roles'] ['supervisorTelcel'])){?>
            <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon wb-users" aria-hidden="true"></i>
                    <span class="site-menu-title">Usuarios</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                    <li class="site-menu-item">
                    <a class="animsition-link" href="<?=Url::base()?>/usuarios/usuarios-call-center">
                        <span class="site-menu-title">Listado de usuarios</span>
                    </a>
                    </li>
                    
                    <li class="site-menu-item">
                    <a class="animsition-link" href="<?=Url::base()?>/usuarios/create-usuario-call-center">
                        <span class="site-menu-title">Agregar nuevo usuario</span>
                    </a>
                    </li>
                </ul>
            </li>
            <?php
            }
            ?>
        </ul>
       
        </div>
    </div>
    </div>
    
</div>
