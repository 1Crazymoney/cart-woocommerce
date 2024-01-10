/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/blocks/pix.block.js":
/*!****************************************************!*\
  !*** ./assets/js/blocks/pix.block.js + 10 modules ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("// ESM COMPAT FLAG\n__webpack_require__.r(__webpack_exports__);\n\n;// CONCATENATED MODULE: external \"React\"\nconst external_React_namespaceObject = window[\"React\"];\n;// CONCATENATED MODULE: external [\"wp\",\"element\"]\nconst external_wp_element_namespaceObject = window[\"wp\"][\"element\"];\n;// CONCATENATED MODULE: external [\"wc\",\"wcBlocksRegistry\"]\nconst external_wc_wcBlocksRegistry_namespaceObject = window[\"wc\"][\"wcBlocksRegistry\"];\n;// CONCATENATED MODULE: external [\"wp\",\"htmlEntities\"]\nconst external_wp_htmlEntities_namespaceObject = window[\"wp\"][\"htmlEntities\"];\n;// CONCATENATED MODULE: external [\"wc\",\"wcSettings\"]\nconst external_wc_wcSettings_namespaceObject = window[\"wc\"][\"wcSettings\"];\n;// CONCATENATED MODULE: ./assets/js/blocks/helpers/cart-update.helper.js\nconst namespace = 'mercadopago_blocks_update_cart';\nconst addDiscountAndCommission = (callback, paymentMethodName) => {\n  callback({\n    namespace,\n    data: {\n      action: 'add',\n      gateway: paymentMethodName\n    }\n  });\n};\nconst removeDiscountAndCommission = (callback, paymentMethodName) => {\n  callback({\n    namespace,\n    data: {\n      action: 'remove',\n      gateway: paymentMethodName\n    }\n  });\n};\nfunction formatCurrency(value, currency) {\n  if (!Number.isInteger(value) || typeof currency !== 'object') {\n    throw new Error('Invalid input');\n  }\n  const formattedValue = (value / Math.pow(10, currency.minorUnit)).toFixed(currency.minorUnit);\n  const parts = formattedValue.split('.');\n  const integerPart = parts[0];\n  const decimalPart = parts[1];\n  return `${integerPart}.${decimalPart}`;\n}\nfunction handleCartTotalChange(value, currency) {\n  if (cardFormMounted) {\n    cardForm.unmount();\n  }\n  initCardForm(formatCurrency(value, currency));\n}\n\n;// CONCATENATED MODULE: ./assets/js/blocks/components/TestMode.js\n\nconst TestMode = ({\n  title,\n  description,\n  linkText,\n  linkSrc\n}) => (0,external_React_namespaceObject.createElement)(\"div\", {\n  className: \"mp-checkout-pro-test-mode\"\n}, (0,external_React_namespaceObject.createElement)(\"test-mode\", {\n  title: title,\n  description: description,\n  \"link-text\": linkText,\n  \"link-src\": linkSrc\n}));\n/* harmony default export */ const components_TestMode = (TestMode);\n;// CONCATENATED MODULE: ./assets/js/blocks/components/PixTemplate.js\n\nconst PixTemplate = ({\n  title,\n  subtitle,\n  alt,\n  linkSrc\n}) => (0,external_React_namespaceObject.createElement)(\"pix-template\", {\n  title: title,\n  subtitle: subtitle,\n  alt: alt,\n  src: linkSrc\n});\n/* harmony default export */ const components_PixTemplate = (PixTemplate);\n;// CONCATENATED MODULE: ./assets/js/blocks/components/TermsAndConditions.js\n\nconst TermsAndConditions = ({\n  description,\n  linkText,\n  linkSrc,\n  checkoutClass = 'pro'\n}) => (0,external_React_namespaceObject.createElement)(\"div\", {\n  className: `mp-checkout-${checkoutClass}-terms-and-conditions`\n}, (0,external_React_namespaceObject.createElement)(\"terms-and-conditions\", {\n  description: description,\n  \"link-text\": linkText,\n  \"link-src\": linkSrc\n}));\n/* harmony default export */ const components_TermsAndConditions = (TermsAndConditions);\n;// CONCATENATED MODULE: ./assets/js/blocks/helpers/metrics.helper.js\nconst sendMetric = (name, message, target) => {\n  const url = 'https://api.mercadopago.com/v1/plugins/melidata/errors';\n  const payload = {\n    name,\n    message,\n    target: target,\n    plugin: {\n      version: wc_mercadopago_custom_checkout_params.plugin_version\n    },\n    platform: {\n      name: 'woocommerce',\n      uri: window.location.href,\n      version: wc_mercadopago_custom_checkout_params.platform_version,\n      location: `${wc_mercadopago_custom_checkout_params.location}_${wc_mercadopago_custom_checkout_params.theme}`\n    }\n  };\n  navigator.sendBeacon(url, JSON.stringify(payload));\n};\n/* harmony default export */ const metrics_helper = (sendMetric);\n;// CONCATENATED MODULE: ./assets/js/blocks/pix.block.js\nvar _settings$supports;\n\n/* globals wc_mercadopago_pix_blocks_params */\n\n\n\n\n\n\n\n\n\n\nconst targetName = \"mp_checkout_blocks\";\nconst paymentMethodName = 'woo-mercado-pago-pix';\nconst settings = (0,external_wc_wcSettings_namespaceObject.getSetting)(`woo-mercado-pago-pix_data`, {});\nconst defaultLabel = (0,external_wp_htmlEntities_namespaceObject.decodeEntities)(settings.title) || 'Checkout Pix';\nconst updateCart = props => {\n  const {\n    extensionCartUpdate\n  } = wc.blocksCheckout;\n  const {\n    eventRegistration,\n    emitResponse\n  } = props;\n  const {\n    onPaymentSetup,\n    onCheckoutSuccess,\n    onCheckoutFail\n  } = eventRegistration;\n  (0,external_wp_element_namespaceObject.useEffect)(() => {\n    addDiscountAndCommission(extensionCartUpdate, paymentMethodName);\n    const unsubscribe = onPaymentSetup(() => {\n      return {\n        type: emitResponse.responseTypes.SUCCESS\n      };\n    });\n    return () => {\n      removeDiscountAndCommission(extensionCartUpdate, paymentMethodName);\n      return unsubscribe();\n    };\n  }, [onPaymentSetup]);\n  (0,external_wp_element_namespaceObject.useEffect)(() => {\n    const unsubscribe = onCheckoutSuccess(async checkoutResponse => {\n      checkoutResponse.processingResponse.message = paymentMethodName;\n      const processingResponse = checkoutResponse.processingResponse;\n      metrics_helper(\"MP_PIX_BLOCKS_SUCCESS\", processingResponse.paymentStatus, targetName);\n      return {\n        type: emitResponse.responseTypes.SUCCESS\n      };\n    });\n    return () => unsubscribe();\n  }, [onCheckoutSuccess]);\n  (0,external_wp_element_namespaceObject.useEffect)(() => {\n    const unsubscribe = onCheckoutFail(checkoutResponse => {\n      const processingResponse = checkoutResponse.processingResponse;\n      metrics_helper(\"MP_PIX_BLOCKS_ERROR\", processingResponse.paymentStatus, targetName);\n      return {\n        type: emitResponse.responseTypes.FAIL,\n        messageContext: emitResponse.noticeContexts.PAYMENTS\n      };\n    });\n    return () => unsubscribe();\n  }, [onCheckoutFail]);\n};\nconst Label = props => {\n  const {\n    PaymentMethodLabel\n  } = props.components;\n  const feeTitle = (0,external_wp_htmlEntities_namespaceObject.decodeEntities)(settings?.params?.fee_title || '');\n  const text = `${defaultLabel} ${feeTitle}`;\n  return (0,external_React_namespaceObject.createElement)(PaymentMethodLabel, {\n    text: text\n  });\n};\nconst Content = props => {\n  updateCart(props);\n  const {\n    test_mode_title,\n    test_mode_description,\n    pix_template_title,\n    pix_template_subtitle,\n    pix_template_src,\n    pix_template_alt,\n    terms_and_conditions_description,\n    terms_and_conditions_link_text,\n    terms_and_conditions_link_src,\n    test_mode\n  } = settings.params;\n  return (0,external_React_namespaceObject.createElement)(\"div\", {\n    className: \"mp-checkout-container\"\n  }, (0,external_React_namespaceObject.createElement)(\"div\", {\n    className: \"mp-checkout-pix-container\"\n  }, (0,external_React_namespaceObject.createElement)(\"div\", {\n    className: \"mp-checkout-pix-content\"\n  }, test_mode ? (0,external_React_namespaceObject.createElement)(components_TestMode, {\n    title: test_mode_title,\n    description: test_mode_description\n  }) : null, (0,external_React_namespaceObject.createElement)(components_PixTemplate, {\n    title: pix_template_title,\n    subtitle: pix_template_subtitle,\n    alt: pix_template_alt,\n    linkSrc: pix_template_src\n  }))), (0,external_React_namespaceObject.createElement)(components_TermsAndConditions, {\n    description: terms_and_conditions_description,\n    linkText: terms_and_conditions_link_text,\n    linkSrc: terms_and_conditions_link_src,\n    checkoutClass: 'pix'\n  }));\n};\nconst mercadopagoPaymentMethod = {\n  name: paymentMethodName,\n  label: (0,external_React_namespaceObject.createElement)(Label, null),\n  content: (0,external_React_namespaceObject.createElement)(Content, null),\n  edit: (0,external_React_namespaceObject.createElement)(Content, null),\n  canMakePayment: () => true,\n  ariaLabel: defaultLabel,\n  supports: {\n    features: (_settings$supports = settings?.supports) !== null && _settings$supports !== void 0 ? _settings$supports : []\n  }\n};\n(0,external_wc_wcBlocksRegistry_namespaceObject.registerPaymentMethod)(mercadopagoPaymentMethod);\n\n//# sourceURL=webpack://woocommerce-mercadopago/./assets/js/blocks/pix.block.js_+_10_modules?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/js/blocks/pix.block.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;