<?php
/**
 * migration.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * This view is used by yii\console\controllers\MigrateController
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */

echo "<?php\n";
?>

class <?= $className ?> extends \cookyii\db\Migration
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