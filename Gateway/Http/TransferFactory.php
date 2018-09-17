<?php

namespace CodiLuck\Authorizenet\Gateway\Http;

use CodiLuck\Authorizenet\Gateway\Config;
use CodiLuck\Authorizenet\Gateway\Converter\Converter;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;

/**
 * Class TransferFactory
 * @package CodiLuck\Authorizenet\Gateway\Http
 */
class TransferFactory implements TransferFactoryInterface
{
    /**
     * @var TransferBuilder
     */
    protected $transferBuilder;

    /**
     * @var Converter
     */
    protected $converter;

    /**
     * @var Config
     */
    protected $config;

    /**
     * TransferFactory constructor.
     * @param TransferBuilder $transferBuilder
     * @param Converter $converter
     * @param Config $config
     */
    public function __construct(
        TransferBuilder $transferBuilder,
        Converter $converter,
        Config $config
    ) {
        $this->transferBuilder = $transferBuilder;
        $this->converter = $converter;
        $this->config = $config;
    }

    /**
     * @param array $request
     * @return TransferInterface
     */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setUri($this->config->getGatewayUrl())
            ->setMethod('POST')
            ->setBody($this->converter->convert($request))
            ->setHeaders($this->config->getGatewayHeaders())
            ->build();
    }
}