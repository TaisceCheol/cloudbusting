<?php
/**
 * cloudbusting plugin for Craft CMS
 *
 * Purge cloudflare cache for Craft CMS entries on save
 *
 * @author    Piaras Hoban
 * @copyright Copyright (c) 2017 Piaras Hoban
 * @link      https://www.itma.ie
 * @package   Cloudbusting
 * @since     1.0.0
 */

namespace Craft;

class CloudbustingPlugin extends BasePlugin
{

    public function init()
    {
        parent::init();
        craft()->on('entries.saveEntry', function(Event $event) {
            craft()->cloudbusting->purgeCache($event->params['entry']['url']);
        });       
    }

    public function getName()
    {
         return Craft::t('cloudbusting');
    }

    public function getDescription()
    {
        return Craft::t('Purge Cloudflare cache for Craft CMS entries on save');
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/TaisceCheol/cloudbusting/blob/master/README.md';
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'Piaras Hoban';
    }

    public function getDeveloperUrl()
    {
        return 'https://www.itma.ie';
    }

    protected function defineSettings()
    {
        return array(
            'apiKey' => array(AttributeType::String, 'required' => true, 'label' => 'API Key'),
            'zone' => array(AttributeType::String, 'required' => true, 'label' => 'Zone ID'),
            'email' => array(AttributeType::String, 'required' => true, 'label' => 'Cloudflare Email')
        );
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('cloudbusting/_settings', array(
            'settings' => $this->getSettings()
        ));
    }
}