<?php
namespace fostercommerce\commerceauthorizenet;

use Craft;
use fostercommerce\commerceauthorizenet\gateways\AIMGateway;
use fostercommerce\commerceauthorizenet\gateways\AcceptJsGateway;
use craft\commerce\services\Gateways;
use craft\events\RegisterComponentTypesEvent;
use yii\base\Event;

class Plugin extends \craft\base\Plugin
{
    public function init()
    {
        parent::init();

        Event::on(
            Gateways::class,
            Gateways::EVENT_REGISTER_GATEWAY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = AcceptJsGateway::class;
            }
        );
    }
}
