<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calendar}}`.
 */
class m191205_200606_create_calendar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%calendar}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('fk-activity_id-calendar', 'calendar', 'activity_id', 'activity', 'id');
        $this->addForeignKey('fk-user_id-calendar', 'calendar', 'user_id', 'user', 'id');

        // зачем??
        $this->renameColumn('activity', 'user_id', 'author_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('activity', 'author_id', 'user_id');


        $this->dropForeignKey('fk-activity_id-calendar', 'calendar');
        $this->dropForeignKey('fk-user_id-calendar', 'calendar');
        $this->dropTable('{{%calendar}}');
    }
}
