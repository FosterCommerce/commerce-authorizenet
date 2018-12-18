<?php
namespace fostercommerce\commerceauthorizenet\models;

use craft\commerce\models\payments\CreditCardPaymentForm;

class AcceptJsPaymentForm extends CreditCardPaymentForm
{

    public $dataDescriptor;
    public $dataValue;

    public function setAttributes($values, $safeOnly = true)
    {
        parent::setAttributes($values, $safeOnly);

        if (isset($values['dataValue'])) {
            $this->dataValue = $values['dataValue'];
        }
    }

    public function rules(): array
    {
        return [
            [['dataDescriptor', 'dataValue'], 'required']
        ];
    }

    // public function populateFromPaymentSource(PaymentSource $paymentSource)
    // {
    //     $this->opaqueDataValue = $paymentSource->token;
    // }
}