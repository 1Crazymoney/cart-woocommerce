<?php

namespace MercadoPago\Woocommerce\Configs;

use MercadoPago\Woocommerce\Helpers\Cache;
use MercadoPago\Woocommerce\Helpers\Requester;
use MercadoPago\Woocommerce\Hooks\Options;

if (!defined('ABSPATH')) {
    exit;
}

class Seller
{
    /**
     * @const
     */
    private const SITE_ID = '_site_id_v1';

    /**
     * @const
     */
    private const CLIENT_ID = '_mp_client_id';

    /**
     * @const
     */
    private const CREDENTIALS_PUBLIC_KEY_PROD = '_mp_public_key_prod';

    /**
     * @const
     */
    private const CREDENTIALS_PUBLIC_KEY_TEST = '_mp_public_key_test';

    /**
     * @const
     */
    private const CREDENTIALS_ACCESS_TOKEN_PROD = '_mp_access_token_prod';

    /**
     * @const
     */
    private const CREDENTIALS_ACCESS_TOKEN_TEST = '_mp_access_token_test';

    /**
     * @const
     */
    private const HOMOLOG_VALIDATE = 'homolog_validate';

    /**
     * @const
     */
    private const CHECKOUT_PAYMENT_METHODS = '_checkout_payments_methods';

    /**
     * @const
     */
    private const CHECKOUT_PAYMENT_METHOD_PIX = '_mp_payment_methods_pix';

    /**
     * @const
     */
    private const CHECKOUT_EXPIRATION_DATE_PIX = 'checkout_pix_date_expiration';

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var Options
     */
    private $options;

    /**
     * @var Requester
     */
    private $requester;

    /**
     * @var Store
     */
    private $store;

    /**
     * Credentials constructor
     */
    public function __construct(Cache $cache, Options $options, Requester $requester, Store $store)
    {
        $this->cache     = $cache;
        $this->options   = $options;
        $this->requester = $requester;
        $this->store     = $store;
    }

    /**
     * @return string
     */
    public function getSiteId(): string
    {
        return strtoupper($this->options->get(self::SITE_ID, ''));
    }

    /**
     * @param string $siteId
     */
    public function setSiteId(string $siteId): void
    {
        $this->options->set(self::SITE_ID, $siteId);
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->options->get(self::CLIENT_ID, '');
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId): void
    {
        $this->options->set(self::CLIENT_ID, $clientId);
    }

    /**
     * @return string
     */
    public function getCredentialsPublicKeyProd(): string
    {
        return $this->options->get(self::CREDENTIALS_PUBLIC_KEY_PROD, '');
    }

    /**
     * @param string $credentialsPublicKeyProd
     */
    public function setCredentialsPublicKeyProd(string $credentialsPublicKeyProd): void
    {
        $this->options->set(self::CREDENTIALS_PUBLIC_KEY_PROD, $credentialsPublicKeyProd);
    }

    /**
     * @return string
     */
    public function getCredentialsPublicKeyTest(): string
    {
        return $this->options->get(self::CREDENTIALS_PUBLIC_KEY_TEST, '');
    }

    /**
     * @param string $credentialsPublicKeyTest
     */
    public function setCredentialsPublicKeyTest(string $credentialsPublicKeyTest): void
    {
        $this->options->set(self::CREDENTIALS_PUBLIC_KEY_TEST, $credentialsPublicKeyTest);
    }

    /**
     * @return string
     */
    public function getCredentialsAccessTokenProd(): string
    {
        return $this->options->get(self::CREDENTIALS_ACCESS_TOKEN_PROD, '');
    }

    /**
     * @param string $credentialsAccessTokenProd
     */
    public function setCredentialsAccessTokenProd(string $credentialsAccessTokenProd): void
    {
        $this->options->set(self::CREDENTIALS_ACCESS_TOKEN_PROD, $credentialsAccessTokenProd);
    }

    /**
     * @return string
     */
    public function getCredentialsAccessTokenTest(): string
    {
        return $this->options->get(self::CREDENTIALS_ACCESS_TOKEN_TEST, '');
    }

    /**
     * @param string $credentialsAccessTokenTest
     */
    public function setCredentialsAccessTokenTest(string $credentialsAccessTokenTest): void
    {
        $this->options->set(self::CREDENTIALS_ACCESS_TOKEN_TEST, $credentialsAccessTokenTest);
    }

    /**
     * @return bool
     */
    public function getHomologValidate(): bool
    {
        return $this->options->get(self::HOMOLOG_VALIDATE, false);
    }

    /**
     * @param bool $homologValidate
     */
    public function setHomologValidate(bool $homologValidate): void
    {
        $this->options->set(self::HOMOLOG_VALIDATE, $homologValidate);
    }

    /**
     * @return bool
     */
    public function isTestMode(): bool
    {
        $checkboxCheckoutTestMode = $this->store->getCheckboxCheckoutTestMode();
        return ($checkboxCheckoutTestMode === 'yes');
    }

    /**
     * @return string
     */
    public function getCredentialsPublicKey(): string
    {
        if ($this->isTestMode()) {
            return $this->getCredentialsPublicKeyTest();
        }
        return $this->getCredentialsPublicKeyProd();
    }

    /**
     * @return string
     */
    public function getCredentialsAccessToken(): string
    {
        if ($this->isTestMode()) {
            return $this->getCredentialsAccessTokenTest();
        }
        return $this->getCredentialsAccessTokenProd();
    }

    /**
     * @return array
     */
    public function getCheckoutPaymentMethods(): array
    {
        return $this->options->get(self::CHECKOUT_PAYMENT_METHODS, '');
    }

    /**
     * @param array $checkoutPaymentMethods
     */
    public function setCheckoutPaymentMethods(array $checkoutPaymentMethods): void
    {
        $this->options->set(self::CHECKOUT_PAYMENT_METHODS, $checkoutPaymentMethods);
    }

    /**
     * @return array
     */
    public function getCheckoutPaymentMethodPix(): array
    {
        return $this->options->get(self::CHECKOUT_PAYMENT_METHOD_PIX, '');
    }

    /**
     * @param array $checkoutPaymentMethodsPix
     */
    public function setCheckoutPaymentMethodPix(array $checkoutPaymentMethodsPix): void
    {
        $this->options->set(self::CHECKOUT_PAYMENT_METHOD_PIX, $checkoutPaymentMethodsPix);
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getCheckoutDateExpirationPix(string $default): string
    {
        return $this->options->get(self::CHECKOUT_EXPIRATION_DATE_PIX, $default);
    }

    /**
     * @param array $checkoutExpirationDatePix
     */
    public function setCheckoutDateExpirationPix(array $checkoutExpirationDatePix): void
    {
        $this->options->set(self::CHECKOUT_EXPIRATION_DATE_PIX, $checkoutExpirationDatePix);
    }
    /**
     * Update Payment Methods
     *
     * @param string|null $publicKey
     * @param string|null $accessToken
     *
     */
    public function updatePaymentMethods(string $publicKey = null, string $accessToken = null): void
    {
        if (null === $publicKey) {
            //@TODO: validate if prod or test
            $publicKey = $this->getCredentialsPublicKey();
        }

        if (null === $accessToken) {
            //@TODO: validate if prod or test
            $accessToken = $this->getCredentialsAccessToken();
        }

        $excludedPaymentMethods = [
            'consumer_credits',
            'paypal',
            'account_money',
        ];

        $acceptedPaymentMethods = [
            'pix' => 'setCheckoutPaymentMethodPix',
        ];

        $paymentMethodsResponse = $this->getPaymentMethods($publicKey, $accessToken);

        if (empty($paymentMethodsResponse) || 200 !== $paymentMethodsResponse['status']) {
            $this->setCheckoutPaymentMethods([]);
            return;
        }

        $serializedPaymentMethods   = [];
        $serializedPaymentMethodPix = [];
        foreach ($paymentMethodsResponse['data'] as $paymentMethod) {
            if (in_array($paymentMethod['id'], $excludedPaymentMethods, true)) {
                continue;
            }

            $serializedPaymentMethods[] = [
                'id'     => $paymentMethod['id'],
                'name'   => $paymentMethod['name'],
                'type'   => $paymentMethod['payment_type_id'],
                'image'  => $paymentMethod['secure_thumbnail'],
                'config' => 'ex_payments_' . $paymentMethod['id'],
            ];

            if (in_array($paymentMethod['id'], $acceptedPaymentMethods, true)) {
                $serializedPaymentMethodPix[$paymentMethod['id']] = $serializedPaymentMethods;
                $this->{$acceptedPaymentMethods[$paymentMethod['id']]}($serializedPaymentMethodPix, true);
            }
        }

        $this->setCheckoutPaymentMethods($serializedPaymentMethods);
    }

    /**
     * Get seller info with users credentials
     *
     * @param string $accessToken
     *
     * @return array
     */
    public function getSellerInfo(string $accessToken): array
    {
        try {
            $key   = sprintf('%sat%s', __FUNCTION__, $accessToken);
            $cache = $this->cache->getCache($key);

            if ($cache) {
                return $cache;
            }

            $uri     = '/users/me';
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

    /**
     * @param string $publicKey
     *
     * @return array
     */
    public function validatePublicKey(string $publicKey): array
    {
        return $this->validateCredentials(null, $publicKey);
    }

    /**
     * @param string $accessToken
     *
     * @return array
     */
    public function validateAccessToken(string $accessToken): array
    {
        return $this->validateCredentials($accessToken);
    }

    /**
     * Validate credentials with plugins wrapper credentials API
     *
     * @param string|null $accessToken
     * @param string|null $publicKey
     *
     * @return array
     */
    private function validateCredentials(string $accessToken = null, string $publicKey = null): array
    {
        try {
            $key   = sprintf('%sat%spk%s', __FUNCTION__, $accessToken, $publicKey);
            $cache = $this->cache->getCache($key);

            if ($cache) {
                return $cache;
            }

            $headers = [];
            $uri     = '/plugins-credentials-wrapper/credentials';

            if ($accessToken && !$publicKey) {
                $headers[] = 'Authorization: Bearer ' . $accessToken;
            }

            if ($publicKey && !$accessToken) {
                $uri = $uri . '?public_key=' . $publicKey;
            }

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

    /**
     * Get Payment Methods
     *
     * @param string|null $publicKey
     * @param string|null $accessToken
     *
     * @return array
     */
    private function getPaymentMethods(string $publicKey = null, string $accessToken = null): array
    {
        try {
            $key   = sprintf('%sat%spk%s', __FUNCTION__, $accessToken, $publicKey);
            $cache = $this->cache->getCache($key);

            if ($cache) {
                return $cache;
            }

            $headers = [];
            $uri     = '/v1/payment_methods';

            if ($accessToken) {
                $headers[] = 'Authorization: Bearer ' . $accessToken;
            }

            if ($publicKey) {
                $uri = $uri . '?public_key=' . $publicKey;
            }

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
