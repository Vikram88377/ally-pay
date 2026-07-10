# Ally Pay Architecture


## Project Structure

Ally Pay follows clean layered architecture.


Request Flow:


Client
 |
 |
Controller
 |
 |
Form Request
 |
 |
Service Layer
 |
 |
Repository Interface
 |
 |
Repository Implementation
 |
 |
Model
 |
 |
Database


Response:

Resource
 |
Trait
 |
JSON Response



## Layers


### Controllers

Location:

app/Http/Controllers


Responsibilities:

- Receive request
- Call service layer
- Return response


Controllers do not contain business logic.



### Form Requests

Location:

app/Http/Requests


Used for:

- Validation
- Authorization


Example:

CreatePaymentOrderRequest

VerifyPaymentRequest



### Services

Location:

app/Services


Contains business logic.


Examples:

PaymentOrderService

WalletService

MerchantService

WebhookService



Responsibilities:

- Transactions
- Calculations
- External integrations
- Events



### Repository Pattern

Location:

app/Repositories


Used for database operations.


Example:

PaymentOrderRepository


Benefits:

- Loose coupling
- Easy testing
- Replace database logic easily



### Interfaces

Location:

app/Interfaces


Example:


PaymentOrderRepositoryInterface


Service depends on interface, not implementation.



### Traits


Location:

app/Traits


ApiResponseTrait

Used for:

- success response
- error response


AuditLogTrait

Used for:

- user activity logs
- payment logs
- wallet logs



### Helpers


Location:

app/Helpers


ReferenceHelper

Generate:

ORD
TR
CR
DR


MoneyHelper

Money formatting



### Exceptions


Location:

app/Exceptions


Custom exceptions:

InsufficientBalanceException

WalletNotFoundException

MerchantNotApprovedException



## Authentication


API:

Laravel Passport OAuth2


Web:

Laravel Session Auth



## Authorization


Spatie Roles:

admin

merchant

customer


Policies:

PaymentOrderPolicy



## Payment Flow


Merchant

creates order

↓

PaymentOrderController

↓

PaymentOrderService

↓

PaymentOrderRepository

↓

payment_orders table


Verify Payment

↓

Update status

↓

Create webhook event

↓

Dispatch Queue Job

↓

Send callback



## Wallet Flow


User Request

↓

WalletService

↓

DB Transaction

↓

lockForUpdate()

↓

Update balance

↓

Create transaction



## Security


Implemented:

- Passport tokens
- API key authentication
- Hashed secret keys
- Rate limiting
- Policies
- Security headers
- Audit logs
- Global exception handling



## Queue


Used for:

Webhook delivery


Driver:

database queue



## Database Safety


Used:

DB::transaction()

lockForUpdate()

Foreign keys

Indexes