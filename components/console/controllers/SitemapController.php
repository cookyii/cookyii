<?php
/**
 * SitemapController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\console\controllers;

/**
 * Class SitemapController
 * @package components\console\controllers
 */
abstract class SitemapController extends \yii\console\Controller
{

    public $defaultAction = 'generate';

    public $filePath = '@app/web/sitemap.xml';

    protected $domain = 'https://sitename.ru';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $alias = $this->filePath;
        $filePath = $this->filePath = \Yii::getAlias($alias);

        if (empty($filePath)) {
            throw new \yii\base\InvalidConfigException(sprintf('Alias `%s` not exists', $alias));
        }

        if (!file_exists($filePath) && !is_writable(dirname($filePath))) {
            throw new \yii\base\Exception(sprintf('Directory `%s` is not writable', dirname($filePath)));
        }
    }

    /**
     * @param \samdark\sitemap\Sitemap $Sitemap
     */
    abstract public function append($Sitemap);

    /**
     * Action generate
     */
    public function actionGenerate()
    {
        $time = microtime(true);

        echo '    > Sitemap generating... ';

        $Sitemap = new \samdark\sitemap\Sitemap($this->filePath);

        $this->append($Sitemap);

        $Sitemap->write();

        echo 'done (time: ' . sprintf('%.3f', microtime(true) - $time) . 's).' . PHP_EOL;
    }
}