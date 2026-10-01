You are a senior Laravel + CyberSource Unified Checkout engineer.

I am integrating the **HNB CyberSource Payment Gateway** for a React Native mobile application with a Laravel backend.

## Current Situation

My backend currently creates a payment session using:

```
POST /flex/v2/sessions
```

with a payload similar to:

```php
[
    'clientVersion' => 'v2.0',
    'targetOrigins' => [...],
    'allowedCardNetworks' => [
        'VISA',
        'MASTERCARD',
        'AMEX'
    ]
]
```

The payment gateway is returning transactions as **REST API** instead of **Unified Checkout**.

HNB Customer Care reviewed my implementation and informed me that my integration is not following the Unified Checkout Session API correctly.

They specifically requested:

* Verify Client and Server setup.
* Refer to the Unified Checkout Session API documentation.
* Ensure `completeMandate` is included.
* Ensure `consumerAuthentication` is enabled for 3DS.
* Follow the Unified Checkout guide instead of the basic REST payment flow.

---

## Important Information

Backend

Laravel

Frontend

React Native Mobile Application

Payment Gateway

HNB CyberSource

Environment

CyberSource Sandbox

---

## Official Requirements

According to the CyberSource Unified Checkout documentation:

The Session API endpoint must be

```
POST /uc/v1/sessions
```

NOT

```
POST /flex/v2/sessions
```

The capture context request must include at minimum:

```
allowedPaymentTypes
allowedCardNetworks
country
locale
targetOrigins
data.orderInformation.amountDetails.totalAmount
data.orderInformation.amountDetails.currency
```

Additionally HNB specifically requires

```
completeMandate.type
completeMandate.consumerAuthentication
```

to enable

* Payer Authentication
* 3DS
* Service orchestration

---

## Required Session Payload

Generate a payload similar to

```json
{
    "allowedPaymentTypes":[
        "PANENTRY"
    ],

    "allowedCardNetworks":[
        "VISA",
        "MASTERCARD",
        "AMEX"
    ],

    "country":"LK",

    "locale":"en_US",

    "targetOrigins":[
        "<correct value>"
    ],

    "data":{
        "orderInformation":{
            "amountDetails":{
                "totalAmount":"1000.00",
                "currency":"USD"
            }
        }
    },

    "completeMandate":{
        "type":"AUTH",
        "consumerAuthentication":true
    }
}
```

If additional required fields are needed by the current Unified Checkout API version, include them.

---

## Existing Project

Current files

```
InitiatePaymentSessionIntent.php
InitiatePaymentSessionAction.php
InitiatePaymentSessionUserDTO.php
InitiatePaymentSessionResDTO.php
```

The existing Intent already

* validates the request
* validates invoice ownership
* validates payment amount
* generates order reference
* creates pending orders

Do NOT rewrite this business logic unless required.

Only update the CyberSource integration.

---

## Tasks

Review the existing implementation.

Determine whether it is using Flex Session API or Unified Checkout Session API.

Replace the old implementation with the correct Unified Checkout Session API.

Update the HMAC signature if the endpoint changes.

Ensure the request-target used for signing matches the actual endpoint.

Update all required headers.

Generate the correct capture context.

Include

```
allowedPaymentTypes
```

Include

```
country
```

Include

```
locale
```

Include

```
orderInformation.amountDetails
```

Include

```
completeMandate
```

Include

```
consumerAuthentication
```

Verify that 3DS will be triggered.

Verify that the returned Capture Context is compatible with Unified Checkout.

Do not break the existing DTO structure.

Do not break the database structure.

Do not remove payment logging.

Keep retry logic.

Keep timeout logic.

Keep idempotency.

Preserve security.

---

## Mobile Application

The frontend is a React Native application.

Determine whether `targetOrigins` is required or whether another approach is needed because this is not a browser-based application.

If WebView or browser-based Unified Checkout is required, explain exactly what needs to change.

---

## Deliverables

Provide:

1. Updated `InitiatePaymentSessionAction.php`
2. Any changes required in `services.php`
3. Any `.env` changes
4. Any React Native changes
5. Any changes required for the payment authorization request
6. Explain every change and why it is necessary
7. Verify that the implementation complies with the latest CyberSource Unified Checkout documentation and HNB requirements.

Do not assume anything. If the current implementation mixes Flex and Unified Checkout, identify the issue and migrate it completely to the correct Unified Checkout flow.
