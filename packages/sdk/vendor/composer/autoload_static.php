<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit69030f4226ac514a36577157b0ae6eda
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MercadoPago\\PP\\Sdk\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MercadoPago\\PP\\Sdk\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'MercadoPago\\PP\\Sdk\\Common\\AbstractCollection' => __DIR__ . '/../..' . '/src/Common/AbstractCollection.php',
        'MercadoPago\\PP\\Sdk\\Common\\AbstractEntity' => __DIR__ . '/../..' . '/src/Common/AbstractEntity.php',
        'MercadoPago\\PP\\Sdk\\Common\\Config' => __DIR__ . '/../..' . '/src/Common/Config.php',
        'MercadoPago\\PP\\Sdk\\Common\\Constants' => __DIR__ . '/../..' . '/src/Common/Constants.php',
        'MercadoPago\\PP\\Sdk\\Common\\Manager' => __DIR__ . '/../..' . '/src/Common/Manager.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Notification\\Notification' => __DIR__ . '/../..' . '/src/Entity/Notification/Notification.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Notification\\PaymentDetails' => __DIR__ . '/../..' . '/src/Entity/Notification/PaymentDetails.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Notification\\PaymentDetailsList' => __DIR__ . '/../..' . '/src/Entity/Notification/PaymentDetailsList.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Notification\\Refund' => __DIR__ . '/../..' . '/src/Entity/Notification/Refund.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Notification\\RefundList' => __DIR__ . '/../..' . '/src/Entity/Notification/RefundList.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\AdditionalInfo' => __DIR__ . '/../..' . '/src/Entity/Payment/AdditionalInfo.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\AdditionalInfoPayer' => __DIR__ . '/../..' . '/src/Entity/Payment/AdditionalInfoPayer.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\AdditionalInfoPayerAddress' => __DIR__ . '/../..' . '/src/Entity/Payment/AdditionalInfoPayerAddress.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Address' => __DIR__ . '/../..' . '/src/Entity/Payment/Address.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Item' => __DIR__ . '/../..' . '/src/Entity/Payment/Item.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\ItemList' => __DIR__ . '/../..' . '/src/Entity/Payment/ItemList.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Payer' => __DIR__ . '/../..' . '/src/Entity/Payment/Payer.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\PayerIdentification' => __DIR__ . '/../..' . '/src/Entity/Payment/PayerIdentification.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Payment' => __DIR__ . '/../..' . '/src/Entity/Payment/Payment.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Phone' => __DIR__ . '/../..' . '/src/Entity/Payment/Phone.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\PointOfInteraction' => __DIR__ . '/../..' . '/src/Entity/Payment/PointOfInteraction.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\ReceiverAddress' => __DIR__ . '/../..' . '/src/Entity/Payment/ReceiverAddress.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\Shipments' => __DIR__ . '/../..' . '/src/Entity/Payment/Shipments.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Payment\\TransactionDetails' => __DIR__ . '/../..' . '/src/Entity/Payment/TransactionDetails.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Address' => __DIR__ . '/../..' . '/src/Entity/Preference/Address.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\BackUrl' => __DIR__ . '/../..' . '/src/Entity/Preference/BackUrl.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\DifferentialPricing' => __DIR__ . '/../..' . '/src/Entity/Preference/DifferentialPricing.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentMethod' => __DIR__ . '/../..' . '/src/Entity/Preference/ExcludedPaymentMethod.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentMethodList' => __DIR__ . '/../..' . '/src/Entity/Preference/ExcludedPaymentMethodList.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentType' => __DIR__ . '/../..' . '/src/Entity/Preference/ExcludedPaymentType.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ExcludedPaymentTypeList' => __DIR__ . '/../..' . '/src/Entity/Preference/ExcludedPaymentTypeList.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\FreeMethod' => __DIR__ . '/../..' . '/src/Entity/Preference/FreeMethod.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\FreeMethodList' => __DIR__ . '/../..' . '/src/Entity/Preference/FreeMethodList.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Item' => __DIR__ . '/../..' . '/src/Entity/Preference/Item.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ItemList' => __DIR__ . '/../..' . '/src/Entity/Preference/ItemList.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Payer' => __DIR__ . '/../..' . '/src/Entity/Preference/Payer.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\PayerIdentification' => __DIR__ . '/../..' . '/src/Entity/Preference/PayerIdentification.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\PaymentMethod' => __DIR__ . '/../..' . '/src/Entity/Preference/PaymentMethod.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Phone' => __DIR__ . '/../..' . '/src/Entity/Preference/Phone.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Preference' => __DIR__ . '/../..' . '/src/Entity/Preference/Preference.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\ReceiverAddress' => __DIR__ . '/../..' . '/src/Entity/Preference/ReceiverAddress.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Shipment' => __DIR__ . '/../..' . '/src/Entity/Preference/Shipment.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\Track' => __DIR__ . '/../..' . '/src/Entity/Preference/Track.php',
        'MercadoPago\\PP\\Sdk\\Entity\\Preference\\TrackList' => __DIR__ . '/../..' . '/src/Entity/Preference/TrackList.php',
        'MercadoPago\\PP\\Sdk\\HttpClient\\HttpClient' => __DIR__ . '/../..' . '/src/HttpClient/HttpClient.php',
        'MercadoPago\\PP\\Sdk\\HttpClient\\HttpClientInterface' => __DIR__ . '/../..' . '/src/HttpClient/HttpClientInterface.php',
        'MercadoPago\\PP\\Sdk\\HttpClient\\Requester\\CurlRequester' => __DIR__ . '/../..' . '/src/HttpClient/Requester/CurlRequester.php',
        'MercadoPago\\PP\\Sdk\\HttpClient\\Requester\\RequesterInterface' => __DIR__ . '/../..' . '/src/HttpClient/Requester/RequesterInterface.php',
        'MercadoPago\\PP\\Sdk\\HttpClient\\Response' => __DIR__ . '/../..' . '/src/HttpClient/Response.php',
        'MercadoPago\\PP\\Sdk\\Sdk' => __DIR__ . '/../..' . '/src/Sdk.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit69030f4226ac514a36577157b0ae6eda::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit69030f4226ac514a36577157b0ae6eda::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit69030f4226ac514a36577157b0ae6eda::$classMap;

        }, null, ClassLoader::class);
    }
}
