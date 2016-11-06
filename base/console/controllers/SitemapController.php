<?php
/**
 * SitemapController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\console\controllers;

/**
 * Class SitemapController
 * @package cookyii\console\controllers
 */
abstract class SitemapController extends \yii\console\Controller
{

    /**
     * @var string
     */
    public $defaultAction = 'generate';

    /**
     * @var string
     */
    public $filePath = '@app/web/sitemap.xml';

    /**
     * @var string
     */
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
