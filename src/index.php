<?php
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = '图片集合';
$this->params['breadcrumbs'][] = $this->title;
//masonry
$this->registerJsFile("@web/js/masonry.pkgd.min.js", ["depends" => ["backend\\assets\\AppAsset"]]);
?>
    <style type="text/css">
        body {
            font-family: sans-serif;
            line-height: 1.4;
            font-size: 18px;
            padding: 20px;
            margin: 0 auto;
        }

        .grid {
            max-width: 1200px;
        }

        /* reveal grid after images loaded */
        .grid.are-images-unloaded {
            opacity: 0;
        }

        .grid__item,
        .grid__col-sizer {
            width: 32%;
        }

        .grid__gutter-sizer { width: 2%; }

        /* hide by default */
        .grid.are-images-unloaded .image-grid__item {
            opacity: 0;
        }

        .grid__item {
            margin-bottom: 20px;
            float: left;
        }

        .grid__item--height1 { height: 140px; background: #EA0; }
        .grid__item--height2 { height: 220px; background: #C25; }
        .grid__item--height3 { height: 300px; background: #19F; }

        .grid__item--width2 { width: 66%; }

        .grid__item img {
            display: block;
            max-width: 100%;
        }


        .page-load-status {
            display: none; /* hidden by default */
            padding-top: 20px;
            border-top: 1px solid #DDD;
            text-align: center;
            color: #777;
        }
        .loader-ellips {
            font-size: 20px; /* change size here */
            position: relative;
            width: 4em;
            height: 1em;
            margin: 10px auto;
        }

        .loader-ellips__dot {
            display: block;
            width: 1em;
            height: 1em;
            border-radius: 0.5em;
            background: #555; /* change color here */
            position: absolute;
            animation-duration: 0.5s;
            animation-timing-function: ease;
            animation-iteration-count: infinite;
        }

        .loader-ellips__dot:nth-child(1),
        .loader-ellips__dot:nth-child(2) {
            left: 0;
        }
        .loader-ellips__dot:nth-child(3) { left: 1.5em; }
        .loader-ellips__dot:nth-child(4) { left: 3em; }

        @keyframes reveal {
            from { transform: scale(0.001); }
            to { transform: scale(1); }
        }

        @keyframes slide {
            to { transform: translateX(1.5em) }
        }

        .loader-ellips__dot:nth-child(1) {
            animation-name: reveal;
        }

        .loader-ellips__dot:nth-child(2),
        .loader-ellips__dot:nth-child(3) {
            animation-name: slide;
        }

        .loader-ellips__dot:nth-child(4) {
            animation-name: reveal;
            animation-direction: reverse;
        }

        button{
            font-size: 20px;
            padding:  10px;
        }
        /* loader ellips in separate pen CSS */

        .loader-wheel {
            font-size: 64px; /* change size here */
            position: relative;
            height: 1em;
            width: 1em;
            padding-left: 0.45em;
            overflow: hidden;
            margin: 0 auto;
            animation: loader-wheel-rotate 0.5s steps(12) infinite;
        }

        .loader-wheel i {
            display: block;
            position: absolute;
            height: 0.3em;
            width: 0.1em;
            border-radius: 0.05em;
            background: #333; /* change color here */
            opacity: 0.8;
            transform: rotate(-30deg);
            transform-origin: center 0.5em;
        }

        @keyframes loader-wheel-rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

    </style>
    <h1>图片集合</h1>

    <h1>Masonry - imagesLoaded progress</h1>


    <p>
        <button class="button view-more-button">View more</button>
    </p>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',//子视图
    'layout' => "{summary}\n <div class='grid are-images-unloaded'><div class='grid__col-sizer'></div><div class='grid__gutter-sizer'></div>{items}</div>\n<div class='pager'>{pager}</div>",
    'itemOptions' => ['tag' => false],
    'pager' => [
        'class' => \yiidoc\infinitescroll\InfiniteScrollWidget::class,
        'contentSelector' => '.grid',
        'pluginOptions' => [
            'path' => new \yii\web\JsExpression('setPath'),
            //'path' => '/test/index?page={{#}}',
            //'append' => '.post',
            'append' => '.grid__item',
            'outlayer' => new \yii\web\JsExpression('msnry'),
            'status' => '.page-load-status',
            //'status' => '.loader-wheel',
            'history' => false,
            'debug' => true,
            //'loadOnScroll' => false,
            //'scrollThreshold' => false,
            //'button' => '.view-more-button',
        ],
        'clientEvents' => [
            'load' => 'function( response, path ) {
                console.log(location.pathname, infScrollIns.pageIndex);
            }',
            'history' => new \yii\web\JsExpression('function() {
                console.log('history',location.pathname);
            }'),
        ]
    ],
]);
$pageCount = $dataProvider->pagination->pageCount;
$currenPage = $dataProvider->pagination->getPage();
//var_dump($currenPage,$pageCount);die;
?>
    <!---->
    <!--<p>-->
    <!--    <button class="button view-more-button">View more</button>-->
    <!--</p>-->
    <!--    ellips__dot-->
    <!--<div class="page-load-status">-->
    <!--    <div class="loader-ellips infinite-scroll-request">-->
    <!--        <span class="loader-ellips__dot"></span>-->
    <!--        <span class="loader-ellips__dot"></span>-->
    <!--        <span class="loader-ellips__dot"></span>-->
    <!--        <span class="loader-ellips__dot"></span>-->
    <!--    </div>-->
    <!--    <p class="infinite-scroll-last">End of content</p>-->
    <!--    <p class="infinite-scroll-error">No more pages to load</p>-->
    <!--</div>-->

    <!--    wheel-->
    <div class="page-load-status">
        <div class="loader-wheel infinite-scroll-request">
            <i><i><i><i><i><i><i><i><i><i><i><i>
                                                        </i></i></i></i></i></i></i></i></i></i></i></i>
        </div>
        <p class="infinite-scroll-last">End of content</p>
        <p class="infinite-scroll-error">No more pages to load</p>
    </div>

<?php
$customFilter = <<<EOF
function setPath() {
    var currentPage = ($currenPage+1);    
    var next = currentPage+this.pageIndex;
    if(next <= $pageCount){
        return '/test/index2?page='+ next +'&per-page=15';
    }
}
EOF;
$this->registerJs("
//var elem = document.querySelector('.grid');
//var infScroll = new InfiniteScroll( elem, {\"path\":'/test/index?page={{#}}',\"append\":\".grid__item\",\"outlayer\":msnry,\"status\":\".page-load-status\",\"debug\":true});
//var infScrollIns = InfiniteScroll.data( elem )
//console.log(infScrollIns.pageIndex);
", \yii\web\View::POS_END);
$this->registerJs($customFilter, \yii\web\View::POS_END);

$this->registerJS('
//infScroll.on( \'load\', function( response, path ) {
//console.log(666, infScrollIns.pageIndex );
//});

//-------------------------------------//

var grid = document.querySelector(\'.grid\');

var msnry = new Masonry( grid, {
  itemSelector: \'none\', // select none at first
  columnWidth: \'.grid__col-sizer\',
  gutter: \'.grid__gutter-sizer\',
  percentPosition: true,
  stagger: 30,
  // nicer reveal transition
  visibleStyle: { transform: \'translateY(0)\', opacity: 1 },
  hiddenStyle: { transform: \'translateY(100px)\', opacity: 0 },
});


// initial items reveal
imagesLoaded( grid, function() {
  grid.classList.remove(\'are-images-unloaded\');
  msnry.options.itemSelector = \'.grid__item\';
  var items = grid.querySelectorAll(\'.grid__item\');
  msnry.appended( items );
});

//-------------------------------------//
', \yii\web\View::POS_END);?>