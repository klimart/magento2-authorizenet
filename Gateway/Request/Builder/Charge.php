<?php

namespace CodiLuck\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Request\BuilderInterface;

/**
 * Class Charge
 * @package CodiLuck\Authorizenet\Gateway\Request\Builder
 */
class Charge implements BuilderInterface
{
    /**
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject)
    {
        $amount = $buildSubject['amount'];

        return [
            'transactionType' => 'authCaptureTransaction',
            'amount' => $amount
        ];
    }
}