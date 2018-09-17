<?php
/**
 * Slugger plugin for Craft CMS 3.x
 *
 * Hashes the Id of an entry when it is saved and replaces the slug.
 *
 * @link      https://madmadmad.com
 * @copyright Copyright (c) 2018 Madhouse
 */

namespace madhouse\slugger\models;

use madhouse\slugger\Slugger;

use Craft;
use craft\base\Model;

/**
 * @author    Madhouse
 * @package   Slugger
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $salt = 'Change me to something else';
    public $length = 8;
    public $alphabet = 'abcdefghijklmnopqrstuvwxyz123456789';
    public $sections = array();

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['salt', 'string'],
            ['salt', 'default', 'value' => 'Change me to something else'],
            ['length', 'number'],
            ['length', 'default', 'value' => 8],
            ['alphabet', 'string'],
            ['alphabet', 'default', 'value' => 'abcdefghijklmnopqrstuvwxyz123456789'],
        ];
    }
}
