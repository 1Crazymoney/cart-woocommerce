<?php

namespace MercadoPago\Woocommerce\Transactions;

use MercadoPago\Woocommerce\Gateways\AbstractGateway;

class WalletButtonTransaction extends AbstractPreferenceTransaction
{
    /**
     * @const
     */
    public const ID = 'wallet_button';

    /**
     * Wallet Button Transaction constructor
     *
     * @param AbstractGateway $gateway
     * @param \WC_Order $order
     */
    public function __construct(AbstractGateway $gateway, \WC_Order $order)
    {
        parent::__construct($gateway, $order);

        $this->transaction->purpose = 'wallet_purchase';
    }

    /**
     * Get internal metadata
     *
     * @return array
     */
    public function getInternalMetadata(): array
    {
        $internalMetadata = parent::getInternalMetadata();

        $internalMetadata['checkout']               = 'pro';
        $internalMetadata['checkout_type']          = self::ID;

        return $internalMetadata;
    }
}
