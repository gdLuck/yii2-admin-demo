<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_backend`.
 */
class m170412_123119_create_user_backend_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_backend', [
            'id' => $this->primaryKey(),
            'username' => $this->char(255)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_backend');
    }
}
