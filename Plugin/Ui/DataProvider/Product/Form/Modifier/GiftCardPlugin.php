<?php

namespace Cyclad\GiftCardFixOpenAmount\Plugin\Ui\DataProvider\Product\Form\Modifier;

use Magento\GiftCard\Ui\DataProvider\Product\Form\Modifier\GiftCard;
use Magento\Framework\Stdlib\ArrayManager;

class GiftCardPlugin
{
    const PRICE_FIELDS = [
        GiftCard::FIELD_OPEN_AMOUNT_MIN,
        GiftCard::FIELD_OPEN_AMOUNT_MAX
    ];

    /**
     * @var ArrayManager
     */
    private $arrayManager;

    public function __construct(ArrayManager $arrayManager)
    {
        $this->arrayManager = $arrayManager;
    }

    public function afterModifyMeta(GiftCard $giftCardFormModifier, $meta)
    {
        foreach (static::PRICE_FIELDS as $priceField) {
            $fieldPath = $this->arrayManager->findPath($priceField, $meta, null, 'children');

            $meta = $this->arrayManager->merge(
                $fieldPath . GiftCard::META_CONFIG_PATH,
                $meta,
                [
                    'validation' => [
                        'validate-number' => false
                    ]
                ]
            );
        }

        return $meta;
    }
}