(()=>{"use strict";const e=window.React,t=window.wc.wcBlocksRegistry,c=window.wc.wcSettings,i=window.wp.htmlEntities,n=({title:t,items:c,titleAlign:i="center",listMode:n="image"})=>(0,e.createElement)("checkout-benefits",{title:t,"title-align":i,items:c,"list-mode":n}),r=({text:t,src:c,alt:i})=>(0,e.createElement)("div",{className:"mp-checkout-pro-redirect"},(0,e.createElement)("checkout-redirect-v2",{text:t,src:c,alt:i})),o=({description:t,linkText:c,linkSrc:i})=>(0,e.createElement)("div",{className:"mp-checkout-pro-terms-and-conditions"},(0,e.createElement)("terms-and-conditions",{description:t,"link-text":c,"link-src":i})),s=({title:t,description:c,linkText:i,linkSrc:n})=>(0,e.createElement)("div",{className:"mp-checkout-pro-test-mode"},(0,e.createElement)("test-mode",{title:t,description:c,"link-text":i,"link-src":n}));var l;const a=(0,c.getSetting)("woo-mercado-pago-credits_data",{}),m=(0,i.decodeEntities)(a.title)||"Checkout Credits",d=()=>{const{test_mode_title:t,test_mode_description:c,test_mode_link_text:i,test_mode_link_src:l,checkout_benefits_title:m,checkout_benefits_items:d,checkout_redirect_text:_,checkout_redirect_src:k,checkout_redirect_alt:p,terms_and_conditions_description:u,terms_and_conditions_link_text:E,terms_and_conditions_link_src:h,test_mode:w}=a.params;return(0,e.createElement)("div",{className:"mp-checkout-container"},(0,e.createElement)("div",{className:"mp-checkout-pro-container"},(0,e.createElement)("div",{className:"mp-checkout-pro-content"},w?(0,e.createElement)(s,{title:t,description:c,linkText:i,linkSrc:l}):null,(0,e.createElement)(n,{title:m,items:d,listMode:"count"}),(0,e.createElement)(r,{text:_,src:k,alt:p}))),(0,e.createElement)(o,{description:u,linkText:E,linkSrc:h}))},_={name:"woo-mercado-pago-credits",label:(0,e.createElement)((t=>{const{PaymentMethodLabel:c}=t.components;return(0,e.createElement)(c,{text:m})}),null),content:(0,e.createElement)(d,null),edit:(0,e.createElement)(d,null),canMakePayment:()=>!0,ariaLabel:m,supports:{features:null!==(l=a?.supports)&&void 0!==l?l:[]}};(0,t.registerPaymentMethod)(_)})();