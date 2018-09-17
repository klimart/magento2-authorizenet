<?php
namespace CodiLuck\Authorizenet\Gateway\Request;

use CodiLuck\Authorizenet\Gateway\Config;
use Magento\Payment\Gateway\Request\BuilderInterface;

/**
 * Class RequestBuilder
 * @package CodiLuck\Authorizenet\Gateway\Request
 */
class RequestBuilder implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    protected $builderComposite;

    /**
     * @var Config
     */
    protected $config;

    /**
     * RequestBuilder constructor.
     * @param BuilderInterface $builder
     * @param Config $config
     */
    public function __construct(
        BuilderInterface $builder,
        Config $config
    ) {
        $this->builderComposite = $builder;
        $this->config = $config;
    }

    /**
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject)
    {
        return [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name' => $this->config->getApiLoginId(),
                    'transactionKey' => $this->config->getTransactionKey()
                ],
                'transactionRequest' => $this->builderComposite->build($buildSubject)
            ],
        ];
    }
}