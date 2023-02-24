<?php

namespace MercadoPago\Woocommerce\Gateways;

use MercadoPago\Woocommerce\WoocommerceMercadoPago;
use MercadoPago\Woocommerce\Interfaces\MercadoPagoGatewayInterface;
use MercadoPago\Woocommerce\Notification\CoreNotification;
use MercadoPago\Woocommerce\Notification\NotificationFactory;

abstract class AbstractGateway extends \WC_Payment_Gateway implements MercadoPagoGatewayInterface
{

    /**
     * @const
     */
    public const CHECKOUT_NAME = 'checkout-basic';

    /**
     * @var WoocommerceMercadoPago
     */
    protected $mercadopago;

    /**
     * Commission
     *
     * @var int
     */
    public $commission;

    /**
     * Discount
     *
     * @var int
     */
    public $discount;

    /**
     * Expiration date
     *
     * @var int
     */
    public $expirationDate;

    /**
     * Checkout country
     *
     * @var string
     */
    public $checkoutCountry;

    /**
     * Translations
     *
     * @var array
     */
    protected $adminTranslations;

    /**
     * Translations
     *
     * @var array
     */
    protected $storeTranslations;

    /**
     * Abstract Gateway constructor
     */
    public function __construct()
    {
        global $mercadopago;
        $this->mercadopago       = $mercadopago;

        $this->discount          = $this->getActionableValue('discount', 0);
        $this->commission        = $this->getActionableValue('commission', 0);
        $this->checkoutCountry   = $this->mercadopago->store->getCheckoutCountry();
        $this->has_fields        = true;
        $this->supports          = ['products', 'refunds'];

        $this->loadResearchComponent();
    }

    /**
     * Render gateway checkout template
     * 
     * @return void
     */
    public function payment_fields(): void
    {
        return;
    }

    /**
     * Validate gateway checkout form fields
     * 
     * @return bool
     */
    public function validate_fields(): bool
    {
        return true;
    }

    /**
     * Process payment and create woocommerce order
     *
     * @param int $order_id
     *
     * @return array
     */
    public function process_payment($order_id): array
    {
        return [];
    }

    /**
     * Verify if the gateway is available
     *
     * @return bool
     */
    public static function isAvailable(): bool
    {
        return true;
    }

    /**
     * Init form fields for checkout configuration
     *
     * @return void
     */
    public function init_form_fields(): void
    {
        $this->form_fields = [
            'card_info_validate' => [
                'type'  => 'mp_card_info',
                'value' => [
                    'title'       => $this->mercadopago->adminTranslations->credentialsSettings['card_info_title'],
                    'subtitle'    => $this->mercadopago->adminTranslations->credentialsSettings['card_info_subtitle'],
                    'button_text' => $this->mercadopago->adminTranslations->credentialsSettings['card_info_button_text'],
                    'button_url'  => $this->mercadopago->links->getLinks()['admin_settings_page'],
                    'icon'        => 'mp-icon-badge-warning',
                    'color_card'  => 'mp-alert-color-error',
                    'size_card'   => 'mp-card-body-size',
                    'target'      => '_self',
                ]
            ]
        ];
    }

    /**
     * Get checkout name
     *
     * @return string
     */
    public function getCheckoutName(): string
    {
        return self::CHECKOUT_NAME;
    }

    /**
     * Added gateway scripts
     *
     * @param string $gatewaySection
     *
     * @return void
     */
    public function payment_scripts(string $gatewaySection): void
    {
        if ($this->canLoadScriptsAndStyles($gatewaySection)) {
            $this->mercadopago->scripts->registerAdminScript(
                'wc_mercadopago_admin_components',
                $this->mercadopago->url->getPluginFileUrl('assets/js/admin/mp-admin-configs', '.js')
            );

            $this->mercadopago->scripts->registerAdminStyle(
                'wc_mercadopago_admin_components',
                $this->mercadopago->url->getPluginFileUrl('assets/css/admin/mp-admin-configs', '.css')
            );
        }

        $this->mercadopago->scripts->registerStoreScript(
            'wc_mercadopago_checkout_components',
            $this->mercadopago->url->getPluginFileUrl('assets/js/checkouts/mp-plugins-components', '.js')
        );

        $this->mercadopago->scripts->registerStoreStyle(
            'wc_mercadopago_checkout_components',
            $this->mercadopago->url->getPluginFileUrl('assets/css/checkouts/mp-plugins-components', '.css')
        );
    }

    /**
     * Check if scripts and styles can be loaded
     *
     * @param string $gatewaySection
     *
     * @return bool
     */
    public function canLoadScriptsAndStyles(string $gatewaySection): bool
    {
        return $this->mercadopago->admin->isAdmin() && (
            $this->mercadopago->url->validatePage('wc-settings') &&
            $this->mercadopago->url->validateSection($gatewaySection)
        );
    }

    /**
     * Generate custom toggle switch component
     *
     * @param string $key
     * @param array $settings
     *
     * @return string
     */
    public function generate_mp_toggle_switch_html(string $key, array $settings): string
    {
        return $this->mercadopago->template->getWoocommerceTemplateHtml(
            'admin/components/toggle-switch.php',
            [
                'field_key'   => $this->get_field_key($key),
                'field_value' => $this->getOption($key, $settings['default']),
                'settings'    => $settings,
            ]
        );
    }

    /**
     * Generate custom toggle switch component
     *
     * @param string $key
     * @param array  $settings
     *
     * @return string
     */
    public function generate_mp_checkbox_list_html(string $key, array $settings): string
    {
        return $this->mercadopago->template->getWoocommerceTemplateHtml(
            'admin/components/checkbox-list.php',
            [
                'settings'    => $settings,
            ]
        );
    }

    /**
     * Generate custom header component
     *
     * @param string $key
     * @param array $settings
     *
     * @return string
     */
    public function generate_mp_config_title_html(string $key, array $settings): string
    {
        return $this->mercadopago->template->getWoocommerceTemplateHtml(
            'admin/components/config-title.php',
            [
                'field_key'   => $this->get_field_key($key),
                'field_value' => null,
                'settings'    => $settings,
            ]
        );
    }

    /**
     * Generating custom actionable input component
     *
     * @param string $key
     * @param array $settings
     *
     * @return string
     */
    public function generate_mp_actionable_input_html(string $key, array $settings): string
    {
        return $this->mercadopago->template->getWoocommerceTemplateHtml(
            'admin/components/actionable-input.php',
            [
                'field_key'          => $this->get_field_key($key),
                'field_key_checkbox' => $this->get_field_key($key . '_checkbox'),
                'field_value'        => $this->getOption($key),
                'enabled'            => $this->getOption($key . '_checkbox'),
                'custom_attributes'  => $this->get_custom_attribute_html($settings),
                'settings'           => $settings,
            ]
        );
    }

    /**
     * Generating custom card info component
     *
     * @param string $key
     * @param array $settings
     *
     * @return string
     */
    public function generate_mp_card_info_html(string $key, array $settings): string
    {
        return $this->mercadopago->template->getWoocommerceTemplateHtml(
            'admin/components/card-info.php',
            [
                'field_key'   => $this->get_field_key($key),
                'field_value' => null,
                'settings'    => $settings,
            ]
        );
    }

    /**
     * Generating custom preview component
     *
     * @param string $key
     * @param array $settings
     *
     * @return string
     */
    public function generate_mp_preview_html(string $key, array $settings): string
    {
        return $this->mercadopago->template->getWoocommerceTemplateHtml(
            'admin/components/preview.php',
            [
                'field_key'   => $this->get_field_key($key),
                'field_value' => null,
                'settings'    => $settings,
            ]
        );
    }
    /**
     * Load research component
     *
     * @return void
     */
    public function loadResearchComponent(): void
    {
        $this->mercadopago->gateway->registerAfterSettingsCheckout(
            'admin/components/research-fields.php',
            [
                [
                    'field_key'   => 'mp-public-key-prod',
                    'field_value' => $this->mercadopago->seller->getCredentialsPublicKey(),
                ],
                [
                    'field_key'   => 'reference',
                    'field_value' => '{"mp-screen-name":"' . $this->getCheckoutName() . '"}',
                ]
            ]
        );
    }

    /**
     * Get actionable component value
     *
     * @return mixed|string
     */
    public function getActionableValue($optionName, $default)
    {
        $active = $this->getOption("{$optionName}_checkbox", false);

        return $active ? $this->getOption($optionName, $default) : $default;
    }

    /**
     * Get option
     * 
     * @param optionName
     * @param default
     *
     * @return string
     */
    public function getOption($optionName, $default = ''): string
    {
        return $this->get_option($optionName, $default);
    }

    /**
     * Receive gateway webhook notifications
     *
     * @return void
     */
    public function webhook(): void
    {
        $data  = $_GET;
        $topic = $data['topic'];
        $type  = $data['type'];
        
        $notificationFactory = new NotificationFactory($this->mercadopago->logs);
        $notificationHandler = $notificationFactory->createNotificationHandler($topic, $type);

        $notificationHandler->handleReceivedNotification();
    }
}
