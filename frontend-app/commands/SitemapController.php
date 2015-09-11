<?php
/**
 * SitemapController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace frontend\commands;

/**
 * Class SitemapController
 * @package frontend\commands
 */
class SitemapController extends \cookyii\console\controllers\SitemapController
{

    protected $domain = 'https://sitename.ru';

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