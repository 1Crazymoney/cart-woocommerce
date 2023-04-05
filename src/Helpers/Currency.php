<?php

namespace MercadoPago\Woocommerce\Helpers;

use MercadoPago\Woocommerce\Configs\Seller;
use MercadoPago\Woocommerce\Gateways\AbstractGateway;
use MercadoPago\Woocommerce\Hooks\Options;
use MercadoPago\Woocommerce\Logs\Logs;
use MercadoPago\Woocommerce\Helpers\Notices;
use MercadoPago\Woocommerce\Translations\AdminTranslations;

if (!defined('ABSPATH')) {
    exit;
}

final class Currency
{
    /**
     * @const
     */
    private const CURRENCY_CONVERSION = 'currency_conversion';

    /**
     * @const
     */
    private const DEFAULT_RATIO = 1;

    /**
     * @var array
     */
    private $ratios = [];

    /**
     * @var bool
     */
    private $isShowingEnabledNotice = false;

    /**
     * @var bool
     */
    private $isShowingDisabledNotice = false;

    /**
     * @var array
     */
    private $translations;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var Logs
     */
    private $logs;

    /**
     * @var Notices
     */
    private $notices;

    /**
     * @var Requester
     */
    private $requester;

    /**
     * @var Seller
     */
    private $seller;

    /**
     * @var Options
     */
    private $options;

    /**
     * @var Url
     */
    private $url;

    /**
     * Currency constructor
     *
     * @param AdminTranslations $adminTranslations
     * @param Cache             $cache
     * @param Country           $country
     * @param Logs              $logs
     * @param Notices           $notices
     * @param Requester         $requester
     * @param Seller            $seller
     * @param Options           $options
     * @param Url               $url
     */
    public function __construct(
        AdminTranslations $adminTranslations,
        Cache             $cache,
        Country           $country,
        Logs              $logs,
        Notices           $notices,
        Requester         $requester,
        Seller            $seller,
        Options           $options,
        Url               $url
    ) {
        $this->translations = $adminTranslations->currency;
        $this->cache        = $cache;
        $this->country      = $country;
        $this->logs         = $logs;
        $this->notices      = $notices;
        $this->requester    = $requester;
        $this->seller       = $seller;
        $this->options      = $options;
        $this->url          = $url;
    }

    /**
     * Get ratio incrementing the ratios array by gateway
     *
     * @param AbstractGateway $gateway
     *
     * @return float
     */
    public function getRatio(AbstractGateway $gateway): float
    {
        if (!isset($this->ratios[$gateway->id])) {
            if ($this->isEnabled($gateway) && $this->validateConversion()) {
                $ratio = $this->loadRatio();
                $this->setRatio($gateway->id, $ratio);
            } else {
                $this->setRatio($gateway->id);
            }
        }

        return $this->ratios[$gateway->id] ?: self::DEFAULT_RATIO;
    }

    /**
     * Set ratio
     *
     * @param string $gatewayId
     * @param float $value
     *
     * @return void
     */
    public function setRatio(string $gatewayId, $value = self::DEFAULT_RATIO)
    {
        $this->ratios[$gatewayId] = $value;
    }

    /**
     * Get Woocommerce currency
     *
     * @return string
     */
    public function getWoocommerceCurrency(): string
    {
        return get_woocommerce_currency();
    }

    /**
     * Get Account currency
     *
     * @return string
     */
    public function getAccountCurrency(): string
    {
        return $this->country->getCountryConfigs()['currency'];
    }

    /**
     * Verify if currency option is enabled
     *
     * @param AbstractGateway $gateway
     *
     * @return bool
     */
    public function isEnabled(AbstractGateway $gateway): bool
    {
        return $this->options->getGatewayOption($gateway, self::CURRENCY_CONVERSION) === 'yes';
    }

    /**
     * Validate if account currency is equal to woocommerce currency
     *
     * @return bool
     */
    public function validateConversion(): bool
    {
        return $this->getAccountCurrency() === $this->getWoocommerceCurrency();
    }

    /**
     * Handle currency conversion notices
     *
     * @param AbstractGateway $gateway
     *
     * @return void
     */
    public function handleCurrencyNotices(AbstractGateway $gateway): void
    {
        $toCurrency   = $this->getAccountCurrency();
        $fromCurrency = $this->getWoocommerceCurrency();

        $currencyEnabledTranslation = sprintf(
            '%s %s %s %s.',
            $this->translations['currency_enabled']['start'],
            $fromCurrency,
            $this->translations['currency_enabled']['final'],
            $toCurrency
        );

        $currencyDisabledTranslation = sprintf(
            '%s %s %s %s.',
            $this->translations['currency_disabled']['start'],
            $fromCurrency,
            $this->translations['currency_disabled']['final'],
            $toCurrency
        );

        if ($this->validateConversion() || !$this->url->validateSection($gateway->id)) {
            return;
        }

        if ($this->isShowingEnabledNotice || $this->isShowingDisabledNotice) {
            return;
        }

        if ($this->isEnabled($gateway)) {
            $this->isShowingEnabledNotice = true;
            $this->notices->adminNoticeInfo($currencyEnabledTranslation, false);
            return;
        }

        $this->isShowingDisabledNotice = true;
        $this->notices->adminNoticeWarning($currencyDisabledTranslation, false);
        $this->notices->adminNoticeWarning($this->translations['currency_conversion'], false);
    }

    /**
     * Load ratio
     *
     * @return float
     */
    private function loadRatio(): float
    {
        $response = $this->getCurrencyConversion();

        try {
            if ($response['status'] !== 200 ) {
                throw new \Exception(json_encode($response['data']));
            }

            if (isset($response['data']['ratio']) && $response['data']['ratio'] > 0) {
                return $response['data']['ratio'];
            }
        } catch (\Exception $e) {
            $this->logs->file->error("'Mercado pago gave error to get currency value: {$e->getMessage()}",
                __CLASS__
            );
        }

        return self::DEFAULT_RATIO;
    }

    /**
     * Get currency conversion
     *
     * @return array
     */
    private function getCurrencyConversion(): array
    {
        $toCurrency   = $this->getAccountCurrency();
        $fromCurrency = $this->getWoocommerceCurrency();
        $accessToken  = $this->seller->getCredentialsAccessToken();

        try {
            $key   = sprintf('%sat%s-%sto%s', __FUNCTION__, $accessToken, $fromCurrency, $toCurrency);
            $cache = $this->cache->getCache($key);

            if ($cache) {
                return $cache;
            }

            $uri     = sprintf('/currency_conversions/search?from=%s&to=%s', $fromCurrency, $toCurrency);
            $headers = ['Authorization: Bearer ' . $accessToken];

            $response           = $this->requester->get($uri, $headers);
            $serializedResponse = [
                'data'   => $response->getData(),
                'status' => $response->getStatus(),
            ];

            $this->cache->setCache($key, $serializedResponse);

            return $serializedResponse;
        } catch (\Exception $e) {
            return [
                'data'   => null,
                'status' => 500,
            ];
        }
    }
}
