<?php

namespace katanyoo\activerecordhistory;

use yii\db\ActiveRecord;
use yii\base\Behavior;
/**
 * ActiveRecord Behavior
 */
class ActiveRecordBehavior extends Behavior
{
	public function events()
	{
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
			// ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
			// ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
			ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
		];
	}

	public function afterInsert($event)
	{
		if (!isset(\Yii::$app->user))
			return;
		$path = explode('\\', get_class($this->owner));
		$md = array_pop($path);

		$log=new ActiveRecordLog();
		$log->description=  'User ' . \Yii::$app->user->identity->username 
		                        . ' created ' . $md 
		                        . '[' . $this->owner->getPrimaryKey() .'].';
		$log->action=       'CREATE';
		$log->model=        $md;
		$log->model_id=      $this->owner->getPrimaryKey();
		$log->field=        '';
		$log->user_id=       \Yii::$app->user->identity->id;
		$log->save();
	}

	public function afterUpdate($event)
	{

	}

	public function beforeUpdate($event)
	{
		if (!isset(\Yii::$app->user))
			return;
		// \Yii::error(print_r($this->owner->getOldAttributes(), true), __METHOD__);
		// new attributes
		$newattributes = $this->owner->getAttributes();
		$oldattributes = $this->owner->getOldAttributes();
		// compare old and new
		foreach ($newattributes as $name => $value) {
		    if (!empty($oldattributes)) {
		        $old = $oldattributes[$name];
		    } else {
		        $old = '';
		    }
		
		    if ($value != $old) {

		        //$changes = $name . ' ('.$old.') => ('.$value.'), ';
				$path = explode('\\', get_class($this->owner));
				$md = array_pop($path);

		        $log=new ActiveRecordLog();
		        $log->description =  'User ' . \Yii::$app->user->identity->username 
		                                . ' changed ' . $name . ' for ' 
		                                . $md 
		                                . '[' . $this->owner->getPrimaryKey() .'].';
		        $log->action = 'CHANGE';
		        $log->model = $md;
		        $log->model_id = $this->owner->getPrimaryKey();
		        $log->field = $name;
		        $log->user_id = \Yii::$app->user->identity->id;
		        $log->save();
		    }
		}
	}

	public function afterDelete($event)
	{
		$path = explode('\\', get_class($this->owner));
		$md = array_pop($path);

		$log=new ActiveRecordLog();
		$log->description=  'User ' . \Yii::$app->user->identity->username . ' deleted ' 
		                        . $md 
		                        . '[' . $this->owner->getPrimaryKey() .'].';
		$log->action=       'DELETE';
		$log->model=        $md;
		$log->model_id=      $this->owner->getPrimaryKey();
		$log->field=        '';
		$log->user_id=       \Yii::$app->user->identity->id;
		$log->save();
	}
}
