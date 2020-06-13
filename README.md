# yii2 infinite-scroll
yii2 widgets infinite-scroll，Infinite Scroll is a JavaScript plugin that automatically adds the next page, saving users from a full page load. 

useful

    <?php
        echo "Hello world!";
    ?>

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',//子视图
    'layout' => "{summary}\n <div class='grid are-images-unloaded'>
        <div class='grid__col-sizer'></div>
        <div class='grid__gutter-sizer'></div>{items}</div>\n<div class='pager'>{pager}</div>",
//    'itemOptions' => ['tag' => false],
    'pager' => [
        'class' => \yiidoc\infinitescroll\InfiniteScrollWidget::class,
        'contentSelector' => '.grid',
        'pluginOptions' => [
//            'path' => new \yii\web\JsExpression('aa'),
            'path' => new \yii\web\JsExpression('setPath'),
//            'path' => '/test/index?page={{#}}',
            //'append' => '.post',
            'append' => '.grid__item',
            'outlayer' => new \yii\web\JsExpression('msnry'),
            'status' => '.page-load-status',
//            'status' => '.loader-wheel',
            'history' => false,
            'debug' => true,
//            'loadOnScroll' => false,
//            'scrollThreshold' => false,
//            'button' => '.view-more-button',
//            'scrollThreshold'
        ],
        'clientEvents' => [
//            'load' => new \yii\web\JsExpression('function( response, path ) {
//                console.log(location.pathname)
//    console.log(infScrollIns.pageIndex);
//}'),
            'load' => 'function( response, path ) {
                console.log(location.pathname)
    console.log(infScrollIns.pageIndex);
}',
            'history' => new \yii\web\JsExpression('function() {
    console.log(520,location.pathname);
}'),
        ]
    ],
]);
