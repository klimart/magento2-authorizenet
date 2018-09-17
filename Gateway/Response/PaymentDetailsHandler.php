<?php

namespace CodiLuck\Authorizenet\Gateway\Response;

use CodiLuck\Authorizenet\Gateway\Response\ResponseFields;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Model\InfoInterface;

/**
 * Class PaymentDetailsHandler
 * @package CodiLuck\Authorizenet\Gateway\Response
 */
class PaymentDetailsHandler implements HandlerInterface
{
    /**
     * @var array
     */
    protected $additionalInformation = [
        ResponseFields::AUTH_CODE => 'auth_code',
        ResponseFields::AVS_RESULT_CODE => 'avs_result_code',
        ResponseFields::CVV_RESULT_CODE => 'cvv_result_code',
        ResponseFields::CAVV_RESULT_CODE => 'cavv_result_code',
        ResponseFields::ACCOUNT_NUMBER => 'account_number',
        ResponseFields::ACCOUNT_TYPE => 'account_type',
        ResponseFields::TEST_REQUEST => 'test_request'
    ];

    /**
     * @inheritdoc
     */
    public function handle(array $handlingSubject, array $response)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $handlingSubject['payment'];

        /** @var InfoInterface $payment */
        $payment = $paymentDataObject->getPayment();

        $transactionResponse = $response[ResponseFields::TRANSACTION_RESPONSE];
        foreach ($this->additionalInformation as $responseKey => $paymentKey) {
            if (isset($transactionResponse[$responseKey]) && !empty($transactionResponse[$responseKey])) {
                $payment->setAdditionalInformation($paymentKey, $transactionResponse[$responseKey]);
            }
        }
    }
}