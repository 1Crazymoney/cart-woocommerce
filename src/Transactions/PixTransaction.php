<?php

namespace MercadoPago\Woocommerce\Transactions;

use MercadoPago\Woocommerce\Gateways\AbstractGateway;
use MercadoPago\Woocommerce\Helpers\Date;

class PixTransaction extends AbstractPaymentTransaction
{
    /**
     * @const
     */
    public const ID = 'pix';

    /**
     * Pix Transaction constructor
     *
     * @param AbstractGateway $gateway
     * @param \WC_Order $order
     * @param array $checkout
     */
    public function __construct(AbstractGateway $gateway, \WC_Order $order, array $checkout)
    {
        parent::__construct($gateway, $order, $checkout);

        $this->transaction->payment_method_id          = self::ID;
        $this->transaction->date_of_expiration         = $this->getExpirationDate();
        $this->transaction->point_of_interaction->type = 'CHECKOUT';
    }

    /**
     * Get internal metadata
     *
     * @return array
     */
    public function getInternalMetadata(): array
    {
        $internalMetadata = parent::getInternalMetadata();

        $internalMetadata['checkout']      = 'custom';
        $internalMetadata['checkout_type'] = self::ID;

        return $internalMetadata;
    }

    /**
     * Get expiration date
     */
    public function getExpirationDate(): string
    {
        $expirationDate = $this->mercadopago->store->getCheckoutDateExpirationPix($this->gateway, '');

        if (strlen($expirationDate) === 1 && $expirationDate === '1') {
            $expirationDate = '24 hours';
            $this->mercadopago->options->setGatewayOption($this->gateway, 'checkout_pix_date_expiration', $expirationDate);
        } elseif (strlen($expirationDate) === 1) {
            $expirationDate = $expirationDate . ' days';
            $this->mercadopago->options->setGatewayOption($this->gateway, 'checkout_pix_date_expiration', $expirationDate);
        }

        return Date::sumToNowDate($expirationDate);
    }
}
