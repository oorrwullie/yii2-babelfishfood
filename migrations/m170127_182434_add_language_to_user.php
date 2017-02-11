<?php

use yii\db\Migration;

class m170127_182434_add_language_to_user extends Migration
{
    public function up() {

 	$table = Yii::$app->db->schema->getTableSchema('user');

	if ($table !== null) {
	    if (!isset($table->columns['language'])) {
		$this->addColumn('user', 'language', 'varchar(10)');
	    }
	}
    }

    public function down()
    {
        echo "m170127_182434_add_language_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
