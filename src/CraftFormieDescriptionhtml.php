<?php
/**
 * Craft Formie HTML Description plugin for Craft CMS 3.x
 *
 * Include the full html for a description field in Formie
 *
 * @link      https://perfectwebteam.nl/
 * @copyright Copyright (c) 2022 Perfectwebteam
 */

namespace perfectwebteam\craftformiedescriptionhtml;


use craft\base\Plugin;
use craft\events\DefineGqlTypeFieldsEvent;
use craft\gql\TypeManager;
use GraphQL\Type\Definition\Type;
use yii\base\Event;

/**
 * Class CraftFormieDescriptionhtml
 *
 * @author    Perfectwebteam
 * @package   CraftFormieDescriptionhtml
 * @since     0.0.1
 *
 */
class CraftFormieDescriptionhtml extends Plugin
{
    /**
     * @var CraftFormieDescriptionhtml
     */
    public static $plugin;

    /**
     * @var string
     */
    public string $schemaVersion = '0.0.1';

    /**
     * @var bool
     */
    public bool $hasCpSettings = false;

    /**
     * @var bool
     */
    public bool $hasCpSection = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            TypeManager::class,
            TypeManager::EVENT_DEFINE_GQL_TYPE_FIELDS,
            static function(DefineGqlTypeFieldsEvent $event) {
                if ($event->typeName == 'Field_Agree') {
                    $event->fields['descriptionHtml'] = [
                        'name' => 'descriptionHtml',
                        'type' => Type::string(),
                        'resolve' => function($source, $arguments, $context, $resolveInfo) {
                            return $source->getDescriptionHtml();
                        }
                    ];
                }
            }
        );
    }
}
