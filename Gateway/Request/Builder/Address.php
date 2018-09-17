<?php

namespace CodiLuck\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\AddressAdapterInterface;
use Magento\Payment\Gateway\Data\PaymentDataObject;
use Magento\Payment\Gateway\Request\BuilderInterface;

/**
 * Class Address
 * @package CodiLuck\Authorizenet\Gateway\Request\Builder
 */
class Address implements BuilderInterface
{
    /**
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObject $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        $order = $paymentDataObject->getOrder();

        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();

        $result = [
            'billTo' => $this->getFormattedAddress($billingAddress)
        ];

        if ($shippingAddress instanceof AddressAdapterInterface) {
            $result['shipTo'] = $this->getFormattedAddress($shippingAddress);
        }

        return $result;
    }

    /**
     * @param AddressAdapterInterface $address
     * @return array
     */
    private function getFormattedAddress(AddressAdapterInterface $address)
    {
        return [
            'firstName' => $address->getFirstname(),
            'lastName' => $address->getLastname(),
            'company' => $address->getCompany(),
            'address' => $address->getStreetLine1() . $address->getStreetLine2(),
            'city' => $address->getCity(),
            'state' => $address->getRegionCode(),
            'zip' => $address->getPostcode(),
            'country' => $address->getCountryId()
        ];
    }
}