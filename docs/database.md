# Ally Pay Database Design


# Tables Overview


## users


Stores application users.


Columns:

```text
id PK

name

email UNIQUE

password

created_at

updated_at
```


Relations:


User hasOne Wallet

User hasOne Merchant

User hasMany Transactions


---

# wallets


Stores user wallet balance.


Columns:

```text
id PK

user_id FK

balance
```


Relationship:

User 1:1 Wallet


---

# wallet_transactions


Stores wallet history.


Columns:

```text
id

wallet_id FK

type

amount

balance_after

reference
```


Types:

credit

debit

transfer


---

# merchants


Stores merchant profile.


Columns:

```text
id

user_id FK

business_name

business_email

business_phone

status
```


Status:

pending

approved

rejected


Relationship:

User 1:1 Merchant


---

# merchant_api_keys


Stores merchant credentials.


Columns:

```text
id

merchant_id FK

public_key

secret_key

is_active
```


Security:

secret_key stored using Hash::make()


Relationship:

Merchant hasMany ApiKeys


---

# payment_orders


Stores payment requests.


Columns:

```text
id

merchant_id

order_id UNIQUE

amount

currency

customer_name

customer_email

customer_phone

payment_reference

status

metadata

paid_at
```


Status:

pending

success

failed


Relationship:

Merchant hasMany Payments


---

# webhook_events


Stores webhook delivery logs.


Columns:

```text
id

payment_order_id

event_type

callback_url

payload

response

status

attempts
```


Relationship:

PaymentOrder hasMany WebhookEvents


---

# merchant_webhook_settings


Stores merchant webhook config.


Columns:


```text
id

merchant_id

callback_url

secret_key

is_active
```


Relationship:

Merchant hasOne WebhookSetting


---

# audit_logs


Stores activities.


Columns:


```text
id

user_id

action

entity_type

entity_id

data
```


Examples:

USER_CREATED

PAYMENT_CREATED

WALLET_UPDATED


---

# Role Tables


Spatie Permission:


```text
roles

permissions

model_has_roles

role_has_permissions
```


Roles:


admin

merchant

customer


---

# Relationships


User

↓

Wallet


User

↓

Merchant


Merchant

↓

Payment Orders


Payment Order

↓

Webhook Events


Merchant

↓

API Keys


Merchant

↓

Webhook Settings


---

# Indexes


Important indexes:


users.email


payment_orders.order_id


payment_orders.merchant_id


wallet_transactions.wallet_id


merchant_api_keys.public_key


---

# Data Protection


Implemented:

DB Transactions

Row Locking:

lockForUpdate()


Foreign Keys


Cascade Deletes


Unique Constraints
