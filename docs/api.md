# Ally Pay API Documentation


## Base URL

Local:

```text
http://127.0.0.1:8000/api/v1
```

---

# Authentication

Ally Pay uses Laravel Passport OAuth2 authentication.

Protected APIs require:

```text
Authorization: Bearer ACCESS_TOKEN
Accept: application/json
```

---

# 1. Auth Module


## Register

Endpoint:

POST /register


Request:

```json
{
    "name":"Vikram",
    "email":"vikram@test.com",
    "password":"password123",
    "password_confirmation":"password123"
}
```

Response:

```json
{
    "success":true,
    "message":"User registered successfully",
    "data":{
        "token":"ACCESS_TOKEN"
    }
}
```

---

## Login


POST /login


Request:

```json
{
    "email":"vikram@test.com",
    "password":"password123"
}
```


Response:

```json
{
    "success":true,
    "token":"ACCESS_TOKEN"
}
```

---

## Profile


GET /profile


Auth:

Bearer Token Required


---

## Logout


POST /logout


---

# 2. Wallet APIs


## Balance


GET /wallet/balance


Response:


```json
{
 "balance":5000
}
```


---

## Add Money


POST /wallet/add-money


Request:


```json
{
 "amount":1000
}
```


---

## Deduct Money


POST /wallet/deduct-money


Request:


```json
{
 "amount":500
}
```


---

## Transfer Money


POST /wallet/transfer


Request:

```json
{
 "receiver_id":2,
 "amount":100
}
```


Features:

- Database transaction
- lockForUpdate()
- Wallet transaction history


---

# 3. Merchant APIs


## Apply Merchant


POST /merchant/apply


Request:

```json
{
 "business_name":"ABC Store",
 "business_email":"store@test.com",
 "business_phone":"9876543210"
}
```


Default Status:

pending


---

## Merchant Profile


GET /merchant/me


---

# Merchant API Keys


## Generate Key


POST /merchant/api-key/generate


Conditions:

- Merchant approved required


Response:

```json
{
 "public_key":"pk_test_xxxx",
 "secret_key":"sk_test_xxxx"
}
```


Security:

- Secret shown once
- Secret stored hashed


---

# 4. Payment APIs


Authentication:

Headers:

```text
X-API-KEY: PUBLIC_KEY
X-API-SECRET: SECRET_KEY
```


---

## Create Payment Order


POST /payment-orders


Request:


```json
{
 "amount":2500,
 "currency":"INR",
 "customer_name":"Rahul",
 "customer_email":"rahul@test.com",
 "customer_phone":"9876543210",
 "metadata":{
    "order":"123"
 }
}
```


Response:

```json
{
 "order_id":"ORD123456",
 "status":"pending"
}
```


---

## Verify Payment


POST /payment-orders/verify


Request:


```json
{
 "order_id":"ORD123456",
 "payment_reference":"PAY001",
 "status":"success"
}
```


Flow:

Payment Verify

↓

Update Order

↓

Create Webhook Event

↓

Queue Job Dispatch


---

# 5. Admin APIs


Admin Role Required


## Users


GET /admin/users


## Assign Role


POST /admin/users/{id}/assign-role


```json
{
 "role":"merchant"
}
```


---

## Merchants


GET /admin/merchants


Approve / Reject:


PATCH /admin/merchants/{id}/status


```json
{
 "status":"approved"
}
```


---

# 6. Webhooks


Events:

payment.success

payment.failed


Payload:


```json
{
 "event":"payment.success",
 "order_id":"ORD123",
 "amount":2500,
 "status":"success"
}
```


Features:

- Queue based delivery
- Retry support
- Logs maintained


---

# Error Response Format


401:

```json
{
 "success":false,
 "message":"Unauthenticated"
}
```


403:

```json
{
 "success":false,
 "message":"Forbidden"
}
```


422:

```json
{
 "success":false,
 "errors":{}
}
```


---

# Security


Implemented:

- Passport OAuth2
- Rate limiting
- API key authentication
- Hashed secrets
- Policies
- Middleware
- Security headers
- Logs
