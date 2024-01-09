/* globals wc_mercadopago_basic_blocks_params */

import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import { getSetting } from '@woocommerce/settings';
import { useEffect } from '@wordpress/element';
import { decodeEntities } from '@wordpress/html-entities';
import { addDiscountAndCommission, removeDiscountAndCommission } from './helpers/cart-update.helper';

import CheckoutBenefits from './components/CheckoutBenefits';
import ChoRedirectV2 from './components/ChoRedirectV2';
import PaymentMethodsV2 from './components/PaymentMethodsV2';
import TermsAndConditions from './components/TermsAndConditions';
import TestMode from './components/TestMode';

const targetName = "mp_checkout_blocks_basic";
const paymentMethodName = 'woo-mercado-pago-basic';

const settings = getSetting(`woo-mercado-pago-basic_data`, {});
const defaultLabel = decodeEntities(settings.title) || 'Checkout Pro';

const updateCart = (props) => {
  const { extensionCartUpdate } = wc.blocksCheckout;
  const { eventRegistration, emitResponse } = props;
  const { onPaymentSetup, onCheckoutSuccess, onCheckoutFail } = eventRegistration;

  useEffect(() => {
    addDiscountAndCommission(extensionCartUpdate, paymentMethodName);

    const unsubscribe = onPaymentSetup(() => {
      return { type: emitResponse.responseTypes.SUCCESS };
    });

    return () => {
      removeDiscountAndCommission(extensionCartUpdate, paymentMethodName);
      return unsubscribe();
    };
  }, [onPaymentSetup]);

  useEffect(() => {
    
    onCheckoutSuccess(async (checkoutResponse) => {
      const paymentDetails = checkoutResponse.processingResponse.paymentDetails;
      sendMetric("MP_BASIC_BLOCKS_SUCCESS", paymentDetails, targetName)
      return { type: emitResponse.responseTypes.SUCCESS };
    });

  }, [onCheckoutSuccess]);
    
  useEffect(() => {
    const unsubscribe = onCheckoutFail(checkoutResponse => {
      sendMetric("MP_BASIC_BLOCKS_ERROR", paymentDetails.message, targetName)
      const paymentDetails = checkoutResponse.processingResponse.paymentDetails;
      return {
        type: emitResponse.responseTypes.FAIL,
        message: paymentDetails.message,
        messageContext: emitResponse.noticeContexts.PAYMENTS,
      };
    });

    return () => unsubscribe();
  }, [onCheckoutFail]);

};

const Label = (props) => {
  const { PaymentMethodLabel } = props.components;

  const feeTitle = decodeEntities(settings?.params?.fee_title || '');
  const text = `${defaultLabel} ${feeTitle}`;

  return <PaymentMethodLabel text={text} />;
};

const Content = (props) => {
  updateCart(props);

  const {
    test_mode_title,
    test_mode_description,
    test_mode_link_text,
    test_mode_link_src,
    checkout_benefits_title,
    checkout_benefits_items,
    payment_methods_title,
    payment_methods_methods,
    method,
    checkout_redirect_text,
    checkout_redirect_src,
    checkout_redirect_alt,
    terms_and_conditions_description,
    terms_and_conditions_link_text,
    terms_and_conditions_link_src,
    test_mode,
  } = settings.params;

  return (
    <div className="mp-checkout-container">
      <div className="mp-checkout-pro-container">
        <div className="mp-checkout-pro-content">
          {test_mode ? (
            <TestMode
              title={test_mode_title}
              description={test_mode_description}
              link-text={test_mode_link_text}
              link-src={test_mode_link_src}
            />
          ) : null}

          <div className="mp-checkout-pro-checkout-benefits">
            <CheckoutBenefits title={checkout_benefits_title} items={checkout_benefits_items} />
          </div>

          <PaymentMethodsV2 title={payment_methods_title} methods={payment_methods_methods} />

          {method === 'redirect' ? (
            <ChoRedirectV2 text={checkout_redirect_text} src={checkout_redirect_src} alt={checkout_redirect_alt} />
          ) : null}
        </div>
      </div>

      <TermsAndConditions
        description={terms_and_conditions_description}
        linkText={terms_and_conditions_link_text}
        linkSrc={terms_and_conditions_link_src}
      />
    </div>
  );
};

const mercadopagoPaymentMethod = {
  name: paymentMethodName,
  label: <Label />,
  content: <Content />,
  edit: <Content />,
  canMakePayment: () => true,
  ariaLabel: defaultLabel,
  supports: {
    features: settings?.supports ?? [],
  },
};

registerPaymentMethod(mercadopagoPaymentMethod);
