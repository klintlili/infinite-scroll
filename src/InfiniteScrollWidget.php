<?php

namespace klintlili\infinitescroll;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget;

class InfiniteScrollWidget extends Widget
{
    public $loadButtonLabel = 'Load more...';
    public $loadButtonOptions = ['class' => 'load hidden'];
    public $contentSelector;
    public $pluginOptions = [];
    public $clientEvents = [];

    /**
     * @var bool whether to register link tags in the HTML header for prev, next, first and last page.
     * Defaults to `false` to avoid conflicts when multiple pagers are used on one page.
     * @see http://www.w3.org/TR/html401/struct/links.html#h-12.1.2
     * @see registerLinkTags()
     */
    public $registerLinkTags = false;

    private $_assetBundle;

    public function init()
    {
        parent::init();
        $this->getAssetBundle();
    }

    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageButtons();
        $this->registerJs();
    }

    protected function registerLinkTags()
    {
        $view = $this->getView();
        foreach ($this->pagination->getLinks() as $rel => $href) {
            $view->registerLinkTag(['rel' => $rel, 'href' => $href], $rel);
        }
    }

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $currentPage = $this->pagination->getPage();

        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }

        $linkOptions = $this->loadButtonOptions;
        $linkOptions['data-page'] = $page;
        $linkOptions['id'] = $this->id;
        $button = Html::a($this->loadButtonLabel, $this->pagination->createUrl($page), $linkOptions);

        return $button;
    }

    /**
     * @return InfiniteScrollAsset
     */
    public function getAssetBundle()
    {
        if(!$this->_assetBundle){
            $this->_assetBundle = InfiniteScrollAsset::register($this->getView());
        }
        return $this->_assetBundle;
    }

    protected function registerJs()
    {
        if(!isset($this->pluginOptions['path'])){
            $this->pluginOptions['path'] = "#{$this->id}";
        }
        $options = Json::encode($this->pluginOptions);
        $js = <<<JS
var elem = document.querySelector('{$this->contentSelector}');
var infScroll = new InfiniteScroll( elem, {$options})
var infScrollIns = InfiniteScroll.data( elem );
console.log(infScrollIns.pageIndex);
JS;
        $this->view->registerJs($js);
        if(!empty($this->clientEvents)){
            $result = [];
            foreach ($this->clientEvents as $key => $clientEvents){
                $js = <<<JS
infScroll.on( '{$key}', $clientEvents);
JS;
                $result[] = $js;
            }
        }
        $result = implode(PHP_EOL,$result);
        $this->view->registerJs($result);
    }
}