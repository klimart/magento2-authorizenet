<?php

namespace CodiLuck\Authorizenet\Gateway;

use Magento\Framework\Exception\NotFoundException;
use Magento\Payment\Gateway\Config\ValueHandlerPoolInterface;

/**
 * Class Config
 * @package CodiLuck\Authorizenet\Gateway
 */
class Config
{
    /**
     * @var ValueHandlerPoolInterface
     */
    protected $valueHandlerPool;

    /**
     * Config constructor.
     * @param ValueHandlerPoolInterface $valueHandlerPool
     */
    public function __construct(
        ValueHandlerPoolInterface $valueHandlerPool
    ) {
        $this->valueHandlerPool = $valueHandlerPool;
    }

    /**
     * @return string
     */
    public function getGatewayUrl()
    {
        if ($this->isSandbox()) {
            return (string) $this->getValue('gateway_url_sandbox');
        }

        return (string) $this->getValue('gateway_url');
    }

    /**
     * @return bool
     */
    public function isSandbox()
    {
        return (bool) $this->getValue('is_sandbox');
    }

    /**
     * @return array
     */
    public function getGatewayHeaders()
    {
        return ['Content-Type' => 'application/json'];
    }

    /**
     * @return string
     */
    public function getApiLoginId()
    {
        return (string) $this->getValue('api_login_id');
    }

    /**
     * @return string
     */
    public function getTransactionKey()
    {
        return (string) $this->getValue('transaction_key');
    }

    /**
     * @param string $field
     * @return mixed|null
     */
    protected function getValue($field)
    {
        try {
            $handler = $this->valueHandlerPool->get($field);

            return $handler->handle(['field' => $field]);
        } catch (NotFoundException $exception) {
            return null;
        }
    }
}