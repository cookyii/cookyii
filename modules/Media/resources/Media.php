<?php
/**
 * Media.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\resources;

use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

/**
 * Class Media
 * @package cookyii\modules\Media\resources
 *
 * @property integer $id
 * @property string $mime
 * @property integer $size
 * @property string $name
 * @property string $origin_name
 * @property string $sha1
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Media extends \yii\db\ActiveRecord
{

    /** @var string */
    public static $mediaModule = 'media';

    /** @var string */
    public $path;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::className(),
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->events();
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['created_at_format'] = function (Media $Model) {
            return Formatter()->asDatetime($Model->created_at);
        };

        $fields['updated_at_format'] = function (Media $Model) {
            return Formatter()->asDatetime($Model->updated_at);
        };

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['mime', 'name', 'origin_name', 'sha1'], 'string'],
            [['size', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],

            /** semantic validators */
            [['mime', 'name', 'origin_name', 'sha1'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getWebPath();
    }

    /**
     * @param bool $recalculate
     * @return integer
     */
    public function getSize($recalculate = false)
    {
        return true === $recalculate
            ? filesize($this->getAbsolutePath())
            : $this->size;
    }

    /**
     * @param bool $recalculate
     * @return string
     * @throws \yii\base\InvalidConfigException.
     */
    public function getMime($recalculate = false)
    {
        return true === $recalculate
            ? FileHelper::getMimeType($this->getAbsolutePath())
            : $this->mime;
    }

    /**
     * @param bool $recalculate
     * @return string
     */
    public function getSha1($recalculate = false)
    {
        return true === $recalculate
            ? sha1_file($this->getAbsolutePath())
            : $this->sha1;
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        $upload_path = static::getMediaModule()->uploadWebPath;

        $p1 = mb_substr($this->name, 0, 2, 'utf-8');
        $p2 = mb_substr($this->name, 2, 2, 'utf-8');

        return sprintf('%s/%s/%s/%s', $upload_path, $p1, $p2, $this->name);
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        $upload_path = static::getMediaModule()->uploadPath;

        $p1 = StringHelper::byteSubstr($this->name, 0, 2);
        $p2 = StringHelper::byteSubstr($this->name, 2, 2);

        return $upload_path . DIRECTORY_SEPARATOR . $p1 . DIRECTORY_SEPARATOR . $p2 . DIRECTORY_SEPARATOR . $this->name;
    }

    /**
     * @param \cookyii\modules\Media\media\ResourceInterface $Resource
     * @return static
     * @throws \Exception
     */
    public static function push($Resource)
    {
        $id = basename($Resource->getTemp());

        \Yii::beginProfile(sprintf('pushing file `%s`', $id), __METHOD__);

        $NewModel = new static();
        $NewModel->path = $Resource->getTemp();

        $Model = static::find()
            ->bySha1($Resource->getSha1())
            ->one();

        if ($Model instanceof static) {
            $NewModel = $Model;
        } else {
            $result = $Resource->moveToUpload();
            if (false !== $result) {
                $NewModel->name = basename($result);
                $NewModel->origin_name = $Resource->getName();
                $NewModel->path = $result;
                $NewModel->insert();
            } else {
                throw new \RuntimeException(\Yii::t('cookyii.media', 'Failed to bring the resource directory of uploaded files.'));
            }
        }

        \Yii::endProfile('pushing file `' . $id . '`', __METHOD__);

        return $NewModel;
    }

    /**
     * @return static
     */
    public static function getPlaceholder()
    {
        $image = \Yii::getAlias(static::getMediaModule()->placeholderAlias);

        /** @var \cookyii\modules\Media\media\InternalResource $Resource */
        $Resource = \Yii::createObject(
            \cookyii\modules\Media\media\InternalResource::className(), [
                ['source' => $image]
            ]
        );

        return static::push($Resource);
    }

    /**
     * Manipulation with media image
     * For example,
     *
     * ~~~
     * $Media = Media::find();
     * $src = $Media->image()->thumbnail(150, 150)->frame(5)->export();
     *
     * echo Html::img($src);
     * ~~~
     *
     * @return \cookyii\modules\Media\ImageWrapper
     * @throws \Exception
     */
    public function image()
    {
        \Yii::beginProfile(sprintf('manipulating with file `%s`', $this->id), 'Media\Manipulation');

        $result = null;
        if ($this->isImage()) {
            $result = \Yii::createObject([
                'class' => \cookyii\modules\Media\ImageWrapper::className(),
                'Media' => $this,
            ]);
        } else {
            $result = \Yii::createObject([
                'class' => \cookyii\modules\Media\ImageWrapper::className(),
                'Media' => static::getPlaceholder(),
            ]);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isImage()
    {
        return @getimagesize($this->getAbsolutePath()) !== false;
    }

    /**
     * @return \cookyii\modules\Media\Module
     */
    public static function getMediaModule()
    {
        /** @var \cookyii\modules\Media\Module|null $Module */
        $Module = \Yii::$app->getModule(static::$mediaModule);

        if (!($Module instanceof \cookyii\modules\Media\Module)) {
            throw new \RuntimeException(\Yii::t('cookyii.media', 'Media module not configured'));
        }

        return $Module;
    }

    /**
     * @return \cookyii\modules\Media\resources\queries\MediaQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Media\resources\queries\MediaQuery::className(),
            [get_called_class()]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%media}}';
    }

    /**
     * Events
     */
    private function events()
    {
        $this->on(static::EVENT_BEFORE_VALIDATE, function (\yii\base\ModelEvent $Event) {
            /** @var static $Model */
            $Model = $Event->sender;
            $Model->size = filesize($Model->path);
            $Model->mime = FileHelper::getMimeType($Model->path);
            $Model->sha1 = sha1_file($Model->path);
        });
    }
}