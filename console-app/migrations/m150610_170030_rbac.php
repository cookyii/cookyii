<?php

class m150610_170030_rbac extends \cookyii\db\Migration
{

    /**
     * @throws yii\base\InvalidConfigException
     * @return yii\rbac\DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof \yii\rbac\DbManager) {
            throw new \yii\base\InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

    public function up()
    {
        $authManager = $this->getAuthManager();

        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable($authManager->itemTable, [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
        ]);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->addPrimaryKey('primary', $authManager->ruleTable, ['name']);
        $this->addPrimaryKey('primary', $authManager->itemTable, ['name']);
        $this->addPrimaryKey('primary', $authManager->itemChildTable, ['parent', 'child']);
        $this->addPrimaryKey('primary', $authManager->assignmentTable, ['item_name', 'user_id']);

        $this->createIndex('idx_rbac_item_type', $authManager->itemTable, 'type');

        $this->addForeignKey('fkey_rbac_item_rule', $authManager->itemChildTable, 'rule_name', $authManager->ruleTable, 'name', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fkey_rbac_item_parent', $authManager->itemChildTable, 'parent', $authManager->itemTable, 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fkey_rbac_item_child', $authManager->itemChildTable, 'child', $authManager->itemTable, 'name', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $authManager = $this->getAuthManager();

        $this->dropForeignKey('fkey_rbac_item_child', $authManager->itemChildTable);
        $this->dropForeignKey('fkey_rbac_item_parent', $authManager->itemChildTable);
        $this->dropForeignKey('fkey_rbac_item_rule', $authManager->itemChildTable);

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }
}