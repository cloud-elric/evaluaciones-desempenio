<?php

use yii\web\View;
$resultsJs = <<< JS
function (data, params) {
    
    params.page = params.page || 1;
    return {
        results: data.results,
        pagination: {
            more: (params.page * 10) < data.total_count
        }
    };
}
JS;

$formatJs = <<< 'JS'
var formatRepoEquipo = function (repo) {
    
    if (repo.loading) {
        return repo.text;
    }

    var markup =
        '<div class="row">' + 
            '<div class="col-md-8">' +
                '<b style="margin-left:5px">' + repo.txt_nombre + '</b>' + 
            '</div>' +
            
        '</div>';
    
    return '<div style="overflow:hidden;">' + markup + '</div>';
};

JS;
 
// Register the formatting script
$this->registerJs($formatJs, View::POS_HEAD);
 
?>