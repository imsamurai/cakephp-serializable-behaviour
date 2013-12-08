<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 02.07.2012
 * Time: 11:34:16
 */

/**
 * Serializable Behavior
 */
class SerializableBehavior extends ModelBehavior {

	/**
	 * Contains configuration for each model
	 *
	 * @var array
	 */
	public $config;

	/**
	 * Initialize Serializable Behavior
	 *
	 * @param Model $Model Model which uses behaviour
	 * @param array $config Behaviour config
	 */
	public function setup(Model $Model, $config = array()) {
		parent::setup($Model, $config);
		$this->config[$Model->alias] = $config + (array) Configure::read('Serializable') + array(
			'fields' => array(),
			'serialize' => 'serialize',
			'unserialize' => 'unserialize',
		);
	}

	/**
	 * After find callback. Unserializes all specified fields in each result
	 *
	 * @param Model $model Model using this behavior
	 * @param mixed $results The results of the find operation
	 * @param boolean $primary Whether this model is being queried directly (vs. being queried as an association)
	 * @return array
	 */
	public function afterFind(Model $Model, $results, $primary = false) {
		foreach ($results as $key => &$result) {
			foreach ($this->config[$Model->alias]['fields'] as $field) {
				if (isset($result[$Model->alias][$field])) {
					$result[$Model->alias][$field] = $this->_unserialize($Model->alias, $result[$Model->alias][$field]);
				} elseif (isset($result[$field])) {
					$result[$field] = $this->_unserialize($Model->alias, $result[$field]);
				} elseif ($key === $field) {
					$result = $this->_unserialize($Model->alias, $result);
				}
			}
		}
		unset($result);
		return $results;
	}

	/**
	 * Before save callback. Serializes all specified fields in model data
	 *
	 * @param Model $Model Model using this behavior
	 * @param array $options
	 * @return boolean True
	 */
	public function beforeSave(Model $Model, $options = array()) {
		foreach ($this->config[$Model->alias]['fields'] as $field) {
			if (isset($Model->data[$Model->alias][$field])) {
				$Model->data[$Model->alias][$field] = $this->_serialize($Model->alias, $Model->data[$Model->alias][$field]);
			} elseif (isset($Model->data[$field])) {
				$Model->data[$field] = $this->_serialize($Model->alias, $Model->data[$field]);
			}
		}
		return true;
	}

	/**
	 * After save callback. Unserializes all specified fields in each result
	 * 
	 * @param Model $model Model using this behavior
	 * @param bool $created Is this record created or updated
	 * @param array $options
	 */
	public function afterSave(Model $model, $created, $options = array()) {
		$model->data = $this->afterFind($model, $model->data);
	}

	/**
	 * Invokes serialization. Serialization function is set by
	 * globall config, model config or defaults to `serialize`
	 *
	 * @param string $alias Model using this behavior alias
	 * @param mixed $data Data to serialize
	 * @return string Serialized data
	 */
	protected function _serialize($alias, $data) {
		return call_user_func($this->config[$alias]['serialize'], $data);
	}

	/**
	 * Invokes unserialization. Unserialization function is set by
	 * globall config, model config or defaults to `unserialize`
	 *
	 * @param string $alias Model using this behavior alias
	 * @param mixed $data Data to serialize
	 * @return mixed Unserialized data
	 */
	protected function _unserialize($alias, $data) {
		return call_user_func($this->config[$alias]['unserialize'], $data);
	}

}
