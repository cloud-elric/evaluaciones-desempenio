<?php
namespace app\components;
use yii\widgets\LinkSorter;
use yii\helpers\Html;

class CustomLinkSorter extends LinkSorter{

    public $options = ['class' => 'sorter dropdown-menu animation-scale-up animation-top-right animation-duration-250', "role"=>"menu"];
/**
     * Renders the sort links.
     * @return string the rendering result
     */
    protected function renderSortLinks()
    {
        $attributes = empty($this->attributes) ? array_keys($this->sort->attributes) : $this->attributes;
        $links = [];
        foreach ($attributes as $name) {
            $links[] = $this->sort->link($name, $this->linkOptions);
        }
        $container =  '<div class="dropdown page-user-sortlist">
        <a class="dropdown-toggle inline-block" data-toggle="dropdown" href="#" aria-expanded="false">Ordenar por<span class="caret"></span></a>
       '.Html::ul($links, array_merge($this->options, ['encode' => false], ['item' => function($item, $index) {
        return '<li role="presentation">'.$item.'</li>';
 }])).'
    </div>';
    
        return $container;
    }
}