<?php

namespace CodiLuck\Authorizenet\Gateway\Validator;

use Magento\Payment\Gateway\Validator\AbstractValidator;
use Magento\Payment\Gateway\Validator\ResultInterface;

/**
 * Class GeneralResponseValidator
 * @package CodiLuck\Authorizenet\Gateway\Response
 */
class GeneralResponseValidator extends AbstractValidator
{
    /**
     * @inheritdoc
     */
    public function validate(array $validationSubject)
    {
        $response = $validationSubject['response'];

        $isValid = true;
        $errorMessages = [];

        foreach ($this->getResponseValidators() as $validator) {
            $validationResult = $validator($response);

            if (!$validationResult[0]) {
                $isValid = $validationResult[0];
                $errorMessages = array_merge($errorMessages, $validationResult[1]);
            }
        }

        return $this->createResult($isValid, $errorMessages);
    }

    /**
     * @return array
     */
    protected function getResponseValidators()
    {
        return [
            function ($response) {
                return [
                    isset($response['transactionResponse']) && is_array($response['transactionResponse']),
                    [__('Authorize.NET error response')]
                ];
            },
            function ($response) {
                return [
                    isset($response['messages']['resultCode']) && 'Ok' === $response['messages']['resultCode'],
                    //[$response['messages']['resultCode'][0]['text'] ?: __('Authorize.NET error response')]
                    [$response['messages']['message'][0]['text'] ?: __('Authorize.NET error response')]
                ];
            },
            function ($response) {
                return [
                    empty($response['transactionResponse']['errors']),
                    //[$response['transactionResponse']['errors'][0]['errorText'] ?: __('Authorize.NET error response')]
                    [$response['messages']['message'][0]['text'] ?: __('Authorize.NET error response')]
                ];
            }
        ];
    }



}