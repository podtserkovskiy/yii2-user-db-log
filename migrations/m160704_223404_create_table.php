<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table`.
 */
class m160704_223404_create_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_db_log', [
            'id' => $this->primaryKey(),
            'entity' => $this->string(),
            'entity_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'event' => $this->string(),
            'attributes' => $this->text(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->addForeignKey('user_db_log_user', 'user_db_log', 'user_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('user_db_log_user', 'user_db_log');
        $this->dropTable('user_db_log');
    }
}
