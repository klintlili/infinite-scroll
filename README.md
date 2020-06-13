# yii2 infinite-scroll
yii2 widgets infinite-scroll，Infinite Scroll is a JavaScript plugin that automatically adds the next page, saving users from a full page load. 

useful

    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',//子视图
        'layout' => "{summary}\n<div class='grid are-images-unloaded'><div class='grid__col-sizer'></div><div class='grid__gutter-sizer'></div>{items}</div>\n<div class='pager'>{pager}</div>",
        'itemOptions' => ['tag' => false],
        'pager' => [
            'class' => \yiidoc\infinitescroll\InfiniteScrollWidget::class,
            'contentSelector' => '.grid',
            'pluginOptions' => [
                'path' => new \yii\web\JsExpression('setPath'),
                'append' => '.grid__item',
                'outlayer' => new \yii\web\JsExpression('msnry'),
                'status' => '.page-load-status',
                'history' => false,
                'debug' => true
            ],
            'clientEvents' => [
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

    ?>
    
    css
        body {
            font-family: sans-serif;
            line-height: 1.4;
            font-size: 18px;
            padding: 20px;
            /*max-width: 640px;*/
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

