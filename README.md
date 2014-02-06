CakePHP Serializable Behaviour
==============================
[![Build Status](https://travis-ci.org/imsamurai/cakephp-serializable-behaviour.png)](https://travis-ci.org/imsamurai/cakephp-serializable-behaviour) [![Coverage Status](https://coveralls.io/repos/imsamurai/cakephp-serializable-behaviour/badge.png?branch=master)](https://coveralls.io/r/imsamurai/cakephp-serializable-behaviour?branch=master) [![Latest Stable Version](https://poser.pugx.org/imsamurai/cakephp-serializable-behaviour/v/stable.png)](https://packagist.org/packages/imsamurai/cakephp-serializable-behaviour) [![Total Downloads](https://poser.pugx.org/imsamurai/cakephp-serializable-behaviour/downloads.png)](https://packagist.org/packages/imsamurai/cakephp-serializable-behaviour) [![Latest Unstable Version](https://poser.pugx.org/imsamurai/cakephp-serializable-behaviour/v/unstable.png)](https://packagist.org/packages/imsamurai/cakephp-serializable-behaviour) [![License](https://poser.pugx.org/imsamurai/cakephp-serializable-behaviour/license.png)](https://packagist.org/packages/imsamurai/cakephp-serializable-behaviour)


Serializable Behaviour for CakePHP 2.1+

Use it if you want to save and read serialized data into db.

## Installation

	cd my_cake_app/app
	git clone git://github.com/imsamurai/cakephp-serializable-behaviour.git Plugin/Serializable

or if you use git add as submodule:

	cd my_cake_app
	git submodule add "git://github.com/imsamurai/cakephp-serializable-behaviour.git" "app/Plugin/Serializable"

then add plugin loading in Config/bootstrap.php

	CakePlugin::load('Serializable');

## Configuration

Write global config if you need to use custom serialization function:

	Configure::write('Serializable', array(
	  'serialize' => <valid callable>,
	  'unserialize' => <valid callable>
	));

Attach behaviour to model:

	public $actsAs = array(
	      'Serializable.Serializable' => array(
	        'fields' => <array of field names>,
	        'serialize' => <valid callable>, // optional
	        'unserialize' => <valid callable> // optional
	      )
	);

By default serialization uses function `serialize`, unserialization - `unserialize`

## Advanced usage

If you want to use serialization with Containable behaviour you must modify your AppModel.
For example we have 3 models that extedned AppModel:
NewsPopular has many NewsPopularItem
NewsPopularItem belongs to Article

NewsPopularItem and Article has some serialized fields.

Assume you want to fetch data this way:

	$this->NewsPopular->contain(array(
			'NewsPopularItem' => array(
				'Article'
			)
		));
	$data = $this->NewsPopular->find('first');

In this case you must add some configuration to AppModel::afterFind. In basic case there must be:

	public function afterFind($results, $primary = false) {
		if (!$primary && $this->Behaviors->enabled('Serializable')) {
			return $this->Behaviors->Serializable->afterFind($this, $results, $primary);
		}
		return parent::afterFind($results, $primary);
	}

And that's all! Now you have data structure with unserialized fields. 