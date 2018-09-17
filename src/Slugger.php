<?php
/**
 * Slugger plugin for Craft CMS 3.x
 *
 * Hashes the Id of an entry when it is saved and replaces the slug.
 *
 * @link      https://madmadmad.com
 * @copyright Copyright (c) 2018 Madhouse
 */

namespace madhouse\slugger;

use madhouse\slugger\services\SluggerService as SluggerServiceService;
use madhouse\slugger\variables\SluggerVariable;
use madhouse\slugger\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Elements;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class Slugger
 *
 * @author    Madhouse
 * @package   Slugger
 * @since     1.0.0
 *
 * @property  SluggerServiceService $sluggerService
 */
class Slugger extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Slugger
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        
        require_once 'vendor/autoload.php';
        
        $this->setComponents([
			'SluggerService' => services\SluggerService::class,
		]);

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('slugger', SluggerVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );
        
       Event::on(Elements::class, Elements::EVENT_AFTER_SAVE_ELEMENT, function(Event $event){
        
            // Only hash if new entry
            if ($event->isNew)
            {
            
                // Get the settings
                $pluginSettings = $this->getSettings();
                // Get the section
                $sectionId = $event->element->sectionId;

                // Get the slugger settings
                if (isset($pluginSettings['sections'][$sectionId]))
                {
                    $settings = $pluginSettings['sections'][$sectionId];
                } else {
                    $settings['enabled'] = false;
                }
                
                // We only want to generate the slug if its enabled in the slugger settings
                if($settings['enabled'])
                {
                    $slug = $this->SluggerService->encodeById($event->element->id, $settings);
                    $event->element->slug = $slug;
                    Craft::$app->elements->saveElement($event->element);

                }
            }
        });

        Craft::info(
            Craft::t(
                'slugger',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'slugger/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
