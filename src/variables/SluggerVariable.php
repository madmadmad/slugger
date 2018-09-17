<?php
/**
 * Slugger plugin for Craft CMS 3.x
 *
 * Hashes the Id of an entry when it is saved and replaces the slug.
 *
 * @link      madmadmad.com
 * @copyright Copyright (c) 2018 Madhouse
 */

namespace madhouse\slugger\variables;

use madhouse\slugger\Slugger;

use Craft;

/**
 * Slugger Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.slugger }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Madhouse
 * @package   Slugger
 * @since     1.0.0
 */
class SluggerVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.slugger.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.slugger.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function decode($hash)
    {
        return craft()->slugger->decode($hash);
    }
}