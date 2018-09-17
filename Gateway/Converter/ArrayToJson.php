<?php

namespace CodiLuck\Authorizenet\Gateway\Converter;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Payment\Gateway\Http\ConverterInterface;

/**
 * Class ArrayToJson
 * @package CodiLuck\Authorizenet\Gateway\Converter
 */
class ArrayToJson implements ConverterInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * ArrayToJson constructor.
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
        return $this->serializer->serialize($response);
    }

}