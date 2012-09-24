cakephp-serializable-behaviour
==============================

Serializable Behaviour for CakePHP 2.1+

Use it if you want to save and read serialized data into db.

## Installation

	cd my_cake_app/app
	git clone git://github.com/imsamurai/cakephp-serializable-behaviour.git Plugin/Serializable
  
or if you use git add as submodule:

	cd my_cake_app
	git submodule add "git://github.com/imsamurai/cakephp-serializable-behaviour.git" "app/Plugin/Serializable"
  
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