<?php
/**
 * migration.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * This view is used by yii\console\controllers\MigrateController
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */

echo "<?php\n";
?>

use yii\db\mysql\Schema;

class <?= $className ?> extends \components\db\Migration
{

    public function up()
    {

    }

    public function down()
    {
        echo "<?= $className ?> cannot be reverted.\n";

        return false;
    }
}