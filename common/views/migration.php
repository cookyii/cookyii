<?php
/**
 * migration.php
 * @author Revin Roman
 *
 * This view is used by yii\console\controllers\MigrateController
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */

echo "<?php\n";
?>

use yii\db\mysql\Schema;

class <?= $className ?> extends \common\components\Migration
{

    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "<?= $className ?> cannot be reverted.\n";

        return false;
    }
}