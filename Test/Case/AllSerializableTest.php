<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: Jan 19, 2014
 * Time: 1:40:11 PM
 */

/**
 * AllSerializableTest suite
 * 
 * @package SerializableTest
 * @subpackage Test
 */
class AllSerializableTest extends PHPUnit_Framework_TestSuite {

	/**
	 * Suite define the tests for this suite
	 *
	 * @return void
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Serializable Tests');
		$path = App::pluginPath('Serializable') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);
		return $suite;
	}

}
