# NobelaBootstrap System Breakdown

## 1. Project Overview

### Real-world purpose

NobelaBootstrap is a Laravel 12 marketplace and logistics platform. In practical terms, it combines three business surfaces:

- A public marketplace where visitors browse products, view product details, submit product orders, and leave reviews.
- A public services catalog where visitors browse service offerings, view service details, submit service requests/orders, and leave reviews.
- A logistics request and operations area where visitors request freight/logistics quotes, while authenticated back-office users manage quotes, vehicles, shipments, and order tracking.

The system is not a complete transactional marketplace yet. It currently behaves more like a lead-generation and operations dashboard: orders are submitted directly from product/service detail pages, payment is not collected, vendor fulfillment is not separated by account, and shipments are manually created by an authenticated user.

### Target users

#### Guest

Guests are unauthenticated public visitors. They can:

- View the home page, about page, marketplace, product details, services, and service details.
- Search/filter products and services.
- Submit product orders and service orders.
- Submit logistics quote requests.
- Submit public reviews for products and services.
- Track an order if they have the direct order tracking URL.

Guests are not given cart, account history, checkout, payment, or quote acceptance workflows.

#### Customer

The codebase has Laravel Breeze user registration/login, but there is no implemented customer domain role. A registered user can log in and access the authenticated dashboard/CRUD routes, which is a security and authorization gap.

The intended customer should be able to:

- Manage profile details.
- Place orders under an account.
- View order history.
- Track shipments.
- Accept logistics quotes.

The actual implementation does not yet connect orders or quote requests to users.

#### Vendor

The `vendors` table and `Vendor` model exist, and products/services can be assigned to vendors. A vendor can optionally be linked to a `users.id`, but the application does not enforce vendor ownership, vendor dashboards, vendor permissions, payout logic, or vendor onboarding.

The intended vendor should be able to:

- Manage own products/services.
- View own orders.
- Respond to service requests.
- Fulfill marketplace orders.

The actual implementation treats vendors mostly as admin-managed records.

#### Admin

Authenticated users currently function as administrators because all CRUD modules are behind only `auth` and `verified` middleware. Admin users can:

- View dashboard metrics.
- Manage services, products, categories, vendors, reviews, orders, vehicles, shipments, and quote requests.
- Update order, shipment, vehicle, and quote statuses.

There is no explicit admin role or permission check.

### Core platform purpose

The core purpose is to provide a combined marketplace, service booking, and logistics management portal for a South African business context. The system is useful as an MVP prototype for listing offerings and collecting customer intent. It is not yet production-ready for payments, inventory integrity, multi-vendor operations, privacy-sensitive tracking, or secure administration.

## 2. Core Features

### Public Features

#### Home page

Functionality:

- Loads featured services and products using `DashboardController::welcome`.
- Fetches latest active services and active products with images and categories.

User flow:

1. Guest visits `/`.
2. System queries active service and product records.
3. Blade view renders featured marketplace/service entries.

Limitations:

- No personalization.
- No configurable featured flag; "featured" means latest records.
- No caching despite repeated public catalog queries.

#### Public product marketplace

Functionality:

- Route: `GET /marketplace`.
- Controller: `ProductController::publicIndex`.
- Lists active products.
- Supports category filter through `?category={slug}`.
- Supports title search through `?search={term}`.
- Includes product images, category, and vendor.

User flow:

1. Guest opens marketplace.
2. Optionally searches or filters by category.
3. System returns paginated active products.
4. Guest clicks a product to view details.

Limitations:

- Search only checks product title.
- No price range, stock status, vendor filter, sorting, tags, SKU, or full-text index.
- Products with no image handling depend on Blade fallback.
- Public detail route does not block inactive products when accessed directly via model binding.

#### Product detail and direct order

Functionality:

- Route: `GET /marketplace/{product}`.
- Controller: `ProductController::publicShow`.
- Shows product images, category, vendor, reviews, and related products.
- Route: `POST /marketplace/{product}/order`.
- Controller: `OrderController::storeProductOrder`.
- Creates an order and one polymorphic `order_items` row for the product.
- Decrements product stock.

User flow:

1. Guest views product detail.
2. Guest submits name, email, optional phone, quantity, and notes.
3. System validates quantity against current stock.
4. System creates `orders` row with `type = product`.
5. System creates `order_items` row pointing to `App\Models\Product`.
6. System decrements product stock.
7. Guest is redirected to `/orders/{order}/track`.

Limitations:

- No cart.
- No payment.
- No customer account association.
- No transaction around order creation and stock decrement.
- Race conditions can oversell stock under concurrent requests.
- No shipping address fields on orders.
- No fraud, anti-spam, or confirmation email.
- Tracking URL uses numeric order ID, not a private token.

#### Public services catalog

Functionality:

- Route: `GET /our-services`.
- Controller: `ServicesController::public`.
- Lists active services.
- Supports category filter by slug.
- Supports title search.

User flow:

1. Guest opens services page.
2. Optionally filters/searches.
3. System returns paginated active services.
4. Guest opens a service detail page.

Limitations:

- Service model is named `services` instead of Laravel-standard `Service`.
- Search is title-only.
- Service availability, duration, scheduling, provider capacity, and service areas are not modeled.

#### Service detail and service order

Functionality:

- Route: `GET /our-services/{service}`.
- Controller: `ServicesController::publicShow`.
- Route: `POST /our-services/{service}/order`.
- Controller: `OrderController::storeServiceOrder`.
- Creates an `orders` row with `type = service`.
- Creates one polymorphic `order_items` row pointing to `App\Models\Service`.

User flow:

1. Guest views service detail.
2. Guest submits name, email, optional phone, and notes.
3. System creates a pending service order.
4. System stores service price as order total, defaulting to zero if no price exists.
5. Guest is redirected to tracking page.

Limitations:

- No scheduling.
- No service location validation.
- No quote/estimate workflow for variable-price services.
- No customer account.
- No vendor notification.

#### Public reviews

Functionality:

- Route: `POST /reviews/{type}/{id}`.
- Controller: `ReviewController::store`.
- Supports `product` and `service` review types.
- Stores name, email, rating, and comment.
- Reviews are polymorphic through `reviewable_type` and `reviewable_id`.

User flow:

1. Guest submits review form from a product/service page.
2. System validates rating from 1 to 5.
3. System creates review against product or service.

Limitations:

- No moderation status.
- No verified purchase requirement.
- No duplicate review prevention.
- No rate limiting visible in route definition.
- Public email is stored directly, raising privacy and spam concerns.

#### Logistics quote request

Functionality:

- Route: `GET /logistics/quote`.
- Route: `POST /logistics/quote`.
- Controller: `QuoteRequestController`.
- Guest submits contact, origin, destination, cargo description, weight, and preferred date.

User flow:

1. Guest opens logistics quote form.
2. Guest enters shipment requirements.
3. System validates fields and stores a `quote_requests` row with `status = pending`.
4. Admin later reviews and updates status/price.

Limitations:

- No email notification.
- No customer quote acceptance flow.
- No conversion from accepted quote to logistics order.
- No address normalization, distance calculation, vehicle matching, or pricing engine.

#### Public order tracking

Functionality:

- Route: `GET /orders/{order}/track`.
- Controller: `OrderController::track`.
- Loads order items and shipment vehicle.

User flow:

1. User opens tracking URL after order creation.
2. System renders order status and shipment details if a shipment exists.

Limitations:

- Uses route-model binding by numeric order ID.
- Anyone can view an order if they know or guess the ID.
- Tracking does not use `order_number` despite the comment saying "by order_number".
- No tracking events table; `tracking_notes` is a single text field on `shipments`.

### Authenticated User Features

#### Dashboard

Functionality:

- Route: `GET /dashboard`.
- Controller: `DashboardController::index`.
- Shows counts for pending orders, active shipments, pending quotes, total services, total products, and available vehicles.
- Builds chart data for orders by status, shipments by status, and daily orders over the last 14 days.

User flow:

1. Authenticated verified user logs in.
2. User opens dashboard.
3. System queries aggregate counts and recent records.

Limitations:

- Every verified user can access operational metrics.
- No role-based data filtering.
- No vendor/customer-specific dashboard separation.

#### Profile management

Functionality:

- Laravel Breeze profile routes are available.
- Authenticated users can update profile, password, and delete account.

Limitations:

- User profile is not extended with role, phone, address, customer identity, vendor identity, or admin flag.

### Admin Features

The admin features are protected only by `auth` and `verified`, not by an admin middleware. Functionally they are admin modules, but security-wise they are authenticated-user modules.

#### Category management

Functionality:

- Resource routes: `categories`.
- Controller: `CategoryController`.
- Admin can create, list, edit, update, and delete categories.
- Categories include `name`, `slug`, `description`, `icon`, and `type`.
- Category type controls whether it applies to products, services, or both.

User flow:

1. Admin opens category list.
2. Admin creates or edits a category.
3. Slug is generated from name.
4. Product/service catalog filters use slug.

Limitations:

- Slug collision handling is weak: two names can slug to the same string.
- Deleting a category nulls product/service category references because FK uses `nullOnDelete`.
- No hierarchy, image, SEO metadata, or display ordering.

#### Product management

Functionality:

- Resource routes: `products`.
- Controller: `ProductController`.
- Admin can manage products and upload multiple images.
- Product fields: title, description, price, stock, category, vendor, status.

User flow:

1. Admin opens product list.
2. Admin creates/edits product.
3. Uploaded images move to `public/assets/img/products`.
4. Image paths are persisted in `product_images`.

Limitations:

- No SKU.
- No product variants.
- No image deletion/reordering.
- No storage disk abstraction.
- File names preserve original client filename with timestamp prefix.
- No inventory reservation or stock movement ledger.

#### Service management

Functionality:

- Resource routes: `services`.
- Controller: `ServicesController`.
- Admin can manage services and upload images.
- Service fields include title, description, icon, status, category, vendor, price, location.

User flow:

1. Admin opens services list.
2. Admin creates/edits service.
3. System stores service and images.

Limitations:

- Model/class naming is non-standard.
- `services_img` relationship uses `services_id`, and the model relationship now points to `Service::class` with the explicit foreign key.
- No service booking calendar or availability model.

#### Vendor management

Functionality:

- Resource routes: `vendors`.
- Controller: `VendorController`.
- Admin can create, edit, view, and delete vendors.
- Vendor can be linked to a user.
- Vendor can have logo image.

User flow:

1. Admin creates vendor profile.
2. Admin optionally links vendor to an existing user.
3. Admin assigns products/services to vendor elsewhere.

Limitations:

- No unique constraint on `user_id`; multiple vendor records could point to the same user.
- No vendor self-service.
- No vendor verification workflow beyond status field.
- No bank/payout/onboarding fields.

#### Review management

Functionality:

- Resource routes: `reviews` index and destroy.
- Admin can list and delete reviews.

Limitations:

- No approve/reject workflow.
- Reviews are public immediately.
- No abuse reporting or audit trail.

#### Order management

Functionality:

- Resource routes: `orders` index, show, update.
- Admin can filter by status/type.
- Admin can update status and notes.
- Order detail loads items and shipment.

User flow:

1. Admin opens order list.
2. Admin filters by status/type.
3. Admin opens order detail.
4. Admin changes status and notes.

Limitations:

- No order creation by admin.
- No order cancellation logic that restores product stock.
- No payment state.
- No customer/user foreign key.
- No address, tax, discount, shipping charge, invoice, or fulfillment split.

#### Vehicle management

Functionality:

- Resource routes: `vehicles`.
- Controller: `VehicleController`.
- Admin manages fleet records.
- Vehicle status can be available, on job, or maintenance.

User flow:

1. Admin creates vehicle with registration plate and capacity.
2. Admin assigns vehicle to shipment.
3. Vehicle status can be updated manually or by shipment assignment/update logic.

Limitations:

- No drivers table.
- No vehicle documents table.
- No maintenance schedule.
- No capacity unit beyond `capacity_kg`.
- Vehicle status can become inconsistent if multiple active shipments reference one vehicle.

#### Shipment management

Functionality:

- Resource routes: `shipments`.
- Controller: `ShipmentController`.
- Admin creates and updates shipments.
- Shipment can link to an order and vehicle.
- Shipment records origin, destination, cargo, weight, status, pickup/delivery dates, driver details, and tracking notes.

User flow:

1. Admin creates shipment.
2. Admin optionally links logistics order and vehicle.
3. If assigned, vehicle status is set to `on_job`.
4. On delivered/cancelled, vehicle status is reset to `available`.
5. Public tracking page shows shipment if linked to order.

Limitations:

- Create/edit only select `orders.type = logistics`, but no public flow currently creates logistics orders from quote requests.
- Product and service orders cannot easily receive shipments through the create form filter.
- No tracking event history.
- No proof of delivery.
- No GPS, route, dispatch, or driver assignment model.

#### Quote request management

Functionality:

- Resource routes: `quote-requests` except public create/store.
- Controller: `QuoteRequestController`.
- Admin can list, view, update status, set quoted price, add notes, and delete.

User flow:

1. Guest submits quote.
2. Admin opens quote list.
3. Admin updates status to quoted/accepted/rejected and adds price/notes.

Limitations:

- Customer cannot accept quote online.
- Accepted quote does not automatically create order/shipment.
- No notifications.
- No pricing rules.

## 3. System Architecture

### Backend architecture

The backend is a conventional Laravel 12 application using:

- `routes/web.php` for all public and authenticated web routes.
- `app/Http/Controllers` for request handling.
- `app/Models` for Eloquent models.
- `database/migrations` for schema definitions.
- `database/seeders` for sample records.
- Laravel Breeze authentication scaffolding.
- Spatie Sitemap package for sitemap generation.

The application is monolithic. There is no API layer, service layer, domain layer, event-driven workflow, or queue-backed business process yet.

### MVC usage

The project uses Laravel MVC in a straightforward way:

- Models define fillable fields and Eloquent relationships.
- Controllers perform validation, query models, mutate records, and return Blade views.
- Views render admin/public pages and forms.
- Routes bind HTTP endpoints to controllers.

The MVC implementation is functional but controller-heavy. Business actions such as order creation, stock decrement, vehicle status changes, and quote updates are implemented directly in controllers. For production, these should move into dedicated action/service classes with transactions and tests.

### Frontend stack

The frontend stack is:

- Blade templates under `resources/views`.
- Laravel Vite plugin.
- Tailwind CSS.
- Alpine.js.
- Axios available in the JS dependencies.
- Compiled public build assets under `public/build`.

The app appears to combine Laravel Breeze UI components with custom public templates and static assets under `public/assets`.

### Routing/controller/view interaction

Public flow:

1. Guest requests a public route such as `/marketplace`.
2. `routes/web.php` dispatches to a controller method.
3. Controller builds Eloquent queries and eager-loads relationships.
4. Controller returns a Blade view with compacted data.
5. Blade renders catalog cards, forms, and details.

Authenticated flow:

1. User logs in through Breeze auth routes.
2. `auth` and `verified` middleware allow access to dashboard and CRUD routes.
3. Resource controllers handle CRUD operations.
4. Validation is performed inline with `$request->validate`.
5. Mutations redirect back to admin pages with session flash messages.

Key architectural issue:

- Route groups imply "Admin", but middleware only checks authentication and email verification. There is no role/permission boundary.

## 4. Database Design

### Framework tables

#### `users`

Columns:

- `id`
- `name`
- `email` unique
- `email_verified_at` nullable timestamp
- `password`
- `remember_token`
- `created_at`
- `updated_at`

Relationships:

- `users.id` can be referenced by `vendors.user_id`.
- `users.id` can be referenced by `reviews.user_id`.

Design notes:

- No `role`, `is_admin`, customer profile fields, phone, address, or vendor status.
- Orders and quote requests do not reference users.

#### `password_reset_tokens`

Columns:

- `email` primary key
- `token`
- `created_at`

Purpose:

- Laravel auth password reset support.

#### `sessions`

Columns:

- `id` primary key
- `user_id` nullable indexed
- `ip_address`
- `user_agent`
- `payload`
- `last_activity` indexed

Purpose:

- Database-backed session storage if configured.

#### `cache`

Columns:

- `key` primary key
- `value`
- `expiration`

Purpose:

- Laravel cache store.

#### `cache_locks`

Columns:

- `key` primary key
- `owner`
- `expiration`

Purpose:

- Atomic cache locks.

#### `jobs`

Columns:

- `id`
- `queue` indexed
- `payload`
- `attempts`
- `reserved_at`
- `available_at`
- `created_at`

Purpose:

- Queue jobs. No business jobs are visible in the inspected controllers.

#### `job_batches`

Columns:

- `id` primary key
- `name`
- `total_jobs`
- `pending_jobs`
- `failed_jobs`
- `failed_job_ids`
- `options`
- `cancelled_at`
- `created_at`
- `finished_at`

Purpose:

- Laravel batch queue support.

#### `failed_jobs`

Columns:

- `id`
- `uuid` unique
- `connection`
- `queue`
- `payload`
- `exception`
- `failed_at`

Purpose:

- Failed queue job diagnostics.

### Business tables

#### `categories`

Columns:

- `id`
- `name`
- `slug` unique
- `description` nullable
- `icon` nullable
- `type` enum: `service`, `product`, `both`
- `created_at`
- `updated_at`

Relationships:

- One category has many products.
- One category has many services.
- `products.category_id` references `categories.id`, nullable, null on delete.
- `services.category_id` references `categories.id`, nullable, null on delete.

Design notes:

- Useful shared taxonomy across services and products.
- Lacks hierarchy, sort order, SEO fields, and slug collision handling.

#### `vendors`

Columns:

- `id`
- `user_id` nullable FK to `users.id`, null on delete
- `business_name`
- `description` nullable
- `logo_path` nullable
- `phone` nullable
- `address` nullable
- `status` enum: `active`, `inactive`, `pending`
- `created_at`
- `updated_at`

Relationships:

- Vendor belongs to user.
- Vendor has many products.
- Vendor has many services.

Design notes:

- Vendor is only a business profile, not a true vendor account boundary.
- Missing unique constraint on `user_id`.
- Missing vendor approval audit, contact person, payout, compliance, documents, and service areas.

#### `services`

Columns:

- `id`
- `title`
- `description` nullable
- `icon` nullable
- `image` nullable
- `status` boolean default true
- `category_id` nullable FK to `categories.id`, null on delete
- `vendor_id` nullable FK to `vendors.id`, null on delete
- `price` decimal(10,2) nullable
- `location` nullable
- `created_at`
- `updated_at`

Relationships:

- Service belongs to category.
- Service belongs to vendor.
- Service has many service images.
- Service has many reviews through polymorphic `reviews`.
- Service can be ordered through polymorphic `order_items`.

Design notes:

- Model class is named `services` instead of `Service`.
- `image` column exists but images are stored through `services_imgs`; this is redundant or unused.
- No availability/scheduling model.

#### `services_imgs`

Columns:

- `id`
- `services_id` FK constrained, cascade on delete
- `image_path`
- `created_at`
- `updated_at`

Relationships:

- Each image belongs to a service.
- Each service has many images.

Design notes:

- Table and column names are non-standard. Laravel convention would be `service_images.service_id`.
- The model relationship references `Service::class` with the explicit `services_id` foreign key.

#### `service_requests`

Columns:

- `id`
- `service_id` FK to `services.id`, cascade on delete
- `name`
- `email`
- `phone` nullable
- `message` nullable
- `created_at`
- `updated_at`

Relationships:

- Intended: service request belongs to service.

Design notes:

- There is no visible model in `app/Models` for `service_requests`.
- Current public service ordering uses `orders` and `order_items`, not this table.
- This table appears to be legacy or unused.

#### `products`

Columns:

- `id`
- `title`
- `description` nullable
- `price` decimal(10,2)
- `stock` unsigned integer default 0
- `category_id` nullable FK to `categories.id`, null on delete
- `vendor_id` nullable FK to `vendors.id`, null on delete
- `status` enum: `active`, `inactive`
- `created_at`
- `updated_at`

Relationships:

- Product belongs to category.
- Product belongs to vendor.
- Product has many product images.
- Product has many reviews through polymorphic `reviews`.
- Product can be ordered through polymorphic `order_items`.

Design notes:

- Missing SKU, dimensions, weight, status history, price history, variants, and inventory reservations.

#### `product_images`

Columns:

- `id`
- `product_id` FK to `products.id`, cascade on delete
- `image_path`
- `created_at`
- `updated_at`

Relationships:

- Product image belongs to product.
- Product has many images.

Design notes:

- No sort order or alt text.
- Physical files are not deleted when database rows/products are deleted.

#### `reviews`

Columns:

- `id`
- `reviewable_type`
- `reviewable_id`
- `user_id` nullable FK to `users.id`, null on delete
- `reviewer_name`
- `reviewer_email`
- `rating` unsigned tiny integer
- `comment` nullable
- `created_at`
- `updated_at`

Relationships:

- Polymorphic: review belongs to either product or service.
- Review optionally belongs to user.

Design notes:

- No check constraint for rating 1-5 at DB level.
- No moderation state.
- No verified purchase link.

#### `orders`

Columns:

- `id`
- `order_number` unique
- `client_name`
- `client_email`
- `client_phone` nullable
- `type` enum: `service`, `product`, `logistics`
- `status` enum: `pending`, `confirmed`, `in_progress`, `completed`, `cancelled`
- `total` decimal(10,2) default 0
- `notes` nullable
- `created_at`
- `updated_at`

Relationships:

- Order has many order items.
- Order has one shipment.

Design notes:

- No `user_id`.
- No billing/shipping address.
- No payment fields.
- No currency.
- No tax/discount/shipping breakdown.
- `order_number` is generated randomly but not used for route tracking.

#### `order_items`

Columns:

- `id`
- `order_id` FK to `orders.id`, cascade on delete
- `orderable_type`
- `orderable_id`
- `quantity` unsigned integer default 1
- `unit_price` decimal(10,2) default 0
- `created_at`
- `updated_at`

Relationships:

- Order item belongs to order.
- Polymorphic `orderable` points to product or service.

Design notes:

- Good flexible design for mixed item types.
- Missing immutable product/service title snapshot.
- Missing tax, discount, subtotal columns.
- If product/service is deleted, `orderable` can become broken because polymorphic constraints are not enforceable by FK.

#### `vehicles`

Columns:

- `id`
- `name`
- `registration_plate` unique
- `type` enum: `truck`, `van`, `motorcycle`, `flatbed`, `other`
- `make` nullable
- `model` nullable
- `year` nullable
- `capacity_kg` nullable
- `status` enum: `available`, `on_job`, `maintenance`
- `notes` nullable
- `created_at`
- `updated_at`

Relationships:

- Vehicle has many shipments.

Design notes:

- No driver, depot, current location, fuel/maintenance, insurance, or document relation.

#### `shipments`

Columns:

- `id`
- `order_id` nullable FK to `orders.id`, null on delete
- `vehicle_id` nullable FK to `vehicles.id`, null on delete
- `driver_name` nullable
- `driver_phone` nullable
- `origin`
- `destination`
- `cargo_description` nullable
- `weight_kg` nullable
- `status` enum: `pending`, `assigned`, `in_transit`, `delivered`, `cancelled`
- `pickup_date` nullable
- `delivery_date` nullable
- `tracking_notes` nullable
- `created_at`
- `updated_at`

Relationships:

- Shipment belongs to order.
- Shipment belongs to vehicle.

Design notes:

- Shipment is one-to-one with order from `Order::shipment`, but database does not enforce unique `order_id`.
- Multiple shipments can be linked to one order in the database, contradicting the model relationship.
- Tracking is a single text field, not an event stream.

#### `quote_requests`

Columns:

- `id`
- `client_name`
- `client_email`
- `client_phone` nullable
- `origin`
- `destination`
- `cargo_description`
- `weight_kg` nullable
- `preferred_date` nullable
- `status` enum: `pending`, `quoted`, `accepted`, `rejected`
- `admin_notes` nullable
- `quoted_price` decimal(10,2) nullable
- `created_at`
- `updated_at`

Relationships:

- None.

Design notes:

- No `user_id`, `order_id`, or `shipment_id`.
- Accepted quotes cannot be traced into operational fulfillment.

#### `property_details`

Columns:

- `id`
- `title`
- `description` nullable
- `price` decimal(12,2)
- `address`
- `city`
- `state` nullable
- `country` default `South Africa`
- `bedrooms` default 0
- `bathrooms` default 0
- `garage` default 0
- `size` default 0
- `parking_spaces` default 0
- `property_type` default `House`
- `status` default `Available`
- `created_at`
- `updated_at`

Relationships:

- None visible in current model list.

Design notes:

- Appears to be legacy real-estate functionality.
- No model/controller present in inspected files.
- Should be removed if out of scope or restored properly if real estate is still part of the product.

#### `logistics_details`

Columns:

- `id`
- `name`
- `type`
- `capacity` nullable
- `origin`
- `destination`
- `status` default `available`
- `documents` JSON nullable
- `created_at`
- `updated_at`

Relationships:

- None visible in current model list.

Design notes:

- Appears to be legacy and conflicts conceptually with the newer `vehicles` and `shipments` tables.
- One migration drops `logistics_details` before creating `shipments`, but a later migration recreates `logistics_details`, leaving duplicate logistics concepts.

### Data flow between tables

Product order flow:

1. `products` stores sellable product data and stock.
2. Guest order creates `orders` with `type = product`.
3. System creates `order_items` with `orderable_type = App\Models\Product`.
4. Product stock is decremented.
5. Admin may update `orders.status`.
6. Shipment may be manually created only if admin can select the order; current shipment create query filters to logistics orders, so product order shipment flow is incomplete.

Service order flow:

1. `services` stores service data.
2. Guest order creates `orders` with `type = service`.
3. System creates `order_items` with `orderable_type = App\Models\Service`.
4. Admin may update order status.
5. No scheduling, assignment, or service fulfillment table exists.

Logistics quote flow:

1. Guest creates `quote_requests`.
2. Admin updates quote price/status.
3. There is no automated transition to `orders`.
4. There is no automated transition to `shipments`.

Shipment flow:

1. Admin creates `shipments`.
2. Shipment optionally references `orders`.
3. Shipment optionally references `vehicles`.
4. Vehicle status is updated based on shipment state.
5. Public order tracking displays shipment details when an order has an associated shipment.

### Design flaws and missing relationships

- `orders` should reference `users` for authenticated customers.
- `quote_requests` should optionally reference `users`, and accepted quotes should create or link to `orders`.
- `shipments.order_id` should be unique if the domain is truly one shipment per order.
- Product/service orders need addresses or fulfillment details.
- `order_items` should snapshot item name/details because polymorphic targets can change or disappear.
- `vendors.user_id` should likely be unique.
- `services_imgs.services_id` should be renamed to `service_id`.
- `services` model/table naming should be normalized to `Service`.
- `service_requests`, `property_details`, and `logistics_details` look like legacy tables that are not integrated.
- There is no roles/permissions schema.
- There is no payments schema.
- There is no cart schema.
- There is no audit log.

## 5. Model Relationships

### Product

Relationships:

- `hasMany(ProductImage::class)` as images.
- `belongsTo(Category::class)`.
- `belongsTo(Vendor::class)`.
- `morphMany(Review::class, 'reviewable')`.
- Implicitly orderable through `OrderItem::morphTo`.

Responsibilities:

- Represents marketplace product listing.
- Stores price, stock, category, vendor, and active/inactive status.
- Calculates average rating through reviews.

Weaknesses:

- No SKU/variant model.
- Stock decrement is not transaction-safe.
- No inventory reservation or restock logic.
- Public show route can expose inactive products directly.

### Service

Actual model: `App\Models\Service`.

Relationships:

- `hasMany(services_img::class)`.
- `belongsTo(Category::class)`.
- `belongsTo(Vendor::class)`.
- `morphMany(Review::class, 'reviewable')`.
- Implicitly orderable through `OrderItem::morphTo`.

Responsibilities:

- Represents a public service offering.
- Supports price, location, category, vendor, status, images, and reviews.

Weaknesses:

- Class name violates PSR/Laravel naming conventions.
- Image relationship naming is inconsistent.
- No scheduling, availability, booking, or assignment domain.
- `image` column is not aligned with multi-image implementation.

### Category

Relationships:

- `hasMany(Service::class)`.
- `hasMany(Product::class)`.

Responsibilities:

- Shared taxonomy for services and products.
- Slug generation for public filters.

Weaknesses:

- No hierarchy.
- No robust slug uniqueness strategy.
- No display order.
- No separate category rules for marketplace vs services beyond `type` enum.

### Vendor

Relationships:

- `belongsTo(User::class)`.
- `hasMany(Service::class)`.
- `hasMany(Product::class)`.

Responsibilities:

- Business profile for providers/sellers.
- Groups products and services under a vendor.

Weaknesses:

- Not a real access-control boundary.
- No vendor-specific permissions.
- No unique user/vendor guarantee.
- No financial or compliance fields.

### Order

Relationships:

- `hasMany(OrderItem::class)` as items.
- `hasOne(Shipment::class)` as shipment.

Responsibilities:

- Captures a customer request/order for product, service, or logistics.
- Generates `ORD-XXXXXXXX` order numbers.
- Tracks coarse status and total.

Weaknesses:

- No customer/user FK.
- No payment lifecycle.
- No address or fulfillment details.
- No transaction-safe creation flow.
- `hasOne` shipment is not enforced by database uniqueness.

### OrderItem

Relationships:

- `belongsTo(Order::class)`.
- `morphTo()` orderable.

Responsibilities:

- Stores individual ordered product/service reference.
- Calculates subtotal from quantity and unit price.

Weaknesses:

- No item title snapshot.
- No FK enforcement for polymorphic target.
- No line-level tax, discount, fulfillment status, or vendor split.

### Shipment

Relationships:

- `belongsTo(Order::class)`.
- `belongsTo(Vehicle::class)`.

Responsibilities:

- Represents operational delivery/logistics movement.
- Stores origin/destination, cargo, vehicle, driver, dates, status, and tracking notes.

Weaknesses:

- No driver model.
- No tracking events.
- No proof of delivery.
- No address geocoding.
- No constraint preventing one vehicle from being double-booked.

### QuoteRequest

Relationships:

- None.

Responsibilities:

- Captures public logistics quote leads.
- Stores quote price, status, and admin notes.

Weaknesses:

- Not linked to users, orders, or shipments.
- No customer quote acceptance flow.
- No notification workflow.
- No pricing engine.

### Review

Relationships:

- `morphTo()` reviewable.
- `belongsTo(User::class)` nullable.

Responsibilities:

- Stores product/service ratings and public comments.

Weaknesses:

- No moderation.
- No verified purchase linkage.
- No spam protection.
- No DB-level rating constraint.

## 6. Order and Logistics Flow

### Product order flow

1. Guest opens a product detail page.
2. Guest submits an order form with contact details and quantity.
3. `OrderController::storeProductOrder` validates:
   - name required
   - email required
   - phone optional
   - quantity between 1 and current product stock
   - notes optional
4. Controller calculates total as product price times quantity.
5. Controller creates an `orders` row:
   - generated order number
   - client contact fields
   - `type = product`
   - `status = pending`
   - calculated total
6. Controller creates an `order_items` row:
   - `order_id`
   - `orderable_type = App\Models\Product`
   - `orderable_id = product id`
   - quantity
   - unit price
7. Controller decrements product stock.
8. User is redirected to the order tracking page.

### Service order flow

1. Guest opens a service detail page.
2. Guest submits contact details and notes.
3. `OrderController::storeServiceOrder` validates input.
4. Controller creates an `orders` row:
   - `type = service`
   - `status = pending`
   - total set to service price or zero
5. Controller creates an `order_items` row pointing to `App\Models\Service`.
6. User is redirected to tracking page.

### Logistics quote flow

1. Guest opens `/logistics/quote`.
2. Guest submits contact, route, cargo, weight, and preferred date.
3. `QuoteRequestController::store` validates input.
4. System stores a `quote_requests` row with default `pending` status.
5. Admin reviews request and sets `quoted_price`, `status`, and `admin_notes`.

There is no implemented customer acceptance, order creation, payment, or shipment creation from an accepted quote.

### Shipment creation flow

1. Admin opens shipment creation form.
2. Controller loads available vehicles.
3. Controller loads non-cancelled orders where `type = logistics`.
4. Admin enters origin, destination, cargo, weight, dates, driver, vehicle, and status.
5. `ShipmentController::store` validates and creates shipment.
6. If a vehicle is assigned and shipment status is `assigned`, the vehicle is marked `on_job`.
7. On update, if vehicle changes, the old vehicle is set to `available`.
8. If current shipment is delivered/cancelled, current vehicle is set to `available`; otherwise `on_job`.

### Tracking flow

1. User visits `/orders/{order}/track`.
2. Laravel route-model binding resolves order by numeric ID.
3. Controller loads `items` and `shipment.vehicle`.
4. Blade view displays order status and shipment details.

### Missing for production readiness

- Private tracking token or order-number based lookup with email/phone verification.
- Payment provider integration.
- Transaction around order creation and stock decrement.
- Inventory reservations.
- Cart and checkout.
- Customer account order history.
- Shipment events table.
- Driver model and dispatch workflow.
- Quote acceptance that creates orders/shipments.
- Notifications for order/quote/shipment status changes.
- Address model and delivery address capture.
- Authorization policies for admin/vendor/customer access.

## 7. Current Limitations - Critical Analysis

### Architectural weaknesses

- Business logic is concentrated in controllers.
- No service/action layer for order placement, quote conversion, shipment assignment, or stock movement.
- No role-based architecture even though the system has admin, vendor, and customer concepts.
- Legacy tables and policies remain in the codebase, creating confusion.
- Inconsistent naming: `services`, `services_img`, `service_requests`.
- Public and admin concerns are mixed in the same controllers.
- Demo-level dashboard uses direct aggregate queries with no caching.
- Polymorphic order items are flexible but lack data snapshots.

### Missing marketplace features

- Cart.
- Checkout.
- Payment.
- Customer accounts connected to orders.
- Shipping/billing addresses.
- Order confirmation emails.
- Invoices/receipts.
- Product variants/SKUs.
- Stock reservation and stock ledger.
- Vendor order management.
- Vendor commissions/payouts.
- Discounts/coupons.
- Taxes/currency handling.
- Refunds/returns/cancellations.

### Missing logistics features

- Quote-to-order conversion.
- Quote acceptance by customer.
- Shipment event timeline.
- Driver accounts.
- Driver assignment.
- Proof of pickup/delivery.
- Route planning.
- GPS/location updates.
- Vehicle maintenance records.
- Capacity matching.
- Delivery pricing engine.
- Multi-stop shipments.

### Bad practices

- Authenticated routes are labeled admin but have no admin authorization.
- File uploads use `move(public_path(...))` instead of Laravel Storage disks.
- Uploaded filenames include original client filename.
- Public order tracking uses numeric IDs.
- Product order stock decrement is not inside a DB transaction.
- No cleanup of uploaded files when products/vendors/services are deleted.
- Public review submission lacks moderation and anti-spam controls.
- Some generated policies return `false` for everything and are not meaningfully integrated.
- `ServicesImg` relationship references a class name that does not match the actual model name.

### Scalability issues

- Search uses `LIKE "%term%"`, which does not scale well.
- No indexes on common filters like product status/category/vendor, service status/category/vendor, order status/type, shipment status, quote status.
- No caching for public category/catalog data.
- No queue usage for emails, notifications, image processing, sitemap generation, or reports.
- Public assets are stored locally, not on object storage/CDN.
- No domain events for order placed, quote updated, shipment assigned, shipment delivered.

## 8. Security Analysis

### Authentication

Strengths:

- Laravel Breeze authentication exists.
- Email verification middleware protects authenticated dashboard routes.
- Password reset tables/routes are available.

Risks:

- Any verified registered user can access admin CRUD modules.
- No role, permission, or admin middleware.
- Vendor/customer/admin are not separated.

### Authorization

Strengths:

- Some policy files exist.

Risks:

- Policies shown are deny-all stubs and not used to enforce admin/vendor/customer behavior.
- CRUD controllers do not call `$this->authorize`.
- Route group name/comment says admin, but middleware does not enforce admin.
- Vendor ownership is not enforced on products/services.
- Public tracking exposes orders by numeric ID.

### Input validation

Strengths:

- Controllers use `$request->validate`.
- File uploads validate image MIME and size.
- IDs validate with `exists`.
- Status values are constrained with `in`.

Risks:

- Validation is inline and duplicated.
- No Form Request classes for most new marketplace/logistics flows.
- No DB check constraints for rating, quantities, and enum consistency.
- Public forms may be vulnerable to spam without rate limiting or CAPTCHA.
- Search input is safely parameter-bound by Eloquent, but there is no length limit in public search controller.

### File upload handling

Strengths:

- Uploads are restricted to image MIME extensions.
- Upload size is limited.

Risks:

- Files are moved directly into public directories.
- Original client filename is retained after timestamp prefix.
- No random hash filename.
- No image re-encoding/sanitization.
- No virus scanning.
- No private disk or CDN abstraction.
- No file deletion on record deletion.
- No validation of image dimensions.

### Vulnerabilities and risks

- High: broken access control for admin routes.
- High: public order tracking enumeration.
- High: stock race condition can oversell products.
- Medium: public reviews can be spammed and displayed immediately.
- Medium: uploaded public files are not processed or isolated.
- Medium: quote/order/customer PII is stored without privacy controls, retention rules, or access auditing.
- Medium: no audit logs for admin changes to orders, quotes, shipments, vehicles, products, or vendors.

## 9. Improvement Roadmap

### Phase 1: Fix Foundation

Tasks:

- Add roles and permissions: `admin`, `vendor`, `customer`.
- Add middleware such as `role:admin` for admin CRUD routes.
- Add `user_id` to `orders` and `quote_requests` where applicable.
- Normalize model names: `Service`, `ServiceImage`, `ServiceRequest`.
- Fix `services_img` relationship and consider migration rename to `service_images.service_id`.
- Remove or fully integrate legacy `property_details`, `logistics_details`, and `service_requests`.
- Add DB indexes for frequent filters:
  - products: `status`, `category_id`, `vendor_id`
  - services: `status`, `category_id`, `vendor_id`
  - orders: `status`, `type`, `created_at`
  - shipments: `status`, `vehicle_id`, `order_id`
  - quote_requests: `status`
- Move order placement into transaction-backed action classes.
- Replace public tracking by ID with signed URLs or tracking tokens.

Why it matters:

- This phase fixes the dangerous security and data integrity issues that would block production use.

### Phase 2: Core Marketplace Features

Tasks:

- Implement cart table/session cart.
- Implement checkout with shipping/billing address capture.
- Integrate payment provider.
- Add payment status and transaction tables.
- Add product SKU, variants, and inventory ledger.
- Add order item snapshots for title, SKU, vendor, and item metadata.
- Add order confirmation email jobs.
- Add customer order history.
- Add vendor dashboard and vendor-owned product/service management.
- Add review moderation and verified purchase reviews.

Why it matters:

- The current system collects order intent; this phase turns it into a real marketplace workflow.

### Phase 3: Logistics Enhancement

Tasks:

- Add quote acceptance workflow.
- Convert accepted quote into logistics order.
- Allow shipment creation from accepted quote/order.
- Add shipment tracking events table:
  - shipment_id
  - status
  - location
  - notes
  - occurred_at
  - created_by
- Add driver model and driver assignment.
- Add proof-of-delivery attachments/signature.
- Add vehicle maintenance/documents.
- Add capacity matching and availability checks.
- Add customer shipment notifications.
- Add support for product-order shipments, not only logistics-type orders.

Why it matters:

- This phase changes logistics from a manual note/status module into an operational workflow.

### Phase 4: Production Readiness

Tasks:

- Add audit logs for admin changes.
- Add rate limiting and CAPTCHA/honeypot for public forms.
- Move uploads to Laravel Storage with hashed filenames and cloud-compatible disks.
- Add queue-backed mail/notifications.
- Add automated tests for:
  - order placement
  - stock decrement
  - authorization
  - quote workflow
  - shipment vehicle status transitions
  - review validation/moderation
- Add backup strategy.
- Add error monitoring and application logging.
- Add caching for public catalogs/categories.
- Add full-text search or external search service.
- Add CI pipeline for tests, Pint, and static analysis.
- Add privacy/data retention policy for customer PII.

Why it matters:

- This phase prepares the system for real users, real money, operational accountability, and maintainable growth.

## 10. Production Readiness Score

### Architecture: 4/10

The app follows Laravel MVC and has a reasonable first-pass data model for products, services, vendors, orders, shipments, and quotes. However, the architecture is still MVP-level. Controllers contain business logic, legacy tables remain, model naming is inconsistent, and core workflows are not separated into domain actions. The polymorphic order item design is promising, but missing snapshots and transactions limit reliability.

### Security: 2/10

Authentication exists, but authorization is the critical failure. All verified users can access routes that are effectively admin functions. Public order tracking uses numeric IDs. Public forms can be spammed. Uploaded files are written directly to public paths. This is not acceptable for production without immediate remediation.

### Scalability: 3/10

The system will work for a small demo dataset. It lacks important indexes, caching, queues, object storage, full-text search, transactional stock handling, and operational event models. The design would struggle under real marketplace traffic or concurrent ordering.

### UX: 5/10

The public browsing/order flow is simple and likely usable for a prototype. Admin CRUD pages cover many operational tasks. However, key expected workflows are missing: cart, checkout, account order history, payment, quote acceptance, vendor dashboard, shipment event tracking, and review moderation. The UX is lead-generation quality, not marketplace quality.

### Overall production readiness: 3.5/10

The project is a useful MVP foundation and demonstrates the right broad modules, but it is not production-ready. The most urgent blockers are authorization, order/payment integrity, stock concurrency, public tracking privacy, and incomplete logistics workflow. With a focused foundation phase, it can become a credible platform; without that, it remains a demo with real security and data risks.
