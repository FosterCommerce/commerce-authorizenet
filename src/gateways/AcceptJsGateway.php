<?php

namespace fostercommerce\commerceauthorizenet\gateways;

use Craft;
use craft\commerce\omnipay\base\CreditCardGateway;
use craft\web\View;
use craft\commerce\models\payments\BasePaymentForm;
use Omnipay\Common\AbstractGateway;
use Omnipay\Omnipay;
use Omnipay\AuthorizeNet\AIMGateway as OmnipayGateway;
use fostercommerce\commerceauthorizenet\models\AcceptJsPaymentForm;

class AcceptJsGateway extends CreditCardGateway
{

    public $clientKey;

    public $apiLoginId;

    public $transactionKey;

    public $developerMode = false;

    public $hashSecret = '';

    public static function displayName(): string
    {
        return Craft::t('commerce-authorizenet', 'Authorize.Net Accept.JS Gateway');
    }

    public function getSettingsHtml()
    {
        return Craft::$app->view->renderTemplate('commerce-authorizenet/acceptJsGatewaySettings', ['gateway' => $this]);
    }

    public function getPaymentFormModel(): BasePaymentForm
    {
        return new AcceptJsPaymentForm();
    }

    protected function createGateway(): AbstractGateway
    {
        $gateway = Omnipay::create($this->getGatewayClassName());

        $gateway->setApiLoginId($this->apiLoginId);
        $gateway->setTransactionKey($this->transactionKey);
        $gateway->setDeveloperMode($this->developerMode);
        $gateway->setHashSecret($this->hashSecret);

        return $gateway;
    }

    public function populateRequest(array &$request, BasePaymentForm $paymentForm = null)
    {
        if ($paymentForm &&
            $paymentForm->hasProperty('dataValue') &&
            $paymentForm->dataValue &&
            $paymentForm->hasProperty('dataDescriptor') &&
            $paymentForm->dataDescriptor
        ) {
            // commerce-omnipay uses the Transaction hash which is 32 characters
            // long. The MaxLength for `transactionId` on Authorize.net is 20
            // characters.
            $request['transactionId'] = '';

            $request['opaqueDataValue'] = $paymentForm->dataValue;
            $request['opaqueDataDescriptor'] = $paymentForm->dataDescriptor;
        }
    }

    protected function getGatewayClassName()
    {
        return '\\'.OmnipayGateway::class;
    }
}
