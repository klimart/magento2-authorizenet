<?php

namespace CodiLuck\Authorizenet\Gateway\Converter;

use Magento\Payment\Gateway\Http\ConverterInterface;

/**
 * Class Converter
 * @package CodiLuck\Authorizenet\Gateway\Converter
 */
class Converter
{
    /**
     * @var ConverterInterface
     */
    protected $converter;

    /**
     * Converter constructor.
     * @param ConverterInterface $converter
     */
    public function __construct(
        ConverterInterface $converter
    ) {
        $this->converter = $converter;
    }

    /**
     * @param array $request
     * @return array|string
     */
    public function convert(array $request)
    {
        return $this->converter->convert($request);
    }

}