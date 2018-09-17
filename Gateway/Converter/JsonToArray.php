<?php

namespace CodiLuck\Authorizenet\Gateway\Converter;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Payment\Gateway\Http\ConverterInterface;

/**
 * Class JsonToArray
 * @package CodiLuck\Authorizenet\Gateway\Converter
 */
class JsonToArray implements ConverterInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * JsonToArray constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @inheritdoc
     */
    public function convert($response)
    {
        // Fix for the Authorize.NET JSON response issue
        $response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response);
        return $this->serializer->unserialize($response);
    }
}