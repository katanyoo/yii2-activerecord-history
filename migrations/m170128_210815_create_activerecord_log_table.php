<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activerecord_log`.
 */
class m170128_210815_create_activerecord_log_table extends Migration {
	/**
	 * @inheritdoc
	 */
	public function up() {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('activerecord_log', [
			'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
			'description' => $this->text(),
			'action' => $this->string(20),
			'model' => $this->string(64),
			'model_id' => $this->integer(),
			'field' => $this->string(64),
            'old_value' => $this->text(),
            'new_value' => $this->text(),
			'created_at' => $this->integer()->notNull(),
		], $tableOptions);
	}

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('activerecord_log');
    }
}
