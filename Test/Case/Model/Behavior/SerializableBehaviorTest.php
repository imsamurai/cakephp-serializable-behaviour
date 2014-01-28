<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: Jan 19, 2014
 * Time: 1:40:11 PM
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */
require_once dirname(dirname(__FILE__)) . DS . 'models.php';

/**
 * SerializableBehaviorTest
 */
class SerializableBehaviorTest extends CakeTestCase {

	/**
	 * {@inheritdoc}
	 *
	 * @var array
	 */
	public $fixtures = array(
		'plugin.Serializable.Serializable',
		'plugin.Serializable.SerializableAssoc',
	);

	/**
	 * {@inheritdoc}
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * Test simple save/read
	 */
	public function testSimple() {
		$field1 = array(
			array(
				'somedata' => array(
					'k' => 1
				)
			)
		);

		$field2 = array(1, 2, 3, 4, 5);

		$Model = ClassRegistry::init('SerializableSimpleTestModel');
		$success = $Model->save(compact('field1', 'field2'));
		$this->assertTrue((bool)$success);
		$data = $Model->read(array('field1', 'field2'), $Model->id);
		$this->assertSame($field1, $data[$Model->alias]['field1']);
		$this->assertSame($field2, $data[$Model->alias]['field2']);
		$success = $Model->saveField('field1', $field1);
		$this->assertTrue((bool)$success);
		$success = $Model->saveField('field2', $field2);
		$this->assertTrue((bool)$success);
		$this->assertSame($field1, $Model->field('field1'));
		$this->assertSame($field2, $Model->field('field2'));
	}

	public function testBelongsToAssoc() {
		$data = array(
			'SerializableBelongsToAssocTestModel' => array(
				'id' => 10,
				'field3' => array('f' => 3)
			),
			'SerializableSimpleTestModel' => array(
				'id' => 11,
				'field1' => array(1, 2, 3, 4, 5),
				'field2' => array('k' => 's')
			)
		);

		$Model = ClassRegistry::init('SerializableBelongsToAssocTestModel');
		$success = $Model->saveAssociated($data);
		$this->assertTrue((bool)$success);
		$Model->contain('SerializableSimpleTestModel');
		$storedData = $Model->find('first', array(
			'conditions' => array(
				'SerializableBelongsToAssocTestModel.id' => 10
			)
		));
		$data['SerializableBelongsToAssocTestModel']['serializable_id'] = 11;
		$this->assertEqual($data, $storedData);
	}

	public function testBelongsToSelfAssoc() {
		$data = array(
			'SerializableBelongsToSelfAssocTestModel' => array(
				'id' => 10,
				'field3' => array('f' => 3)
			),
			'SerializableSimpleTestModel' => array(
				'id' => 11,
				'field3' => array(1, 2, 3, 4, 5)
			)
		);

		$Model = ClassRegistry::init('SerializableBelongsToSelfAssocTestModel');
		$success = $Model->saveAssociated($data);
		$this->assertTrue((bool)$success);
		$Model->contain('SerializableSimpleTestModel');
		$storedData = $Model->find('first', array(
			'conditions' => array(
				'SerializableBelongsToSelfAssocTestModel.id' => 10
			)
		));
		$data['SerializableBelongsToSelfAssocTestModel']['serializable_id'] = 11;
		$data['SerializableSimpleTestModel']['serializable_id'] = 0;
		$this->assertEqual($data, $storedData);
	}

}
