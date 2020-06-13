<?php

namespace klintlili\infinitescroll;

use yii\web\AssetBundle;

class InfiniteScrollAsset extends AssetBundle
{
    public $sourcePath = '@bower/infinite-scroll';
    public $js = [
        'dist/infinite-scroll.pkgd.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}