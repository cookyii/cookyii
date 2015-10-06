<?php
/**
 * _general_picture.php
 * @author Revin Roman
 * @link https://rmrevin.com
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

use yii\helpers\Html;
use yii\helpers\Url;

echo Html::fileInput('file', null, [
    'id' => 'picture',
    'data-action' => Url::to(['/feed/item/rest/upload/picture']),
]);

?>
<br>
<div ng-if="data.picture_300">
    <img ng-src="{{ data.picture_300 }}">
</div>
