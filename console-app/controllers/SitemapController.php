<?php
/**
 * SitemapController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace console\controllers;

/**
 * Class SitemapController
 * @package console\controllers
 */
class SitemapController extends \cookyii\console\controllers\SitemapController
{

    public $defaultAction = 'index';

    public $filePath = '@runtime/sitemap.xml';

    protected $domain = 'https://sitename.ru';

    public function actionIndex()
    {
        echo 'Select application' . PHP_EOL;
    }

    public function actionFrontend()
    {
        $this->filePath = \Yii::getAlias('@frontend/web/sitemap.xml');

        $time = microtime(true);

        echo '    > Sitemap generating... ';

        $Sitemap = new \samdark\sitemap\Sitemap($this->filePath);

        $Sitemap->addItem($this->domain . '/page/about');
        $Sitemap->addItem($this->domain . '/page/privacy');
        $Sitemap->addItem($this->domain . '/page/terms');
        $Sitemap->addItem($this->domain . '/page/contacts');
        $Sitemap->addItem($this->domain . '/page/maintain');

        $Sitemap->write();

        echo 'done (time: ' . sprintf('%.3f', microtime(true) - $time) . 's).' . PHP_EOL;
    }

    /**
     * @inheritdoc
     */
    public function append($Sitemap)
    {
        $Sitemap->addItem($this->domain . '/page/about');
        $Sitemap->addItem($this->domain . '/page/privacy');
        $Sitemap->addItem($this->domain . '/page/terms');
        $Sitemap->addItem($this->domain . '/page/contacts');
        $Sitemap->addItem($this->domain . '/page/maintain');
    }
}