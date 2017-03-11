<?php

namespace katanyoo\activerecordhistory;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * ActiveRecord Behavior
 */
class ActiveRecordBehavior extends Behavior {
	public $database = 'db2';
	public $ignoreAttributes = [];

	/**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

	public function afterDelete($event) {

		$user = '';
		$user_id = 0;
		if (!isset(\Yii::$app->user)) {
			$user = 'GUEST';
		} else {
			$user = \Yii::$app->user->identity->username;
			$user_id = \Yii::$app->user->identity->id;
		}

		$path = explode('\\', get_class($this->owner));
		$md = array_pop($path);

		$log = new ActiveRecordLog();
		$log->description = 'User ' . $user . ' deleted '
		. $md
		. '[' . $this->owner->getPrimaryKey() . '].';
		$log->action = 'DELETE';
		$log->model = $md;
		$log->model_id = $this->owner->getPrimaryKey();
		$log->old_value = print_r($this->owner->attributes, true);
		$log->field = '';
		$log->user_id = $user_id;
		$log->ip = \Yii::$app->request->userIP;
		$log->created_at = strtotime('now');
		$log->save(false);
	}

	public function afterInsert($event) {
		$user = '';
		$user_id = 0;
		if (!isset(\Yii::$app->user)) {
			$user = 'GUEST';
		} else {
			$user = \Yii::$app->user->identity->username;
			$user_id = \Yii::$app->user->identity->id;
		}

		$path = explode('\\', get_class($this->owner));
		$md = array_pop($path);

		$log = new ActiveRecordLog();
		$log->description = 'User ' . $user
		. ' created ' . $md
		. '[' . $this->owner->getPrimaryKey() . '].';
		$log->action = 'CREATE';
		$log->model = $md;
		$log->model_id = $this->owner->getPrimaryKey();
		$log->field = '';
		$log->new_value = print_r($this->owner->attributes, true);
		$log->user_id = $user_id;
		$log->ip = \Yii::$app->request->userIP;
		$log->created_at = strtotime('now');
		$log->save(false);
	}

	public function afterUpdate($event) {

	}

	public function beforeUpdate($event) {
		$user = '';
		$user_id = 0;
		if (!isset(\Yii::$app->user)) {
			$user = 'GUEST';
		} else {
			$user = \Yii::$app->user->identity->username;
			$user_id = \Yii::$app->user->identity->id;
		}
		// \Yii::error(print_r($this->owner->getOldAttributes(), true), __METHOD__);
		// new attributes
		$newattributes = $this->owner->getAttributes();
		$oldattributes = $this->owner->getOldAttributes();
		// compare old and new
		foreach ($newattributes as $name => $value) {
			if (in_array($name, $this->ignoreAttributes)) {
				continue;
			}

			if (!empty($oldattributes)) {
				$old = $oldattributes[$name];
			} else {
				$old = '';
			}

			if ($value != $old) {

				// $changes = $name . ' ('.$old.') => ('.$value.'), ';
				$path = explode('\\', get_class($this->owner));
				$md = array_pop($path);

				$log = new ActiveRecordLog();
				$log->description = 'User ' . $user
				. ' changed ' . $name . ' for '
				. $md
				. '[' . $this->owner->getPrimaryKey() . '].';
				$log->action = 'CHANGE';
				$log->model = $md;
				$log->old_value = $old;
				$log->new_value = $value;
				$log->model_id = $this->owner->getPrimaryKey();
				$log->field = $name;
				$log->user_id = $user_id;
				$log->ip = \Yii::$app->request->userIP;
				$log->created_at = strtotime('now');
				$log->save(false);
			}
		}
	}

	public function events() {
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
			ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
			ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
		];
	}
}
