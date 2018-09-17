<?php

namespace CodiLuck\Authorizenet\Gateway\Http;

use Magento\Framework\HTTP\ZendClient;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Payment\Gateway\Http\ClientException;
use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\ConverterException;
use Magento\Payment\Gateway\Http\ConverterInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;

/**
 * Class Client
 * @package CodiLuck\Authorizenet\Gateway\Http
 */
class Client implements ClientInterface
{
    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    private $clientFactory;

    /**
     * @var \Magento\Payment\Gateway\Http\ConverterInterface
     */
    private $converter;

    /**
     * @var \Magento\Payment\Model\Method\Logger
     */
    private $logger;

    /**
     * Client constructor.
     * @param ZendClientFactory $clientFactory
     * @param Logger $logger
     * @param ConverterInterface|null $converter
     */
    public function __construct(
        ZendClientFactory $clientFactory,
        Logger $logger,
        ConverterInterface $converter = null
    ) {
        $this->clientFactory = $clientFactory;
        $this->logger = $logger;
        $this->converter = $converter;
    }

    /**
     * @param \Magento\Payment\Gateway\Http\TransferInterface $transferObject
     * @return array
     * @throws ClientException
     * @throws ConverterException
     */
    public function placeRequest(TransferInterface $transferObject)
    {
        $log = [
            'request_uri' => $transferObject->getUri(),
            'request_body' => $this->converter
                ? $this->converter->convert($transferObject->getBody())
                : $transferObject->getBody()
        ];

        /** @var ZendClient $client */
        $client = $this->clientFactory->create();

        $result = [];
        try {
            $client->setConfig($transferObject->getClientConfig());
            $client->setMethod($transferObject->getMethod());
            $client->setRawData($transferObject->getBody(), 'application/json');
            $client->setHeaders($transferObject->getHeaders());
            $client->setUrlEncodeBody($transferObject->shouldEncode());
            $client->setUri($transferObject->getUri());

            $response = $client->request();

            $result = $this->converter
                ? $this->converter->convert($response->getBody())
                : [$response->getBody()];

            $log['response'] = $result;
        } catch (\Zend_Http_Client_Exception $exception) {
            throw new ClientException(__($exception->getMessage()));
        } catch (ConverterException $exception) {
            throw $exception;
        } finally {
            $this->logger->debug($log);
        }

        return $result;
    }
}