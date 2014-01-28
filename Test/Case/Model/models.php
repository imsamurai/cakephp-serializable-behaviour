<?

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: Jan 19, 2014
 * Time: 1:45:01 PM
 * Format: http://book.cakephp.org/2.0/en/views.html
 * 
 */
App::uses('Model', 'Model');

class SerializableTestAppModel extends Model {

	/**
	 * {@inheritdoc}
	 * 
	 * @param array $results
	 * @param bool $primary
	 * @return array
	 */
	public function afterFind($results, $primary = false) {
		if (!$primary && $this->Behaviors->enabled('Serializable')) {
			return $this->Behaviors->Serializable->afterFind($this, $results, $primary);
		}
		return parent::afterFind($results, $primary);
	}

}

class SerializableSimpleTestModel extends SerializableTestAppModel {

	/**
	 * {@inheritdoc}
	 *
	 * @var string 
	 */
	public $name = 'SerializableSimpleTestModel';

	/**
	 * {@inheritdoc}
	 *
	 * @var string 
	 */
	public $useTable = 'serializable';

	/**
	 * {@inheritdoc}
	 *
	 * @var int
	 */
	public $recursive = -1;

	/**
	 * {@inheritdoc}
	 * 
	 * @var array 
	 */
	public $actsAs = array(
		'Containable',
		'Serializable.Serializable' => array(
			'fields' => array(
				'field1',
				'field2'
			)
		)
	);

}

class SerializableBelongsToAssocTestModel extends SerializableTestAppModel {

	/**
	 * {@inheritdoc}
	 *
	 * @var string 
	 */
	public $name = 'SerializableBelongsToAssocTestModel';

	/**
	 * {@inheritdoc}
	 *
	 * @var string 
	 */
	public $useTable = 'serializable_assoc';

	/**
	 * {@inheritdoc}
	 *
	 * @var int
	 */
	public $recursive = -1;

	/**
	 * {@inheritdoc}
	 * 
	 * @var array 
	 */
	public $actsAs = array(
		'Containable',
		'Serializable.Serializable' => array(
			'fields' => array(
				'field3'
			)
		)
	);

	/**
	 * {@inheritdoc}
	 * 
	 * @var array 
	 */
	public $belongsTo = array(
		'SerializableSimpleTestModel' => array(
			'foreignKey' => 'serializable_id'
		)
	);

}

class SerializableBelongsToSelfAssocTestModel extends SerializableTestAppModel {

	/**
	 * {@inheritdoc}
	 *
	 * @var string 
	 */
	public $name = 'SerializableBelongsToSelfAssocTestModel';

	/**
	 * {@inheritdoc}
	 *
	 * @var string 
	 */
	public $useTable = 'serializable_assoc';

	/**
	 * {@inheritdoc}
	 *
	 * @var int
	 */
	public $recursive = -1;

	/**
	 * {@inheritdoc}
	 * 
	 * @var array 
	 */
	public $actsAs = array(
		'Containable',
		'Serializable.Serializable' => array(
			'fields' => array(
				'field3'
			)
		)
	);

	/**
	 * {@inheritdoc}
	 * 
	 * @var array 
	 */
	public $belongsTo = array(
		'SerializableSimpleTestModel' => array(
			'className' => 'SerializableBelongsToSelfAssocTestModel',
			'foreignKey' => 'serializable_id'
		)
	);

}

//class SerializableHasOneAssocTestModel extends SerializableTestAppModel {
//
//	/**
//	 * {@inheritdoc}
//	 *
//	 * @var string 
//	 */
//	public $name = 'SerializableBelongsToAssocTestModel';
//
//	/**
//	 * {@inheritdoc}
//	 *
//	 * @var string 
//	 */
//	public $useTable = 'serializable_assoc';
//
//	/**
//	 * {@inheritdoc}
//	 *
//	 * @var int
//	 */
//	public $recursive = -1;
//
//	/**
//	 * {@inheritdoc}
//	 * 
//	 * @var array 
//	 */
//	public $actsAs = array(
//		'Containable',
//		'Serializable.Serializable' => array(
//			'fields' => array(
//				'field3'
//			)
//		)
//	);
//
//	/**
//	 * {@inheritdoc}
//	 * 
//	 * @var array 
//	 */
//	public $belongsTo = array(
//		'SerializableSimpleTestModel' => array(
//			'foreignKey' => 'serializable_id'
//		)
//	);
//
//}
