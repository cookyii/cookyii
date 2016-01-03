<?php
/**
 * ApiController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Translation\backend\controllers;

use cookyii\modules\Translation;
use yii\helpers\VarDumper;

/**
 * Class ApiController
 * @package cookyii\modules\Translation\backend\controllers
 */
class ApiController extends \cookyii\api\Controller
{

    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => [Translation\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'phrases' => ['GET'],
            'save' => ['Post'],
        ];
    }

    /**
     * @return bool|mixed|string
     * @throws \yii\web\ServerErrorHttpException
     */
    protected function getConfig()
    {
        /** @var Translation\backend\Module $Module */
        $Module = \Yii::$app->getModule('translation');

        $config = \Yii::getAlias($Module->messagesConfig);
        $config = require $config;

        if (empty($config)) {
            throw new \yii\web\ServerErrorHttpException('Empty config');
        }

        return $config;
    }

    /**
     * @return array
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionPhrases()
    {
        $config = $this->getConfig();

        $format = $config['format'];
        $languages = $config['languages'];
        $messagePath = $config['messagePath'];

        $files = [];
        switch ($format) {
            case 'php':
                foreach ($languages as $lang) {
                    if (!isset($files[$lang])) {
                        $files[$lang] = [];
                    }

                    $files[$lang] = glob($messagePath . '/' . $lang . '/*.php');
                }
                break;
            case 'po':
                foreach ($languages as $lang) {
                    if (!isset($files[$lang])) {
                        $files[$lang] = [];
                    }

                    $files[$lang][] = $messagePath . '/' . $lang . '/messages.po';
                }
                break;
            case 'db':
                throw new \yii\web\ServerErrorHttpException('Unsupported db scheme');
                break;
        }

        if (empty($files)) {
            throw new \yii\web\ServerErrorHttpException('Empty files list');
        }

        $result = [];

        foreach ($files as $lang => $list) {
            foreach ($list as $file) {
                switch ($format) {
                    case 'php':
                        $category = str_replace('.php', '', basename($file));
                        $phrases = include $file;

                        if (!isset($result[$category])) {
                            $result[$category] = [];
                        }

                        foreach ($phrases as $orig => $res) {
                            if (!isset($result[$category][$orig])) {
                                $result[$category][$orig] = [];
                            }

                            $result[$category][$orig][$lang] = empty($res) ? null : $res;
                        }
                        break;
                    case 'po':

                        $phrases = (new \PoParser\Parser)
                            ->read($file);

                        foreach ($phrases as $orig => $data) {
                            $category = $data['msgctxt'];

                            if (!isset($result[$category])) {
                                $result[$category] = [];
                            }
                            if (!isset($result[$category][$orig])) {
                                $result[$category][$orig] = [];
                            }

                            $res = array_shift($data['msgstr']);
                            $result[$category][$orig][$lang] = empty($res) ? null : $res;
                        }
                        break;
                    case 'db':
                        throw new \yii\web\ServerErrorHttpException('Unsupported db scheme');
                        break;
                }
            }
        }

        return [
            'languages' => $languages,
            'items' => $result,
        ];
    }

    /**
     * @return bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionSave()
    {
        $result = false;

        $config = $this->getConfig();

        $category = Request()->post('category');
        $phrase = Request()->post('phrase');
        $variants = Request()->post('variants');

        $format = $config['format'];
        $messagePath = $config['messagePath'];

        switch ($format) {
            case 'php':
                foreach ($variants as $lang => $variant) {
                    $fileName = $messagePath . '/' . $lang . '/' . $category . '.php';
                    $phrases = include $fileName;
                    $phrases[$phrase] = (string)$variant;

                    $array = VarDumper::export($phrases);
                    $content = <<<EOD
<?php
/**
 * Message translations.
 *
 * This file is automatically generated by 'yii message' command.
 * It contains the localizable messages extracted from source code.
 * You may modify this file by translating the extracted messages.
 *
 * Each array element represents the translation (value) of a message (key).
 * If the value is empty, the message is considered as not translated.
 * Messages that no longer need translation will have their translations
 * enclosed between a pair of '@@' marks.
 *
 * Message string can be used with plural forms format. Check i18n section
 * of the guide for details.
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
return $array;

EOD;

                    file_put_contents($fileName, $content);
                }

                $result = true;

                break;
            case 'po':
                throw new \yii\web\ServerErrorHttpException('Unsupported po scheme');
                break;
            case 'db':
                throw new \yii\web\ServerErrorHttpException('Unsupported db scheme');
                break;
        }

        return $result;
    }
}