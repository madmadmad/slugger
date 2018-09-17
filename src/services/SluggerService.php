<?php
/**
 * Slugger plugin for Craft CMS 3.x
 *
 * Hashes the Id of an entry when it is saved and replaces the slug.
 *
 * @link      madmadmad.com
 * @copyright Copyright (c) 2018 Madhouse
 */

namespace madhouse\slugger\services;

use madhouse\slugger\Slugger;

use Craft;
use craft\base\Component;

/**
 * @author    Madhouse
 * @package   Slugger
 * @since     1.0.0
 */
class SluggerService extends Component
{

	protected $length;
	protected $alphabet;
	protected $salt;
	protected $encoder;

	public function __construct()
	{
		$settings = Craft::$app->plugins->getPlugin('slugger')->getSettings();
		
		$this->length = $settings['length'];
		$this->salt = $settings['salt'];
		$this->alphabet = $settings['alphabet'];

		$this->encoder = new \Hashids\Hashids($this->salt, $this->length, $this->alphabet);
	}
	
	
    /**
	 * Encode the id and return it
	 *
	 * This method will take EntryModel that's passed and encode it's ID, the entries slug attribute will then be replaced
	 * with the encoded ID and saved.
	 *
	 * @param $id  A number to hash.
	 *
	 *
	 * @return string|$encodedId the encoded ID
	 */
	public function encodeById($id,$settings)
	{
		
		if ( $settings['length'] ) 
		{
			$length = $settings['length'];
			$this->encoder = new \Hashids\Hashids($this->salt, $length, $this->alphabet);
		}
		$encodedId = $this->encoder->encode($id);
		return $encodedId;
	}

	public function decode($hash)
	{
		$id = $this->encoder->decode($hash);
		return reset($id);
	}
}
