CakePHP Serializable Behaviour
==============================

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