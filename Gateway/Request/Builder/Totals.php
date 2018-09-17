<?php

namespace CodiLuck\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;

/**
 * Class Totals
 * @package CodiLuck\Authorizenet\Gateway\Request\Builder
 */
class Totals implements BuilderInterface
{
    /**
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        $payment = $paymentDataObject->getPayment();
        $order = $paymentDataObject->getOrder();

        /** @var \Magento\Sales\Model\Order $orderModel */
        $orderModel = $payment->getOrder();

        return [
            'tax' => [
                'amount' => $orderModel->getBaseTaxAmount()
            ],
            'duty' => [
                'amount' => '0'
            ],
            'shipping' => [
                'amount' => $orderModel->getBaseShippingAmount(),
                'name' => $orderModel->getShippingMethod()
            ],
            'poNumber' => $order->getOrderIncrementId()
        ];
    }
}