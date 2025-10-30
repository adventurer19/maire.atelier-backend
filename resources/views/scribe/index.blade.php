<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>maire.atelier API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://maire.atelier.test";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.5.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.5.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-health">
                                <a href="#endpoints-GETapi-health">GET api/health</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-products">
                                <a href="#endpoints-GETapi-products">GET /api/products
List all active products with optional category filter and pagination.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-products-featured">
                                <a href="#endpoints-GETapi-products-featured">GET /api/products/featured
Retrieve featured products (non-paginated).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-products--product_slug-">
                                <a href="#endpoints-GETapi-products--product_slug-">GET /api/products/{slug}
Retrieve a single product by slug.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-categories">
                                <a href="#endpoints-GETapi-categories">GET /api/categories
Returns all active categories with basic info</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-categories--slug-">
                                <a href="#endpoints-GETapi-categories--slug-">GET /api/categories/{slug}
Returns a single category with its products</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-collections">
                                <a href="#endpoints-GETapi-collections">GET /api/collections
List all collections (paginated or full).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-collections--collection_slug-">
                                <a href="#endpoints-GETapi-collections--collection_slug-">GET /api/collections/{id}
Retrieve a single collection by ID or slug.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-search">
                                <a href="#endpoints-GETapi-search">GET /api/search?q=dress
Search products by keyword with pagination.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-cart">
                                <a href="#endpoints-GETapi-cart">GET /api/cart
Retrieve the current cart with items and summary.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-cart-count">
                                <a href="#endpoints-GETapi-cart-count">GET /api/cart/count
Retrieve only the number of items in the cart.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-cart-items">
                                <a href="#endpoints-POSTapi-cart-items">POST /api/cart/items
Add an item to the cart.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-cart-items--item-">
                                <a href="#endpoints-PUTapi-cart-items--item-">PUT /api/cart/items/{itemId}
Update the quantity of a cart item.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-cart-items--item-">
                                <a href="#endpoints-DELETEapi-cart-items--item-">DELETE /api/cart/items/{itemId}
Remove a specific item from the cart.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-cart">
                                <a href="#endpoints-DELETEapi-cart">DELETE /api/cart
Clear all items from the cart.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-cart-validate">
                                <a href="#endpoints-POSTapi-cart-validate">POST /api/cart/checkout/validate
Validate the cart before checkout.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-register">
                                <a href="#endpoints-POSTapi-register">POST /api/register
Register a new user and issue an API token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-login">
                                <a href="#endpoints-POSTapi-login">POST /api/login
Authenticate a user and issue a new token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                                <a href="#endpoints-GETapi-user">GET /api/user
Retrieve the currently authenticated user's details.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-logout">
                                <a href="#endpoints-POSTapi-logout">POST /api/logout
Revoke the current API token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-logout-all">
                                <a href="#endpoints-POSTapi-logout-all">POST /api/logout-all
Revoke all issued API tokens for the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-orders">
                                <a href="#endpoints-GETapi-orders">GET /api/orders
List all orders for the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-orders--order-">
                                <a href="#endpoints-GETapi-orders--order-">GET /api/orders/{id}
Retrieve details of a single order by ID.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-orders">
                                <a href="#endpoints-POSTapi-orders">POST /api/orders
Create a new order from the current cart.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-orders--order--cancel">
                                <a href="#endpoints-POSTapi-orders--order--cancel">PUT /api/orders/{id}/cancel
Cancel an existing order.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-wishlist">
                                <a href="#endpoints-GETapi-wishlist">GET /api/wishlist
Display all wishlist items for current user or guest token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-addresses">
                                <a href="#endpoints-GETapi-addresses">GET /api/addresses
List all addresses for the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-addresses">
                                <a href="#endpoints-POSTapi-addresses">POST /api/addresses
Create a new address for the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-addresses--id-">
                                <a href="#endpoints-GETapi-addresses--id-">GET /api/addresses/{id}
Retrieve a specific address by ID (must belong to current user).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-addresses--id-">
                                <a href="#endpoints-PUTapi-addresses--id-">PUT /api/addresses/{id}
Update an existing address (only if owned by user).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-addresses--id-">
                                <a href="#endpoints-DELETEapi-addresses--id-">DELETE /api/addresses/{id}
Delete a specific address if owned by user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-admin-dashboard-stats">
                                <a href="#endpoints-GETapi-admin-dashboard-stats">GET api/admin/dashboard/stats</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-admin-orders-export">
                                <a href="#endpoints-GETapi-admin-orders-export">GET api/admin/orders/export</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-admin-products-export">
                                <a href="#endpoints-GETapi-admin-products-export">GET api/admin/products/export</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-admin-products-bulk-update">
                                <a href="#endpoints-POSTapi-admin-products-bulk-update">POST api/admin/products/bulk-update</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi--fallbackPlaceholder-">
                                <a href="#endpoints-GETapi--fallbackPlaceholder-">GET api/{fallbackPlaceholder}</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: October 30, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://maire.atelier.test</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-health">GET api/health</h2>

<p>
</p>



<span id="example-requests-GETapi-health">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/health" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/health"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-health">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;timestamp&quot;: &quot;2025-10-30T09:21:15+00:00&quot;,
    &quot;locale&quot;: &quot;bg&quot;,
    &quot;version&quot;: &quot;1.0.0&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-health" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-health"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-health"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-health" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-health">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-health" data-method="GET"
      data-path="api/health"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-health', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-health"
                    onclick="tryItOut('GETapi-health');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-health"
                    onclick="cancelTryOut('GETapi-health');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-health"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/health</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-health"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-health"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-products">GET /api/products
List all active products with optional category filter and pagination.</h2>

<p>
</p>



<span id="example-requests-GETapi-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/products" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/products"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-products">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;sed-distinctio-quo-ut-vel-voluptatem&quot;,
            &quot;sku&quot;: &quot;SKU-57085&quot;,
            &quot;name&quot;: &quot;Et et voluptates&quot;,
            &quot;description&quot;: &quot;Et incidunt incidunt porro odio beatae omnis amet. Quo suscipit sunt rerum repudiandae natus. Vero tenetur laborum dolorem ex dolorem alias aliquid numquam.&quot;,
            &quot;short_description&quot;: &quot;Ut voluptate similique possimus dolorem quaerat autem enim.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;163.27&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 163.27,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 15,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/1/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/1/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/1/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/2/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 3,
                    &quot;slug&quot;: &quot;ea&quot;,
                    &quot;name&quot;: &quot;Ea&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;product_id&quot;: 1,
                    &quot;sku&quot;: &quot;SKU-57085-WHITE-M&quot;,
                    &quot;price&quot;: &quot;176.27&quot;,
                    &quot;final_price&quot;: 176.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 48,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/3/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/3/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/3/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / M - 176.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
                },
                {
                    &quot;id&quot;: 2,
                    &quot;product_id&quot;: 1,
                    &quot;sku&quot;: &quot;SKU-57085-WHITE-XL&quot;,
                    &quot;price&quot;: &quot;169.27&quot;,
                    &quot;final_price&quot;: 169.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 84,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/4/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/4/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/4/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / XL - 169.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
                },
                {
                    &quot;id&quot;: 3,
                    &quot;product_id&quot;: 1,
                    &quot;sku&quot;: &quot;SKU-57085-GREEN-M&quot;,
                    &quot;price&quot;: &quot;173.27&quot;,
                    &quot;final_price&quot;: 173.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 29,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/5/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/5/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/5/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / M - 173.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
                },
                {
                    &quot;id&quot;: 4,
                    &quot;product_id&quot;: 1,
                    &quot;sku&quot;: &quot;SKU-57085-GREEN-XL&quot;,
                    &quot;price&quot;: &quot;175.27&quot;,
                    &quot;final_price&quot;: 175.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 23,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/6/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/6/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/6/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / XL - 175.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: &quot;et-voluptatum-deleniti-odio-repellendus-repudiandae-et-dignissimos&quot;,
            &quot;sku&quot;: &quot;SKU-28174&quot;,
            &quot;name&quot;: &quot;Nisi dolore et&quot;,
            &quot;description&quot;: &quot;Rerum sequi fugiat cum repudiandae. Veniam dolor repellendus dignissimos voluptatem. Qui expedita error quis. Sit error minima tempora id quod unde cupiditate. Perspiciatis qui commodi ducimus dicta est.&quot;,
            &quot;short_description&quot;: &quot;Facilis asperiores asperiores expedita expedita fuga soluta sit.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;106.81&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 106.81,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 5,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/7/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/7/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/7/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/8/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/9/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;qui&quot;,
                    &quot;name&quot;: &quot;Qui&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 5,
                    &quot;product_id&quot;: 2,
                    &quot;sku&quot;: &quot;SKU-28174-BLACK-L&quot;,
                    &quot;price&quot;: &quot;118.81&quot;,
                    &quot;final_price&quot;: 118.81,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 38,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/10/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/10/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/10/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / L - 118.81 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:15.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:15.000000Z&quot;
                },
                {
                    &quot;id&quot;: 6,
                    &quot;product_id&quot;: 2,
                    &quot;sku&quot;: &quot;SKU-28174-BLACK-XL&quot;,
                    &quot;price&quot;: &quot;107.81&quot;,
                    &quot;final_price&quot;: 107.81,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 98,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/11/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/11/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/11/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / XL - 107.81 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:15.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:15.000000Z&quot;
                },
                {
                    &quot;id&quot;: 7,
                    &quot;product_id&quot;: 2,
                    &quot;sku&quot;: &quot;SKU-28174-RED-L&quot;,
                    &quot;price&quot;: &quot;106.81&quot;,
                    &quot;final_price&quot;: 106.81,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 69,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/12/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/12/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/12/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / L - 106.81 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:15.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:15.000000Z&quot;
                },
                {
                    &quot;id&quot;: 8,
                    &quot;product_id&quot;: 2,
                    &quot;sku&quot;: &quot;SKU-28174-RED-XL&quot;,
                    &quot;price&quot;: &quot;106.81&quot;,
                    &quot;final_price&quot;: 106.81,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 88,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/13/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/13/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/13/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / XL - 106.81 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:16.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:16.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: &quot;et-qui-omnis-quae-et-vitae-quod-at&quot;,
            &quot;sku&quot;: &quot;SKU-81245&quot;,
            &quot;name&quot;: &quot;Voluptatibus rerum libero&quot;,
            &quot;description&quot;: &quot;Illum reprehenderit qui optio dolorum hic sed aperiam similique. Nihil aut et non sit voluptas ut. Cum quo sed nam asperiores blanditiis aut voluptatem.&quot;,
            &quot;short_description&quot;: &quot;Iure rem eum eos aut fugiat.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;181.84&quot;,
            &quot;compare_at_price&quot;: &quot;231.84&quot;,
            &quot;discount_percentage&quot;: 22,
            &quot;final_price&quot;: 181.84,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 19,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/14/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/14/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/14/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/15/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/16/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/17/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 3,
                    &quot;slug&quot;: &quot;ea&quot;,
                    &quot;name&quot;: &quot;Ea&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 9,
                    &quot;product_id&quot;: 3,
                    &quot;sku&quot;: &quot;SKU-81245-WHITE-XL&quot;,
                    &quot;price&quot;: &quot;196.84&quot;,
                    &quot;final_price&quot;: 196.84,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 79,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/18/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/18/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/18/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / XL - 196.84 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;
                },
                {
                    &quot;id&quot;: 10,
                    &quot;product_id&quot;: 3,
                    &quot;sku&quot;: &quot;SKU-81245-WHITE-M&quot;,
                    &quot;price&quot;: &quot;192.84&quot;,
                    &quot;final_price&quot;: 192.84,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 7,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/19/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/19/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/19/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / M - 192.84 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;
                },
                {
                    &quot;id&quot;: 11,
                    &quot;product_id&quot;: 3,
                    &quot;sku&quot;: &quot;SKU-81245-BLACK-XL&quot;,
                    &quot;price&quot;: &quot;190.84&quot;,
                    &quot;final_price&quot;: 190.84,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 74,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/20/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/20/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/20/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / XL - 190.84 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;
                },
                {
                    &quot;id&quot;: 12,
                    &quot;product_id&quot;: 3,
                    &quot;sku&quot;: &quot;SKU-81245-BLACK-M&quot;,
                    &quot;price&quot;: &quot;184.84&quot;,
                    &quot;final_price&quot;: 184.84,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 5,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/21/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/21/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/21/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / M - 184.84 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:17.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 4,
            &quot;slug&quot;: &quot;occaecati-veniam-ut-illo-similique-eius&quot;,
            &quot;sku&quot;: &quot;SKU-22499&quot;,
            &quot;name&quot;: &quot;Natus praesentium odio&quot;,
            &quot;description&quot;: &quot;Saepe aut perspiciatis exercitationem deserunt officia. Rerum ratione harum ipsum ut placeat et facere.&quot;,
            &quot;short_description&quot;: &quot;Sed tenetur distinctio alias recusandae deleniti cumque non nobis.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;68.51&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 68.51,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 4,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: true,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/22/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/22/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/22/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/23/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/24/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;pariatur&quot;,
                    &quot;name&quot;: &quot;Pariatur&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 13,
                    &quot;product_id&quot;: 4,
                    &quot;sku&quot;: &quot;SKU-22499-BLUE-L&quot;,
                    &quot;price&quot;: &quot;75.51&quot;,
                    &quot;final_price&quot;: 75.51,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 85,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/25/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/25/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/25/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / L - 75.51 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:18.000000Z&quot;
                },
                {
                    &quot;id&quot;: 14,
                    &quot;product_id&quot;: 4,
                    &quot;sku&quot;: &quot;SKU-22499-BLUE-S&quot;,
                    &quot;price&quot;: &quot;80.51&quot;,
                    &quot;final_price&quot;: 80.51,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 81,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/26/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/26/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/26/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / S - 80.51 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:18.000000Z&quot;
                },
                {
                    &quot;id&quot;: 15,
                    &quot;product_id&quot;: 4,
                    &quot;sku&quot;: &quot;SKU-22499-BLACK-L&quot;,
                    &quot;price&quot;: &quot;73.51&quot;,
                    &quot;final_price&quot;: 73.51,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 100,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/27/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/27/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/27/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / L - 73.51 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:18.000000Z&quot;
                },
                {
                    &quot;id&quot;: 16,
                    &quot;product_id&quot;: 4,
                    &quot;sku&quot;: &quot;SKU-22499-BLACK-S&quot;,
                    &quot;price&quot;: &quot;73.51&quot;,
                    &quot;final_price&quot;: 73.51,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 22,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/28/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/28/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/28/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / S - 73.51 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:19.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:19.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 5,
            &quot;slug&quot;: &quot;dolorem-aliquid-consequatur-dolorum-accusamus&quot;,
            &quot;sku&quot;: &quot;SKU-55614&quot;,
            &quot;name&quot;: &quot;Ea voluptatum optio&quot;,
            &quot;description&quot;: &quot;Dolore aut quaerat non itaque facilis enim. Doloribus ut quia sunt sunt. Sit nisi ipsam blanditiis maxime ut qui.&quot;,
            &quot;short_description&quot;: &quot;Veniam eos at quia quasi quod voluptatibus sint.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;161.40&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 161.4,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 13,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: true,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/29/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/29/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/29/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/30/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/31/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/32/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;qui&quot;,
                    &quot;name&quot;: &quot;Qui&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 17,
                    &quot;product_id&quot;: 5,
                    &quot;sku&quot;: &quot;SKU-55614-BLUE-XL&quot;,
                    &quot;price&quot;: &quot;166.40&quot;,
                    &quot;final_price&quot;: 166.4,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 16,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/33/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/33/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/33/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / XL - 166.40 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;
                },
                {
                    &quot;id&quot;: 18,
                    &quot;product_id&quot;: 5,
                    &quot;sku&quot;: &quot;SKU-55614-BLUE-M&quot;,
                    &quot;price&quot;: &quot;166.40&quot;,
                    &quot;final_price&quot;: 166.4,
                    &quot;is_active&quot;: false,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 21,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/34/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/34/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/34/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / M - 166.40 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;
                },
                {
                    &quot;id&quot;: 19,
                    &quot;product_id&quot;: 5,
                    &quot;sku&quot;: &quot;SKU-55614-RED-XL&quot;,
                    &quot;price&quot;: &quot;176.40&quot;,
                    &quot;final_price&quot;: 176.4,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 2,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/35/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/35/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/35/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / XL - 176.40 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;
                },
                {
                    &quot;id&quot;: 20,
                    &quot;product_id&quot;: 5,
                    &quot;sku&quot;: &quot;SKU-55614-RED-M&quot;,
                    &quot;price&quot;: &quot;170.40&quot;,
                    &quot;final_price&quot;: 170.4,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 73,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/36/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/36/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/36/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / M - 170.40 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:20.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 6,
            &quot;slug&quot;: &quot;nulla-corporis-ratione-sit-eveniet&quot;,
            &quot;sku&quot;: &quot;SKU-98478&quot;,
            &quot;name&quot;: &quot;Dolorum quia facere&quot;,
            &quot;description&quot;: &quot;Qui consequatur harum veritatis sunt officia in. Minima asperiores quo autem asperiores qui fugiat est. Ex et voluptas itaque perferendis architecto ipsa. Ut nemo sunt ut nulla provident eveniet.&quot;,
            &quot;short_description&quot;: &quot;Quidem incidunt sunt voluptas sed dolorem natus tempora ad.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;92.43&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 92.43,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 39,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/37/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/37/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/37/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/38/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/39/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/40/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 4,
                    &quot;slug&quot;: &quot;facere&quot;,
                    &quot;name&quot;: &quot;Facere&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 21,
                    &quot;product_id&quot;: 6,
                    &quot;sku&quot;: &quot;SKU-98478-RED-XL&quot;,
                    &quot;price&quot;: &quot;104.43&quot;,
                    &quot;final_price&quot;: 104.43,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 41,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/41/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/41/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/41/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / XL - 104.43 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:21.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:21.000000Z&quot;
                },
                {
                    &quot;id&quot;: 22,
                    &quot;product_id&quot;: 6,
                    &quot;sku&quot;: &quot;SKU-98478-RED-S&quot;,
                    &quot;price&quot;: &quot;96.43&quot;,
                    &quot;final_price&quot;: 96.43,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 66,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/42/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/42/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/42/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / S - 96.43 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:21.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:21.000000Z&quot;
                },
                {
                    &quot;id&quot;: 23,
                    &quot;product_id&quot;: 6,
                    &quot;sku&quot;: &quot;SKU-98478-WHITE-XL&quot;,
                    &quot;price&quot;: &quot;100.43&quot;,
                    &quot;final_price&quot;: 100.43,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 63,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/43/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/43/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/43/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 9,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;XL&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / XL - 100.43 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:21.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:21.000000Z&quot;
                },
                {
                    &quot;id&quot;: 24,
                    &quot;product_id&quot;: 6,
                    &quot;sku&quot;: &quot;SKU-98478-WHITE-S&quot;,
                    &quot;price&quot;: &quot;106.43&quot;,
                    &quot;final_price&quot;: 106.43,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 31,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/44/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/44/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/44/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / S - 106.43 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:22.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:22.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 7,
            &quot;slug&quot;: &quot;expedita-est-laboriosam-veniam-quasi-ut-velit&quot;,
            &quot;sku&quot;: &quot;SKU-02127&quot;,
            &quot;name&quot;: &quot;Assumenda aut aspernatur&quot;,
            &quot;description&quot;: &quot;Reprehenderit labore earum consequatur ut autem nihil dolorum. Dignissimos eos distinctio ut saepe error omnis deleniti. Quos voluptatem et voluptas accusantium.&quot;,
            &quot;short_description&quot;: &quot;Minima ratione expedita corporis et nam in consequuntur.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;118.68&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 118.68,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 23,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/45/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/45/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/45/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/46/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/47/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 4,
                    &quot;slug&quot;: &quot;facere&quot;,
                    &quot;name&quot;: &quot;Facere&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 25,
                    &quot;product_id&quot;: 7,
                    &quot;sku&quot;: &quot;SKU-02127-GREEN-S&quot;,
                    &quot;price&quot;: &quot;126.68&quot;,
                    &quot;final_price&quot;: 126.68,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 44,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/48/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/48/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/48/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / S - 126.68 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:22.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:22.000000Z&quot;
                },
                {
                    &quot;id&quot;: 26,
                    &quot;product_id&quot;: 7,
                    &quot;sku&quot;: &quot;SKU-02127-GREEN-L&quot;,
                    &quot;price&quot;: &quot;120.68&quot;,
                    &quot;final_price&quot;: 120.68,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 66,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/49/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/49/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/49/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / L - 120.68 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:23.000000Z&quot;
                },
                {
                    &quot;id&quot;: 27,
                    &quot;product_id&quot;: 7,
                    &quot;sku&quot;: &quot;SKU-02127-WHITE-S&quot;,
                    &quot;price&quot;: &quot;129.68&quot;,
                    &quot;final_price&quot;: 129.68,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 76,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/50/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/50/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/50/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / S - 129.68 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:23.000000Z&quot;
                },
                {
                    &quot;id&quot;: 28,
                    &quot;product_id&quot;: 7,
                    &quot;sku&quot;: &quot;SKU-02127-WHITE-L&quot;,
                    &quot;price&quot;: &quot;118.68&quot;,
                    &quot;final_price&quot;: 118.68,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 40,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/51/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/51/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/51/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / L - 118.68 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:23.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 8,
            &quot;slug&quot;: &quot;nihil-a-ullam-beatae-architecto-aut&quot;,
            &quot;sku&quot;: &quot;SKU-08686&quot;,
            &quot;name&quot;: &quot;Exercitationem nostrum iste&quot;,
            &quot;description&quot;: &quot;Est sunt nostrum sit mollitia omnis. Quibusdam aut voluptates quas optio voluptate dolores nobis maxime. Voluptas minima nemo et non.&quot;,
            &quot;short_description&quot;: &quot;In culpa alias ab nam id.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;126.05&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 126.05,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 26,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: true,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/52/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/52/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/52/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/53/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/54/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 4,
                    &quot;slug&quot;: &quot;facere&quot;,
                    &quot;name&quot;: &quot;Facere&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 29,
                    &quot;product_id&quot;: 8,
                    &quot;sku&quot;: &quot;SKU-08686-RED-S&quot;,
                    &quot;price&quot;: &quot;140.05&quot;,
                    &quot;final_price&quot;: 140.05,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 3,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/55/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/55/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/55/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / S - 140.05 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;
                },
                {
                    &quot;id&quot;: 30,
                    &quot;product_id&quot;: 8,
                    &quot;sku&quot;: &quot;SKU-08686-RED-L&quot;,
                    &quot;price&quot;: &quot;133.05&quot;,
                    &quot;final_price&quot;: 133.05,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 73,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/56/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/56/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/56/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 1,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Червен&quot;,
                            &quot;hex_color&quot;: &quot;#FF0000&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Червен / L - 133.05 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;
                },
                {
                    &quot;id&quot;: 31,
                    &quot;product_id&quot;: 8,
                    &quot;sku&quot;: &quot;SKU-08686-GREEN-S&quot;,
                    &quot;price&quot;: &quot;136.05&quot;,
                    &quot;final_price&quot;: 136.05,
                    &quot;is_active&quot;: false,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 76,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/57/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/57/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/57/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / S - 136.05 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;
                },
                {
                    &quot;id&quot;: 32,
                    &quot;product_id&quot;: 8,
                    &quot;sku&quot;: &quot;SKU-08686-GREEN-L&quot;,
                    &quot;price&quot;: &quot;126.05&quot;,
                    &quot;final_price&quot;: 126.05,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 37,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/58/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/58/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/58/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / L - 126.05 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:24.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 9,
            &quot;slug&quot;: &quot;est-nihil-consequatur-sed-perferendis-alias&quot;,
            &quot;sku&quot;: &quot;SKU-40539&quot;,
            &quot;name&quot;: &quot;Qui voluptates laudantium&quot;,
            &quot;description&quot;: &quot;Rerum dolorem saepe non exercitationem. Aliquam harum est similique dicta sed ut rerum non. Eum ab optio reprehenderit quia.&quot;,
            &quot;short_description&quot;: &quot;Quod omnis omnis dolores est est impedit placeat qui.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;101.47&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 101.47,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 19,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/59/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/59/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/59/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/60/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/61/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/62/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 4,
                    &quot;slug&quot;: &quot;facere&quot;,
                    &quot;name&quot;: &quot;Facere&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 33,
                    &quot;product_id&quot;: 9,
                    &quot;sku&quot;: &quot;SKU-40539-BLACK-S&quot;,
                    &quot;price&quot;: &quot;112.47&quot;,
                    &quot;final_price&quot;: 112.47,
                    &quot;is_active&quot;: false,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 98,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/63/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/63/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/63/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / S - 112.47 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:25.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:25.000000Z&quot;
                },
                {
                    &quot;id&quot;: 34,
                    &quot;product_id&quot;: 9,
                    &quot;sku&quot;: &quot;SKU-40539-BLACK-L&quot;,
                    &quot;price&quot;: &quot;109.47&quot;,
                    &quot;final_price&quot;: 109.47,
                    &quot;is_active&quot;: false,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 18,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/64/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/64/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/64/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / L - 109.47 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:25.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:25.000000Z&quot;
                },
                {
                    &quot;id&quot;: 35,
                    &quot;product_id&quot;: 9,
                    &quot;sku&quot;: &quot;SKU-40539-WHITE-S&quot;,
                    &quot;price&quot;: &quot;110.47&quot;,
                    &quot;final_price&quot;: 110.47,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 71,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/65/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/65/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/65/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / S - 110.47 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:25.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:25.000000Z&quot;
                },
                {
                    &quot;id&quot;: 36,
                    &quot;product_id&quot;: 9,
                    &quot;sku&quot;: &quot;SKU-40539-WHITE-L&quot;,
                    &quot;price&quot;: &quot;110.47&quot;,
                    &quot;final_price&quot;: 110.47,
                    &quot;is_active&quot;: false,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 54,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/66/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/66/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/66/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 5,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Бял&quot;,
                            &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Бял / L - 110.47 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:26.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:26.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 11,
            &quot;slug&quot;: &quot;amet-nihil-veniam-minima-nesciunt-id-molestiae&quot;,
            &quot;sku&quot;: &quot;SKU-54552&quot;,
            &quot;name&quot;: &quot;Qui voluptas totam&quot;,
            &quot;description&quot;: &quot;Itaque ut est veritatis et. Cum alias provident tempore quam aliquid. Numquam maxime provident excepturi sapiente sunt dolor. Quaerat eius odio optio eveniet non facilis.&quot;,
            &quot;short_description&quot;: &quot;Eius est natus qui nihil consectetur.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;102.27&quot;,
            &quot;compare_at_price&quot;: &quot;120.27&quot;,
            &quot;discount_percentage&quot;: 15,
            &quot;final_price&quot;: 102.27,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 28,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/74/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/74/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/74/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/75/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;qui&quot;,
                    &quot;name&quot;: &quot;Qui&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 41,
                    &quot;product_id&quot;: 11,
                    &quot;sku&quot;: &quot;SKU-54552-BLACK-M&quot;,
                    &quot;price&quot;: &quot;110.27&quot;,
                    &quot;final_price&quot;: 110.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 2,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/76/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/76/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/76/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / M - 110.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;
                },
                {
                    &quot;id&quot;: 42,
                    &quot;product_id&quot;: 11,
                    &quot;sku&quot;: &quot;SKU-54552-BLACK-L&quot;,
                    &quot;price&quot;: &quot;102.27&quot;,
                    &quot;final_price&quot;: 102.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 40,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/77/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/77/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/77/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / L - 102.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;
                },
                {
                    &quot;id&quot;: 43,
                    &quot;product_id&quot;: 11,
                    &quot;sku&quot;: &quot;SKU-54552-BLUE-M&quot;,
                    &quot;price&quot;: &quot;115.27&quot;,
                    &quot;final_price&quot;: 115.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 23,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/78/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/78/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/78/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / M - 115.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;
                },
                {
                    &quot;id&quot;: 44,
                    &quot;product_id&quot;: 11,
                    &quot;sku&quot;: &quot;SKU-54552-BLUE-L&quot;,
                    &quot;price&quot;: &quot;113.27&quot;,
                    &quot;final_price&quot;: 113.27,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 85,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/79/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/79/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/79/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / L - 113.27 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:28.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 12,
            &quot;slug&quot;: &quot;enim-ut-explicabo-assumenda-qui-magnam-deserunt&quot;,
            &quot;sku&quot;: &quot;SKU-22872&quot;,
            &quot;name&quot;: &quot;Ut beatae repellat&quot;,
            &quot;description&quot;: &quot;Voluptatem quo quos minus sunt vitae eos dolores officia. Ducimus veritatis autem quis dolorem. Ullam libero sit inventore et occaecati eum.&quot;,
            &quot;short_description&quot;: &quot;Accusantium quos assumenda officia consectetur aperiam est.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;107.88&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 107.88,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 9,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/80/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/80/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/80/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/81/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/82/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 5,
                    &quot;slug&quot;: &quot;soluta&quot;,
                    &quot;name&quot;: &quot;Soluta&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 45,
                    &quot;product_id&quot;: 12,
                    &quot;sku&quot;: &quot;SKU-22872-BLACK-L&quot;,
                    &quot;price&quot;: &quot;117.88&quot;,
                    &quot;final_price&quot;: 117.88,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 65,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/83/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/83/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/83/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / L - 117.88 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;
                },
                {
                    &quot;id&quot;: 46,
                    &quot;product_id&quot;: 12,
                    &quot;sku&quot;: &quot;SKU-22872-BLACK-S&quot;,
                    &quot;price&quot;: &quot;112.88&quot;,
                    &quot;final_price&quot;: 112.88,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 55,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/84/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/84/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/84/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 4,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Черен&quot;,
                            &quot;hex_color&quot;: &quot;#000000&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Черен / S - 112.88 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;
                },
                {
                    &quot;id&quot;: 47,
                    &quot;product_id&quot;: 12,
                    &quot;sku&quot;: &quot;SKU-22872-GREEN-L&quot;,
                    &quot;price&quot;: &quot;110.88&quot;,
                    &quot;final_price&quot;: 110.88,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 72,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/85/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/85/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/85/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / L - 110.88 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;
                },
                {
                    &quot;id&quot;: 48,
                    &quot;product_id&quot;: 12,
                    &quot;sku&quot;: &quot;SKU-22872-GREEN-S&quot;,
                    &quot;price&quot;: &quot;111.88&quot;,
                    &quot;final_price&quot;: 111.88,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 91,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/86/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/86/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/86/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 6,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;S&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / S - 111.88 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:29.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 13,
            &quot;slug&quot;: &quot;aut-ut-nam-nihil-voluptate-et-molestiae&quot;,
            &quot;sku&quot;: &quot;SKU-83193&quot;,
            &quot;name&quot;: &quot;Excepturi fugit non&quot;,
            &quot;description&quot;: &quot;Dolor iste deserunt veritatis odio illum et. Iusto aut atque iure ipsa assumenda accusamus dicta. Enim possimus et est minus quo unde nulla.&quot;,
            &quot;short_description&quot;: &quot;Eum quod ullam suscipit ut rerum reiciendis.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;128.48&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 128.48,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 13,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/87/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/87/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/87/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/88/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/89/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;qui&quot;,
                    &quot;name&quot;: &quot;Qui&quot;
                }
            ],
            &quot;variants&quot;: [
                {
                    &quot;id&quot;: 49,
                    &quot;product_id&quot;: 13,
                    &quot;sku&quot;: &quot;SKU-83193-GREEN-L&quot;,
                    &quot;price&quot;: &quot;139.48&quot;,
                    &quot;final_price&quot;: 139.48,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 32,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/90/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/90/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/90/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / L - 139.48 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:30.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:30.000000Z&quot;
                },
                {
                    &quot;id&quot;: 50,
                    &quot;product_id&quot;: 13,
                    &quot;sku&quot;: &quot;SKU-83193-GREEN-M&quot;,
                    &quot;price&quot;: &quot;135.48&quot;,
                    &quot;final_price&quot;: 135.48,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 35,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/91/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/91/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/91/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 2,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Зелен&quot;,
                            &quot;hex_color&quot;: &quot;#00FF00&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Зелен / M - 135.48 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:30.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:30.000000Z&quot;
                },
                {
                    &quot;id&quot;: 51,
                    &quot;product_id&quot;: 13,
                    &quot;sku&quot;: &quot;SKU-83193-BLUE-L&quot;,
                    &quot;price&quot;: &quot;137.48&quot;,
                    &quot;final_price&quot;: 137.48,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 45,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/92/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/92/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/92/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 8,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;L&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / L - 137.48 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:31.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:31.000000Z&quot;
                },
                {
                    &quot;id&quot;: 52,
                    &quot;product_id&quot;: 13,
                    &quot;sku&quot;: &quot;SKU-83193-BLUE-M&quot;,
                    &quot;price&quot;: &quot;139.48&quot;,
                    &quot;final_price&quot;: 139.48,
                    &quot;is_active&quot;: true,
                    &quot;is_in_stock&quot;: true,
                    &quot;stock_quantity&quot;: 17,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/93/conversions/600-thumb.jpg&quot;,
                    &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/93/conversions/600-large.jpg&quot;,
                    &quot;images&quot;: [
                        &quot;http://maire.atelier.test/storage/93/600.jpeg&quot;
                    ],
                    &quot;attributes&quot;: [
                        {
                            &quot;id&quot;: 3,
                            &quot;slug&quot;: &quot;color&quot;,
                            &quot;name&quot;: &quot;Цвят&quot;,
                            &quot;value&quot;: &quot;Син&quot;,
                            &quot;hex_color&quot;: &quot;#0000FF&quot;
                        },
                        {
                            &quot;id&quot;: 7,
                            &quot;slug&quot;: &quot;size&quot;,
                            &quot;name&quot;: &quot;Размер&quot;,
                            &quot;value&quot;: &quot;M&quot;,
                            &quot;hex_color&quot;: null
                        }
                    ],
                    &quot;label&quot;: &quot;Син / M - 139.48 BGN&quot;,
                    &quot;created_at&quot;: &quot;2025-10-21T14:12:31.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2025-10-21T14:12:31.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://maire.atelier.test/api/products?page=1&quot;,
        &quot;last&quot;: &quot;http://maire.atelier.test/api/products?page=2&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://maire.atelier.test/api/products?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 2,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;page&quot;: null,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://maire.atelier.test/api/products?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;page&quot;: 1,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http://maire.atelier.test/api/products?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;page&quot;: 2,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://maire.atelier.test/api/products?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;page&quot;: 2,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://maire.atelier.test/api/products&quot;,
        &quot;per_page&quot;: 12,
        &quot;to&quot;: 12,
        &quot;total&quot;: 14
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products" data-method="GET"
      data-path="api/products"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products"
                    onclick="tryItOut('GETapi-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products"
                    onclick="cancelTryOut('GETapi-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-products-featured">GET /api/products/featured
Retrieve featured products (non-paginated).</h2>

<p>
</p>



<span id="example-requests-GETapi-products-featured">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/products/featured" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/products/featured"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-products-featured">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 4,
            &quot;slug&quot;: &quot;occaecati-veniam-ut-illo-similique-eius&quot;,
            &quot;sku&quot;: &quot;SKU-22499&quot;,
            &quot;name&quot;: &quot;Natus praesentium odio&quot;,
            &quot;description&quot;: &quot;Saepe aut perspiciatis exercitationem deserunt officia. Rerum ratione harum ipsum ut placeat et facere.&quot;,
            &quot;short_description&quot;: &quot;Sed tenetur distinctio alias recusandae deleniti cumque non nobis.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;68.51&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 68.51,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 4,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: true,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/22/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/22/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/22/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/23/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/24/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;pariatur&quot;,
                    &quot;name&quot;: &quot;Pariatur&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 5,
            &quot;slug&quot;: &quot;dolorem-aliquid-consequatur-dolorum-accusamus&quot;,
            &quot;sku&quot;: &quot;SKU-55614&quot;,
            &quot;name&quot;: &quot;Ea voluptatum optio&quot;,
            &quot;description&quot;: &quot;Dolore aut quaerat non itaque facilis enim. Doloribus ut quia sunt sunt. Sit nisi ipsam blanditiis maxime ut qui.&quot;,
            &quot;short_description&quot;: &quot;Veniam eos at quia quasi quod voluptatibus sint.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;161.40&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 161.4,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 13,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: true,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/29/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/29/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/29/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/30/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/31/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/32/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 2,
                    &quot;slug&quot;: &quot;qui&quot;,
                    &quot;name&quot;: &quot;Qui&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 8,
            &quot;slug&quot;: &quot;nihil-a-ullam-beatae-architecto-aut&quot;,
            &quot;sku&quot;: &quot;SKU-08686&quot;,
            &quot;name&quot;: &quot;Exercitationem nostrum iste&quot;,
            &quot;description&quot;: &quot;Est sunt nostrum sit mollitia omnis. Quibusdam aut voluptates quas optio voluptate dolores nobis maxime. Voluptas minima nemo et non.&quot;,
            &quot;short_description&quot;: &quot;In culpa alias ab nam id.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;126.05&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 126.05,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 26,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: true,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/52/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/52/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/52/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/53/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/54/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 4,
                    &quot;slug&quot;: &quot;facere&quot;,
                    &quot;name&quot;: &quot;Facere&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 14,
            &quot;slug&quot;: &quot;ut-illum-et-aut-rerum-quia-omnis&quot;,
            &quot;sku&quot;: &quot;SKU-83788&quot;,
            &quot;name&quot;: &quot;Asperiores maiores ducimus&quot;,
            &quot;description&quot;: &quot;Beatae non in quas autem ea quo exercitationem. Perspiciatis voluptates assumenda facilis sed asperiores sed officia. Modi sint nihil repellendus pariatur reprehenderit totam excepturi. Aut soluta ipsam dolorem voluptatibus illum consectetur qui. Beatae repellendus quo adipisci quibusdam.&quot;,
            &quot;short_description&quot;: &quot;Tenetur omnis eius quasi quas voluptate.&quot;,
            &quot;meta_title&quot;: null,
            &quot;meta_description&quot;: null,
            &quot;price&quot;: &quot;85.05&quot;,
            &quot;compare_at_price&quot;: null,
            &quot;discount_percentage&quot;: null,
            &quot;final_price&quot;: 85.05,
            &quot;is_in_stock&quot;: true,
            &quot;is_low_stock&quot;: false,
            &quot;stock_quantity&quot;: 8,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: true,
            &quot;requires_shipping&quot;: true,
            &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/94/conversions/800-thumb.jpg&quot;,
            &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/94/conversions/800-large.jpg&quot;,
            &quot;images&quot;: [
                &quot;http://maire.atelier.test/storage/94/800.jpeg&quot;,
                &quot;http://maire.atelier.test/storage/95/800.jpeg&quot;
            ],
            &quot;categories&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;slug&quot;: &quot;pariatur&quot;,
                    &quot;name&quot;: &quot;Pariatur&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        }
    ],
    &quot;meta&quot;: {
        &quot;count&quot;: 4
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products-featured" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products-featured"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products-featured"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products-featured" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products-featured">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products-featured" data-method="GET"
      data-path="api/products/featured"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products-featured', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products-featured"
                    onclick="tryItOut('GETapi-products-featured');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products-featured"
                    onclick="cancelTryOut('GETapi-products-featured');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products-featured"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products/featured</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products-featured"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-products-featured"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-products--product_slug-">GET /api/products/{slug}
Retrieve a single product by slug.</h2>

<p>
</p>



<span id="example-requests-GETapi-products--product_slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/products/sed-distinctio-quo-ut-vel-voluptatem" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/products/sed-distinctio-quo-ut-vel-voluptatem"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-products--product_slug-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;slug&quot;: &quot;sed-distinctio-quo-ut-vel-voluptatem&quot;,
        &quot;sku&quot;: &quot;SKU-57085&quot;,
        &quot;name&quot;: &quot;Et et voluptates&quot;,
        &quot;description&quot;: &quot;Et incidunt incidunt porro odio beatae omnis amet. Quo suscipit sunt rerum repudiandae natus. Vero tenetur laborum dolorem ex dolorem alias aliquid numquam.&quot;,
        &quot;short_description&quot;: &quot;Ut voluptate similique possimus dolorem quaerat autem enim.&quot;,
        &quot;meta_title&quot;: null,
        &quot;meta_description&quot;: null,
        &quot;price&quot;: &quot;163.27&quot;,
        &quot;compare_at_price&quot;: null,
        &quot;discount_percentage&quot;: null,
        &quot;final_price&quot;: 163.27,
        &quot;is_in_stock&quot;: true,
        &quot;is_low_stock&quot;: false,
        &quot;stock_quantity&quot;: 15,
        &quot;is_active&quot;: true,
        &quot;is_featured&quot;: false,
        &quot;requires_shipping&quot;: true,
        &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/1/conversions/800-thumb.jpg&quot;,
        &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/1/conversions/800-large.jpg&quot;,
        &quot;images&quot;: [
            &quot;http://maire.atelier.test/storage/1/800.jpeg&quot;,
            &quot;http://maire.atelier.test/storage/2/800.jpeg&quot;
        ],
        &quot;categories&quot;: [
            {
                &quot;id&quot;: 3,
                &quot;slug&quot;: &quot;ea&quot;,
                &quot;name&quot;: &quot;Ea&quot;
            }
        ],
        &quot;variants&quot;: [
            {
                &quot;id&quot;: 3,
                &quot;product_id&quot;: 1,
                &quot;sku&quot;: &quot;SKU-57085-GREEN-M&quot;,
                &quot;price&quot;: &quot;173.27&quot;,
                &quot;final_price&quot;: 173.27,
                &quot;is_active&quot;: true,
                &quot;is_in_stock&quot;: true,
                &quot;stock_quantity&quot;: 29,
                &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/5/conversions/600-thumb.jpg&quot;,
                &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/5/conversions/600-large.jpg&quot;,
                &quot;images&quot;: [
                    &quot;http://maire.atelier.test/storage/5/600.jpeg&quot;
                ],
                &quot;attributes&quot;: [
                    {
                        &quot;id&quot;: 2,
                        &quot;slug&quot;: &quot;color&quot;,
                        &quot;name&quot;: &quot;Цвят&quot;,
                        &quot;value&quot;: &quot;Зелен&quot;,
                        &quot;hex_color&quot;: &quot;#00FF00&quot;
                    },
                    {
                        &quot;id&quot;: 7,
                        &quot;slug&quot;: &quot;size&quot;,
                        &quot;name&quot;: &quot;Размер&quot;,
                        &quot;value&quot;: &quot;M&quot;,
                        &quot;hex_color&quot;: null
                    }
                ],
                &quot;label&quot;: &quot;Зелен / M - 173.27 BGN&quot;,
                &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;product_id&quot;: 1,
                &quot;sku&quot;: &quot;SKU-57085-GREEN-XL&quot;,
                &quot;price&quot;: &quot;175.27&quot;,
                &quot;final_price&quot;: 175.27,
                &quot;is_active&quot;: true,
                &quot;is_in_stock&quot;: true,
                &quot;stock_quantity&quot;: 23,
                &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/6/conversions/600-thumb.jpg&quot;,
                &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/6/conversions/600-large.jpg&quot;,
                &quot;images&quot;: [
                    &quot;http://maire.atelier.test/storage/6/600.jpeg&quot;
                ],
                &quot;attributes&quot;: [
                    {
                        &quot;id&quot;: 2,
                        &quot;slug&quot;: &quot;color&quot;,
                        &quot;name&quot;: &quot;Цвят&quot;,
                        &quot;value&quot;: &quot;Зелен&quot;,
                        &quot;hex_color&quot;: &quot;#00FF00&quot;
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;slug&quot;: &quot;size&quot;,
                        &quot;name&quot;: &quot;Размер&quot;,
                        &quot;value&quot;: &quot;XL&quot;,
                        &quot;hex_color&quot;: null
                    }
                ],
                &quot;label&quot;: &quot;Зелен / XL - 175.27 BGN&quot;,
                &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
            },
            {
                &quot;id&quot;: 1,
                &quot;product_id&quot;: 1,
                &quot;sku&quot;: &quot;SKU-57085-WHITE-M&quot;,
                &quot;price&quot;: &quot;176.27&quot;,
                &quot;final_price&quot;: 176.27,
                &quot;is_active&quot;: true,
                &quot;is_in_stock&quot;: true,
                &quot;stock_quantity&quot;: 48,
                &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/3/conversions/600-thumb.jpg&quot;,
                &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/3/conversions/600-large.jpg&quot;,
                &quot;images&quot;: [
                    &quot;http://maire.atelier.test/storage/3/600.jpeg&quot;
                ],
                &quot;attributes&quot;: [
                    {
                        &quot;id&quot;: 5,
                        &quot;slug&quot;: &quot;color&quot;,
                        &quot;name&quot;: &quot;Цвят&quot;,
                        &quot;value&quot;: &quot;Бял&quot;,
                        &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                    },
                    {
                        &quot;id&quot;: 7,
                        &quot;slug&quot;: &quot;size&quot;,
                        &quot;name&quot;: &quot;Размер&quot;,
                        &quot;value&quot;: &quot;M&quot;,
                        &quot;hex_color&quot;: null
                    }
                ],
                &quot;label&quot;: &quot;Бял / M - 176.27 BGN&quot;,
                &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;product_id&quot;: 1,
                &quot;sku&quot;: &quot;SKU-57085-WHITE-XL&quot;,
                &quot;price&quot;: &quot;169.27&quot;,
                &quot;final_price&quot;: 169.27,
                &quot;is_active&quot;: true,
                &quot;is_in_stock&quot;: true,
                &quot;stock_quantity&quot;: 84,
                &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/4/conversions/600-thumb.jpg&quot;,
                &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/4/conversions/600-large.jpg&quot;,
                &quot;images&quot;: [
                    &quot;http://maire.atelier.test/storage/4/600.jpeg&quot;
                ],
                &quot;attributes&quot;: [
                    {
                        &quot;id&quot;: 5,
                        &quot;slug&quot;: &quot;color&quot;,
                        &quot;name&quot;: &quot;Цвят&quot;,
                        &quot;value&quot;: &quot;Бял&quot;,
                        &quot;hex_color&quot;: &quot;#FFFFFF&quot;
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;slug&quot;: &quot;size&quot;,
                        &quot;name&quot;: &quot;Размер&quot;,
                        &quot;value&quot;: &quot;XL&quot;,
                        &quot;hex_color&quot;: null
                    }
                ],
                &quot;label&quot;: &quot;Бял / XL - 169.27 BGN&quot;,
                &quot;created_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-21T14:12:14.000000Z&quot;
            }
        ],
        &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products--product_slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products--product_slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products--product_slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products--product_slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products--product_slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products--product_slug-" data-method="GET"
      data-path="api/products/{product_slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products--product_slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products--product_slug-"
                    onclick="tryItOut('GETapi-products--product_slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products--product_slug-"
                    onclick="cancelTryOut('GETapi-products--product_slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products--product_slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products/{product_slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products--product_slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-products--product_slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>product_slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_slug"                data-endpoint="GETapi-products--product_slug-"
               value="sed-distinctio-quo-ut-vel-voluptatem"
               data-component="url">
    <br>
<p>The slug of the product. Example: <code>sed-distinctio-quo-ut-vel-voluptatem</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-categories">GET /api/categories
Returns all active categories with basic info</h2>

<p>
</p>



<span id="example-requests-GETapi-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: &quot;qui&quot;,
            &quot;parent_id&quot;: null,
            &quot;name&quot;: &quot;Qui&quot;,
            &quot;description&quot;: &quot;Iusto temporibus quidem enim dicta.&quot;,
            &quot;meta_title&quot;: &quot;Qui&quot;,
            &quot;meta_description&quot;: &quot;Dolor eos omnis blanditiis.&quot;,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;show_in_menu&quot;: true
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: &quot;ea&quot;,
            &quot;parent_id&quot;: null,
            &quot;name&quot;: &quot;Ea&quot;,
            &quot;description&quot;: &quot;Ut velit aliquid voluptas voluptatem.&quot;,
            &quot;meta_title&quot;: &quot;Ea&quot;,
            &quot;meta_description&quot;: &quot;Ut fugit nihil et eius et excepturi.&quot;,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;show_in_menu&quot;: true
        },
        {
            &quot;id&quot;: 4,
            &quot;slug&quot;: &quot;facere&quot;,
            &quot;parent_id&quot;: null,
            &quot;name&quot;: &quot;Facere&quot;,
            &quot;description&quot;: &quot;Sunt unde aut nesciunt debitis suscipit sit placeat tempora.&quot;,
            &quot;meta_title&quot;: &quot;Facere&quot;,
            &quot;meta_description&quot;: &quot;Ipsa doloribus reiciendis perspiciatis qui.&quot;,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;show_in_menu&quot;: true
        },
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;pariatur&quot;,
            &quot;parent_id&quot;: null,
            &quot;name&quot;: &quot;Pariatur&quot;,
            &quot;description&quot;: &quot;Laudantium ut ut a accusamus laudantium nesciunt libero.&quot;,
            &quot;meta_title&quot;: &quot;Pariatur&quot;,
            &quot;meta_description&quot;: &quot;Quis soluta aperiam sint veniam.&quot;,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;show_in_menu&quot;: true
        },
        {
            &quot;id&quot;: 5,
            &quot;slug&quot;: &quot;soluta&quot;,
            &quot;parent_id&quot;: null,
            &quot;name&quot;: &quot;Soluta&quot;,
            &quot;description&quot;: &quot;Repellendus iusto eum quia vel.&quot;,
            &quot;meta_title&quot;: &quot;Soluta&quot;,
            &quot;meta_description&quot;: &quot;Eos nihil autem molestiae non dolores eligendi.&quot;,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;show_in_menu&quot;: true
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-categories" data-method="GET"
      data-path="api/categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-categories"
                    onclick="tryItOut('GETapi-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-categories"
                    onclick="cancelTryOut('GETapi-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-categories--slug-">GET /api/categories/{slug}
Returns a single category with its products</h2>

<p>
</p>



<span id="example-requests-GETapi-categories--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/categories/pariatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/categories/pariatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-categories--slug-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;category&quot;: {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;pariatur&quot;,
            &quot;parent_id&quot;: null,
            &quot;name&quot;: &quot;Pariatur&quot;,
            &quot;description&quot;: &quot;Laudantium ut ut a accusamus laudantium nesciunt libero.&quot;,
            &quot;meta_title&quot;: &quot;Pariatur&quot;,
            &quot;meta_description&quot;: &quot;Quis soluta aperiam sint veniam.&quot;,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;show_in_menu&quot;: true,
            &quot;products&quot;: [
                {
                    &quot;id&quot;: 4,
                    &quot;slug&quot;: &quot;occaecati-veniam-ut-illo-similique-eius&quot;,
                    &quot;name&quot;: &quot;Natus praesentium odio&quot;,
                    &quot;price&quot;: &quot;68.51&quot;,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/22/conversions/800-thumb.jpg&quot;
                },
                {
                    &quot;id&quot;: 14,
                    &quot;slug&quot;: &quot;ut-illum-et-aut-rerum-quia-omnis&quot;,
                    &quot;name&quot;: &quot;Asperiores maiores ducimus&quot;,
                    &quot;price&quot;: &quot;85.05&quot;,
                    &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/94/conversions/800-thumb.jpg&quot;
                }
            ]
        },
        &quot;breadcrumb&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;slug&quot;: &quot;pariatur&quot;,
                &quot;name&quot;: &quot;Pariatur&quot;
            }
        ],
        &quot;products&quot;: [
            {
                &quot;id&quot;: 4,
                &quot;slug&quot;: &quot;occaecati-veniam-ut-illo-similique-eius&quot;,
                &quot;sku&quot;: &quot;SKU-22499&quot;,
                &quot;name&quot;: &quot;Natus praesentium odio&quot;,
                &quot;description&quot;: &quot;Saepe aut perspiciatis exercitationem deserunt officia. Rerum ratione harum ipsum ut placeat et facere.&quot;,
                &quot;short_description&quot;: &quot;Sed tenetur distinctio alias recusandae deleniti cumque non nobis.&quot;,
                &quot;meta_title&quot;: null,
                &quot;meta_description&quot;: null,
                &quot;price&quot;: &quot;68.51&quot;,
                &quot;compare_at_price&quot;: null,
                &quot;discount_percentage&quot;: null,
                &quot;final_price&quot;: 68.51,
                &quot;is_in_stock&quot;: true,
                &quot;is_low_stock&quot;: false,
                &quot;stock_quantity&quot;: 4,
                &quot;is_active&quot;: true,
                &quot;is_featured&quot;: true,
                &quot;requires_shipping&quot;: true,
                &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/22/conversions/800-thumb.jpg&quot;,
                &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/22/conversions/800-large.jpg&quot;,
                &quot;images&quot;: [
                    &quot;http://maire.atelier.test/storage/22/800.jpeg&quot;,
                    &quot;http://maire.atelier.test/storage/23/800.jpeg&quot;,
                    &quot;http://maire.atelier.test/storage/24/800.jpeg&quot;
                ],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;slug&quot;: &quot;pariatur&quot;,
                        &quot;name&quot;: &quot;Pariatur&quot;
                    }
                ],
                &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
            },
            {
                &quot;id&quot;: 10,
                &quot;slug&quot;: &quot;atque-ut-distinctio-reprehenderit-minus&quot;,
                &quot;sku&quot;: &quot;SKU-58244&quot;,
                &quot;name&quot;: &quot;Dicta nesciunt dolores&quot;,
                &quot;description&quot;: &quot;Et itaque doloremque perferendis hic repudiandae et. Architecto aut ducimus et et consequatur. Hic et voluptas vel repellat quidem eius at. Blanditiis sequi commodi officia rerum et explicabo. Harum non dicta itaque.&quot;,
                &quot;short_description&quot;: &quot;Cupiditate fugiat inventore odit iure ut quidem.&quot;,
                &quot;meta_title&quot;: null,
                &quot;meta_description&quot;: null,
                &quot;price&quot;: &quot;54.25&quot;,
                &quot;compare_at_price&quot;: null,
                &quot;discount_percentage&quot;: null,
                &quot;final_price&quot;: 54.25,
                &quot;is_in_stock&quot;: true,
                &quot;is_low_stock&quot;: false,
                &quot;stock_quantity&quot;: 30,
                &quot;is_active&quot;: false,
                &quot;is_featured&quot;: false,
                &quot;requires_shipping&quot;: true,
                &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/67/conversions/800-thumb.jpg&quot;,
                &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/67/conversions/800-large.jpg&quot;,
                &quot;images&quot;: [
                    &quot;http://maire.atelier.test/storage/67/800.jpeg&quot;,
                    &quot;http://maire.atelier.test/storage/68/800.jpeg&quot;,
                    &quot;http://maire.atelier.test/storage/69/800.jpeg&quot;
                ],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;slug&quot;: &quot;pariatur&quot;,
                        &quot;name&quot;: &quot;Pariatur&quot;
                    }
                ],
                &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
            },
            {
                &quot;id&quot;: 14,
                &quot;slug&quot;: &quot;ut-illum-et-aut-rerum-quia-omnis&quot;,
                &quot;sku&quot;: &quot;SKU-83788&quot;,
                &quot;name&quot;: &quot;Asperiores maiores ducimus&quot;,
                &quot;description&quot;: &quot;Beatae non in quas autem ea quo exercitationem. Perspiciatis voluptates assumenda facilis sed asperiores sed officia. Modi sint nihil repellendus pariatur reprehenderit totam excepturi. Aut soluta ipsam dolorem voluptatibus illum consectetur qui. Beatae repellendus quo adipisci quibusdam.&quot;,
                &quot;short_description&quot;: &quot;Tenetur omnis eius quasi quas voluptate.&quot;,
                &quot;meta_title&quot;: null,
                &quot;meta_description&quot;: null,
                &quot;price&quot;: &quot;85.05&quot;,
                &quot;compare_at_price&quot;: null,
                &quot;discount_percentage&quot;: null,
                &quot;final_price&quot;: 85.05,
                &quot;is_in_stock&quot;: true,
                &quot;is_low_stock&quot;: false,
                &quot;stock_quantity&quot;: 8,
                &quot;is_active&quot;: true,
                &quot;is_featured&quot;: true,
                &quot;requires_shipping&quot;: true,
                &quot;thumbnail&quot;: &quot;http://maire.atelier.test/storage/94/conversions/800-thumb.jpg&quot;,
                &quot;primary_image&quot;: &quot;http://maire.atelier.test/storage/94/conversions/800-large.jpg&quot;,
                &quot;images&quot;: [
                    &quot;http://maire.atelier.test/storage/94/800.jpeg&quot;,
                    &quot;http://maire.atelier.test/storage/95/800.jpeg&quot;
                ],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;slug&quot;: &quot;pariatur&quot;,
                        &quot;name&quot;: &quot;Pariatur&quot;
                    }
                ],
                &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
            }
        ],
        &quot;meta&quot;: {
            &quot;pagination&quot;: {
                &quot;total&quot;: 3,
                &quot;current_page&quot;: 1,
                &quot;last_page&quot;: 1
            }
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-categories--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-categories--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-categories--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-categories--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-categories--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-categories--slug-" data-method="GET"
      data-path="api/categories/{slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-categories--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-categories--slug-"
                    onclick="tryItOut('GETapi-categories--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-categories--slug-"
                    onclick="cancelTryOut('GETapi-categories--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-categories--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/categories/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-categories--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-categories--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-categories--slug-"
               value="pariatur"
               data-component="url">
    <br>
<p>The slug of the category. Example: <code>pariatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-collections">GET /api/collections
List all collections (paginated or full).</h2>

<p>
</p>



<span id="example-requests-GETapi-collections">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/collections" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/collections"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-collections">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;eveniet-aut-68f794bdb2177&quot;,
            &quot;type&quot;: &quot;auto&quot;,
            &quot;name&quot;: &quot;Nobis quisquam (BG)&quot;,
            &quot;description&quot;: &quot;Rerum et et quisquam qui adipisci nulla. (BG)&quot;,
            &quot;meta_title&quot;: &quot;Qui exercitationem. (BG)&quot;,
            &quot;meta_description&quot;: &quot;Dicta aut similique suscipit error dolore. (BG)&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;position&quot;: 2,
            &quot;conditions&quot;: null,
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: &quot;non-eius-68f794bdb2259&quot;,
            &quot;type&quot;: &quot;auto&quot;,
            &quot;name&quot;: &quot;Cupiditate ut (BG)&quot;,
            &quot;description&quot;: &quot;Dolorem cupiditate ex sit. (BG)&quot;,
            &quot;meta_title&quot;: &quot;Assumenda non. (BG)&quot;,
            &quot;meta_description&quot;: &quot;Sed nam possimus assumenda dolorum ut. (BG)&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;position&quot;: 3,
            &quot;conditions&quot;: null,
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: &quot;porro-doloremque-68f794bdb230d&quot;,
            &quot;type&quot;: &quot;manual&quot;,
            &quot;name&quot;: &quot;Cupiditate et (BG)&quot;,
            &quot;description&quot;: &quot;Sequi rem nobis itaque sed voluptas. (BG)&quot;,
            &quot;meta_title&quot;: &quot;Beatae autem unde. (BG)&quot;,
            &quot;meta_description&quot;: &quot;Sed magni inventore dolorem quis dolores accusantium ducimus. (BG)&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true,
            &quot;is_featured&quot;: false,
            &quot;position&quot;: 8,
            &quot;conditions&quot;: null,
            &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
        }
    ],
    &quot;meta&quot;: {
        &quot;pagination&quot;: {
            &quot;current_page&quot;: 1,
            &quot;per_page&quot;: 12,
            &quot;total&quot;: 3,
            &quot;last_page&quot;: 1
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-collections" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-collections"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-collections"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-collections" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-collections">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-collections" data-method="GET"
      data-path="api/collections"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-collections', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-collections"
                    onclick="tryItOut('GETapi-collections');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-collections"
                    onclick="cancelTryOut('GETapi-collections');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-collections"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/collections</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-collections"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-collections"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-collections--collection_slug-">GET /api/collections/{id}
Retrieve a single collection by ID or slug.</h2>

<p>
</p>



<span id="example-requests-GETapi-collections--collection_slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/collections/eveniet-aut-68f794bdb2177" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/collections/eveniet-aut-68f794bdb2177"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-collections--collection_slug-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;slug&quot;: &quot;eveniet-aut-68f794bdb2177&quot;,
        &quot;type&quot;: &quot;auto&quot;,
        &quot;name&quot;: &quot;Nobis quisquam (BG)&quot;,
        &quot;description&quot;: &quot;Rerum et et quisquam qui adipisci nulla. (BG)&quot;,
        &quot;meta_title&quot;: &quot;Qui exercitationem. (BG)&quot;,
        &quot;meta_description&quot;: &quot;Dicta aut similique suscipit error dolore. (BG)&quot;,
        &quot;image&quot;: null,
        &quot;is_active&quot;: true,
        &quot;is_featured&quot;: false,
        &quot;position&quot;: 2,
        &quot;conditions&quot;: null,
        &quot;created_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-10-21T14:12:13.000000Z&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-collections--collection_slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-collections--collection_slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-collections--collection_slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-collections--collection_slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-collections--collection_slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-collections--collection_slug-" data-method="GET"
      data-path="api/collections/{collection_slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-collections--collection_slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-collections--collection_slug-"
                    onclick="tryItOut('GETapi-collections--collection_slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-collections--collection_slug-"
                    onclick="cancelTryOut('GETapi-collections--collection_slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-collections--collection_slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/collections/{collection_slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-collections--collection_slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-collections--collection_slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>collection_slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="collection_slug"                data-endpoint="GETapi-collections--collection_slug-"
               value="eveniet-aut-68f794bdb2177"
               data-component="url">
    <br>
<p>The slug of the collection. Example: <code>eveniet-aut-68f794bdb2177</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-search">GET /api/search?q=dress
Search products by keyword with pagination.</h2>

<p>
</p>



<span id="example-requests-GETapi-search">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/search" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/search"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-search">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-search" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-search"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-search"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-search" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-search">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-search" data-method="GET"
      data-path="api/search"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-search', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-search"
                    onclick="tryItOut('GETapi-search');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-search"
                    onclick="cancelTryOut('GETapi-search');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-search"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/search</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-cart">GET /api/cart
Retrieve the current cart with items and summary.</h2>

<p>
</p>



<span id="example-requests-GETapi-cart">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/cart" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/cart"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-cart">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: {
        &quot;code&quot;: &quot;CART_FETCH_FAILED&quot;,
        &quot;message&quot;: &quot;common.something_went_wrong&quot;,
        &quot;details&quot;: {
            &quot;exception&quot;: &quot;SQLSTATE[42S22]: Column not found: 1054 Unknown column &#039;session_id&#039; in &#039;where clause&#039; (Connection: mysql, SQL: select * from `cart_items` where `session_id` = KVutkl9pls27G0GeJuVNQy9CbKPCcI3gpG09E1ad)&quot;
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-cart" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-cart"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cart"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-cart" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cart">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-cart" data-method="GET"
      data-path="api/cart"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-cart', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-cart"
                    onclick="tryItOut('GETapi-cart');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-cart"
                    onclick="cancelTryOut('GETapi-cart');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-cart"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/cart</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-cart-count">GET /api/cart/count
Retrieve only the number of items in the cart.</h2>

<p>
</p>



<span id="example-requests-GETapi-cart-count">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/cart/count" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/cart/count"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-cart-count">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: {
        &quot;code&quot;: &quot;CART_COUNT_FAILED&quot;,
        &quot;message&quot;: &quot;common.something_went_wrong&quot;,
        &quot;details&quot;: {
            &quot;exception&quot;: &quot;SQLSTATE[42S22]: Column not found: 1054 Unknown column &#039;session_id&#039; in &#039;where clause&#039; (Connection: mysql, SQL: select * from `cart_items` where `session_id` = KVutkl9pls27G0GeJuVNQy9CbKPCcI3gpG09E1ad)&quot;
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-cart-count" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-cart-count"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cart-count"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-cart-count" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cart-count">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-cart-count" data-method="GET"
      data-path="api/cart/count"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-cart-count', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-cart-count"
                    onclick="tryItOut('GETapi-cart-count');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-cart-count"
                    onclick="cancelTryOut('GETapi-cart-count');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-cart-count"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/cart/count</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-cart-count"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-cart-count"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-cart-items">POST /api/cart/items
Add an item to the cart.</h2>

<p>
</p>



<span id="example-requests-POSTapi-cart-items">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/cart/items" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"product_id\": \"architecto\",
    \"quantity\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/cart/items"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_id": "architecto",
    "quantity": 22
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-cart-items">
</span>
<span id="execution-results-POSTapi-cart-items" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-cart-items"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cart-items"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-cart-items" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cart-items">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-cart-items" data-method="POST"
      data-path="api/cart/items"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-cart-items', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-cart-items"
                    onclick="tryItOut('POSTapi-cart-items');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-cart-items"
                    onclick="cancelTryOut('POSTapi-cart-items');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-cart-items"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/cart/items</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-cart-items"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-cart-items"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="POSTapi-cart-items"
               value="architecto"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the products table. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="POSTapi-cart-items"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>variant_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="variant_id"                data-endpoint="POSTapi-cart-items"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the product_variants table.</p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-cart-items--item-">PUT /api/cart/items/{itemId}
Update the quantity of a cart item.</h2>

<p>
</p>



<span id="example-requests-PUTapi-cart-items--item-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://maire.atelier.test/api/cart/items/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"quantity\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/cart/items/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quantity": 1
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-cart-items--item-">
</span>
<span id="execution-results-PUTapi-cart-items--item-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-cart-items--item-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-cart-items--item-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-cart-items--item-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-cart-items--item-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-cart-items--item-" data-method="PUT"
      data-path="api/cart/items/{item}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-cart-items--item-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-cart-items--item-"
                    onclick="tryItOut('PUTapi-cart-items--item-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-cart-items--item-"
                    onclick="cancelTryOut('PUTapi-cart-items--item-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-cart-items--item-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/cart/items/{item}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-cart-items--item-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-cart-items--item-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>item</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="item"                data-endpoint="PUTapi-cart-items--item-"
               value="architecto"
               data-component="url">
    <br>
<p>The item. Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="PUTapi-cart-items--item-"
               value="1"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-cart-items--item-">DELETE /api/cart/items/{itemId}
Remove a specific item from the cart.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-cart-items--item-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://maire.atelier.test/api/cart/items/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/cart/items/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-cart-items--item-">
</span>
<span id="execution-results-DELETEapi-cart-items--item-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-cart-items--item-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-cart-items--item-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-cart-items--item-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-cart-items--item-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-cart-items--item-" data-method="DELETE"
      data-path="api/cart/items/{item}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-cart-items--item-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-cart-items--item-"
                    onclick="tryItOut('DELETEapi-cart-items--item-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-cart-items--item-"
                    onclick="cancelTryOut('DELETEapi-cart-items--item-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-cart-items--item-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/cart/items/{item}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-cart-items--item-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-cart-items--item-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>item</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="item"                data-endpoint="DELETEapi-cart-items--item-"
               value="architecto"
               data-component="url">
    <br>
<p>The item. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-DELETEapi-cart">DELETE /api/cart
Clear all items from the cart.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-cart">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://maire.atelier.test/api/cart" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/cart"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-cart">
</span>
<span id="execution-results-DELETEapi-cart" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-cart"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-cart"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-cart" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-cart">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-cart" data-method="DELETE"
      data-path="api/cart"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-cart', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-cart"
                    onclick="tryItOut('DELETEapi-cart');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-cart"
                    onclick="cancelTryOut('DELETEapi-cart');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-cart"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/cart</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-cart-validate">POST /api/cart/checkout/validate
Validate the cart before checkout.</h2>

<p>
</p>



<span id="example-requests-POSTapi-cart-validate">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/cart/validate" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/cart/validate"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-cart-validate">
</span>
<span id="execution-results-POSTapi-cart-validate" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-cart-validate"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cart-validate"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-cart-validate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cart-validate">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-cart-validate" data-method="POST"
      data-path="api/cart/validate"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-cart-validate', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-cart-validate"
                    onclick="tryItOut('POSTapi-cart-validate');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-cart-validate"
                    onclick="cancelTryOut('POSTapi-cart-validate');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-cart-validate"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/cart/validate</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-cart-validate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-cart-validate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-register">POST /api/register
Register a new user and issue an API token.</h2>

<p>
</p>



<span id="example-requests-POSTapi-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"email\": \"zbailey@example.net\",
    \"password\": \"-0pBNvYgxw\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-register">
</span>
<span id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-register" data-method="POST"
      data-path="api/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-register"
                    onclick="tryItOut('POSTapi-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-register"
                    onclick="cancelTryOut('POSTapi-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-register"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-register"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Must not be greater than 255 characters. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-register"
               value="-0pBNvYgxw"
               data-component="body">
    <br>
<p>Must be at least 8 characters. Example: <code>-0pBNvYgxw</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-login">POST /api/login
Authenticate a user and issue a new token.</h2>

<p>
</p>



<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"gbailey@example.net\",
    \"password\": \"|]|{+-\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "gbailey@example.net",
    "password": "|]|{+-"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
</span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-login"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-login"
               value="|]|{+-"
               data-component="body">
    <br>
<p>Example: <code>|]|{+-</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-user">GET /api/user
Retrieve the currently authenticated user&#039;s details.</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-logout">POST /api/logout
Revoke the current API token.</h2>

<p>
</p>



<span id="example-requests-POSTapi-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-logout">
</span>
<span id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-logout" data-method="POST"
      data-path="api/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-logout"
                    onclick="tryItOut('POSTapi-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-logout"
                    onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-logout-all">POST /api/logout-all
Revoke all issued API tokens for the authenticated user.</h2>

<p>
</p>



<span id="example-requests-POSTapi-logout-all">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/logout-all" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/logout-all"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-logout-all">
</span>
<span id="execution-results-POSTapi-logout-all" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-logout-all"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout-all"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-logout-all" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout-all">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-logout-all" data-method="POST"
      data-path="api/logout-all"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout-all', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-logout-all"
                    onclick="tryItOut('POSTapi-logout-all');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-logout-all"
                    onclick="cancelTryOut('POSTapi-logout-all');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-logout-all"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/logout-all</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-logout-all"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-logout-all"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-orders">GET /api/orders
List all orders for the authenticated user.</h2>

<p>
</p>



<span id="example-requests-GETapi-orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/orders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/orders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-orders">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-orders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-orders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-orders" data-method="GET"
      data-path="api/orders"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-orders"
                    onclick="tryItOut('GETapi-orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-orders"
                    onclick="cancelTryOut('GETapi-orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-orders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/orders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-orders--order-">GET /api/orders/{id}
Retrieve details of a single order by ID.</h2>

<p>
</p>



<span id="example-requests-GETapi-orders--order-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/orders/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/orders/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-orders--order-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-orders--order-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-orders--order-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-orders--order-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-orders--order-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-orders--order-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-orders--order-" data-method="GET"
      data-path="api/orders/{order}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-orders--order-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-orders--order-"
                    onclick="tryItOut('GETapi-orders--order-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-orders--order-"
                    onclick="cancelTryOut('GETapi-orders--order-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-orders--order-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/orders/{order}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-orders--order-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-orders--order-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>order</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="order"                data-endpoint="GETapi-orders--order-"
               value="1"
               data-component="url">
    <br>
<p>The order. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-orders">POST /api/orders
Create a new order from the current cart.</h2>

<p>
</p>



<span id="example-requests-POSTapi-orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/orders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/orders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-orders">
</span>
<span id="execution-results-POSTapi-orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-orders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-orders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-orders" data-method="POST"
      data-path="api/orders"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-orders"
                    onclick="tryItOut('POSTapi-orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-orders"
                    onclick="cancelTryOut('POSTapi-orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-orders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/orders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-orders--order--cancel">PUT /api/orders/{id}/cancel
Cancel an existing order.</h2>

<p>
</p>



<span id="example-requests-POSTapi-orders--order--cancel">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/orders/1/cancel" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/orders/1/cancel"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-orders--order--cancel">
</span>
<span id="execution-results-POSTapi-orders--order--cancel" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-orders--order--cancel"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-orders--order--cancel"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-orders--order--cancel" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-orders--order--cancel">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-orders--order--cancel" data-method="POST"
      data-path="api/orders/{order}/cancel"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-orders--order--cancel', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-orders--order--cancel"
                    onclick="tryItOut('POSTapi-orders--order--cancel');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-orders--order--cancel"
                    onclick="cancelTryOut('POSTapi-orders--order--cancel');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-orders--order--cancel"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/orders/{order}/cancel</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-orders--order--cancel"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-orders--order--cancel"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>order</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="order"                data-endpoint="POSTapi-orders--order--cancel"
               value="1"
               data-component="url">
    <br>
<p>The order. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-wishlist">GET /api/wishlist
Display all wishlist items for current user or guest token.</h2>

<p>
</p>



<span id="example-requests-GETapi-wishlist">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/wishlist" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/wishlist"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-wishlist">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-wishlist" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-wishlist"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-wishlist"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-wishlist" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-wishlist">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-wishlist" data-method="GET"
      data-path="api/wishlist"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-wishlist', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-wishlist"
                    onclick="tryItOut('GETapi-wishlist');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-wishlist"
                    onclick="cancelTryOut('GETapi-wishlist');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-wishlist"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/wishlist</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-wishlist"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-wishlist"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-addresses">GET /api/addresses
List all addresses for the authenticated user.</h2>

<p>
</p>



<span id="example-requests-GETapi-addresses">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/addresses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-addresses">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-addresses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-addresses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-addresses" data-method="GET"
      data-path="api/addresses"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-addresses"
                    onclick="tryItOut('GETapi-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-addresses"
                    onclick="cancelTryOut('GETapi-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-addresses"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/addresses</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-addresses">POST /api/addresses
Create a new address for the authenticated user.</h2>

<p>
</p>



<span id="example-requests-POSTapi-addresses">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/addresses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"type\": \"architecto\",
    \"first_name\": \"n\",
    \"last_name\": \"g\",
    \"company\": \"z\",
    \"address_line_1\": \"m\",
    \"address_line_2\": \"i\",
    \"city\": \"y\",
    \"state\": \"v\",
    \"postal_code\": \"dljnikhwaykcmyuw\",
    \"country\": \"pw\",
    \"phone\": \"l\",
    \"is_default\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "architecto",
    "first_name": "n",
    "last_name": "g",
    "company": "z",
    "address_line_1": "m",
    "address_line_2": "i",
    "city": "y",
    "state": "v",
    "postal_code": "dljnikhwaykcmyuw",
    "country": "pw",
    "phone": "l",
    "is_default": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-addresses">
</span>
<span id="execution-results-POSTapi-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-addresses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-addresses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-addresses" data-method="POST"
      data-path="api/addresses"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-addresses"
                    onclick="tryItOut('POSTapi-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-addresses"
                    onclick="cancelTryOut('POSTapi-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-addresses"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/addresses</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="POSTapi-addresses"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="first_name"                data-endpoint="POSTapi-addresses"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="last_name"                data-endpoint="POSTapi-addresses"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>company</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="company"                data-endpoint="POSTapi-addresses"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>z</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address_line_1</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address_line_1"                data-endpoint="POSTapi-addresses"
               value="m"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>m</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address_line_2</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address_line_2"                data-endpoint="POSTapi-addresses"
               value="i"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>i</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="POSTapi-addresses"
               value="y"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>y</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>state</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="state"                data-endpoint="POSTapi-addresses"
               value="v"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>v</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>postal_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="postal_code"                data-endpoint="POSTapi-addresses"
               value="dljnikhwaykcmyuw"
               data-component="body">
    <br>
<p>Must not be greater than 20 characters. Example: <code>dljnikhwaykcmyuw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>country</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="country"                data-endpoint="POSTapi-addresses"
               value="pw"
               data-component="body">
    <br>
<p>Must be 2 characters. Example: <code>pw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-addresses"
               value="l"
               data-component="body">
    <br>
<p>Must not be greater than 50 characters. Example: <code>l</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_default</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-addresses" style="display: none">
            <input type="radio" name="is_default"
                   value="true"
                   data-endpoint="POSTapi-addresses"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-addresses" style="display: none">
            <input type="radio" name="is_default"
                   value="false"
                   data-endpoint="POSTapi-addresses"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-addresses--id-">GET /api/addresses/{id}
Retrieve a specific address by ID (must belong to current user).</h2>

<p>
</p>



<span id="example-requests-GETapi-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-addresses--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-addresses--id-" data-method="GET"
      data-path="api/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-addresses--id-"
                    onclick="tryItOut('GETapi-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-addresses--id-"
                    onclick="cancelTryOut('GETapi-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTapi-addresses--id-">PUT /api/addresses/{id}
Update an existing address (only if owned by user).</h2>

<p>
</p>



<span id="example-requests-PUTapi-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://maire.atelier.test/api/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"first_name\": \"b\",
    \"last_name\": \"n\",
    \"company\": \"g\",
    \"address_line_1\": \"z\",
    \"address_line_2\": \"m\",
    \"city\": \"i\",
    \"state\": \"y\",
    \"postal_code\": \"vdljnikhwaykcmyu\",
    \"country\": \"wp\",
    \"phone\": \"w\",
    \"is_default\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "b",
    "last_name": "n",
    "company": "g",
    "address_line_1": "z",
    "address_line_2": "m",
    "city": "i",
    "state": "y",
    "postal_code": "vdljnikhwaykcmyu",
    "country": "wp",
    "phone": "w",
    "is_default": true
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-addresses--id-">
</span>
<span id="execution-results-PUTapi-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-addresses--id-" data-method="PUT"
      data-path="api/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-addresses--id-"
                    onclick="tryItOut('PUTapi-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-addresses--id-"
                    onclick="cancelTryOut('PUTapi-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/addresses/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="PUTapi-addresses--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="first_name"                data-endpoint="PUTapi-addresses--id-"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="last_name"                data-endpoint="PUTapi-addresses--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>company</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="company"                data-endpoint="PUTapi-addresses--id-"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address_line_1</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address_line_1"                data-endpoint="PUTapi-addresses--id-"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>z</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address_line_2</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address_line_2"                data-endpoint="PUTapi-addresses--id-"
               value="m"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>m</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="PUTapi-addresses--id-"
               value="i"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>i</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>state</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="state"                data-endpoint="PUTapi-addresses--id-"
               value="y"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>y</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>postal_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="postal_code"                data-endpoint="PUTapi-addresses--id-"
               value="vdljnikhwaykcmyu"
               data-component="body">
    <br>
<p>Must not be greater than 20 characters. Example: <code>vdljnikhwaykcmyu</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>country</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="country"                data-endpoint="PUTapi-addresses--id-"
               value="wp"
               data-component="body">
    <br>
<p>Must be 2 characters. Example: <code>wp</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PUTapi-addresses--id-"
               value="w"
               data-component="body">
    <br>
<p>Must not be greater than 50 characters. Example: <code>w</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_default</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-addresses--id-" style="display: none">
            <input type="radio" name="is_default"
                   value="true"
                   data-endpoint="PUTapi-addresses--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-addresses--id-" style="display: none">
            <input type="radio" name="is_default"
                   value="false"
                   data-endpoint="PUTapi-addresses--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-addresses--id-">DELETE /api/addresses/{id}
Delete a specific address if owned by user.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://maire.atelier.test/api/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-addresses--id-">
</span>
<span id="execution-results-DELETEapi-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-addresses--id-" data-method="DELETE"
      data-path="api/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-addresses--id-"
                    onclick="tryItOut('DELETEapi-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-addresses--id-"
                    onclick="cancelTryOut('DELETEapi-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-admin-dashboard-stats">GET api/admin/dashboard/stats</h2>

<p>
</p>



<span id="example-requests-GETapi-admin-dashboard-stats">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/admin/dashboard/stats" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/admin/dashboard/stats"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-admin-dashboard-stats">
    </span>
<span id="execution-results-GETapi-admin-dashboard-stats" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-admin-dashboard-stats"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-admin-dashboard-stats"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-admin-dashboard-stats" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-admin-dashboard-stats">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-admin-dashboard-stats" data-method="GET"
      data-path="api/admin/dashboard/stats"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-admin-dashboard-stats', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-admin-dashboard-stats"
                    onclick="tryItOut('GETapi-admin-dashboard-stats');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-admin-dashboard-stats"
                    onclick="cancelTryOut('GETapi-admin-dashboard-stats');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-admin-dashboard-stats"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/admin/dashboard/stats</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-admin-dashboard-stats"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-admin-dashboard-stats"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-admin-orders-export">GET api/admin/orders/export</h2>

<p>
</p>



<span id="example-requests-GETapi-admin-orders-export">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/admin/orders/export" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/admin/orders/export"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-admin-orders-export">
    </span>
<span id="execution-results-GETapi-admin-orders-export" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-admin-orders-export"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-admin-orders-export"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-admin-orders-export" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-admin-orders-export">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-admin-orders-export" data-method="GET"
      data-path="api/admin/orders/export"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-admin-orders-export', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-admin-orders-export"
                    onclick="tryItOut('GETapi-admin-orders-export');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-admin-orders-export"
                    onclick="cancelTryOut('GETapi-admin-orders-export');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-admin-orders-export"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/admin/orders/export</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-admin-orders-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-admin-orders-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-admin-products-export">GET api/admin/products/export</h2>

<p>
</p>



<span id="example-requests-GETapi-admin-products-export">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/admin/products/export" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/admin/products/export"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-admin-products-export">
    </span>
<span id="execution-results-GETapi-admin-products-export" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-admin-products-export"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-admin-products-export"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-admin-products-export" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-admin-products-export">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-admin-products-export" data-method="GET"
      data-path="api/admin/products/export"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-admin-products-export', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-admin-products-export"
                    onclick="tryItOut('GETapi-admin-products-export');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-admin-products-export"
                    onclick="cancelTryOut('GETapi-admin-products-export');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-admin-products-export"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/admin/products/export</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-admin-products-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-admin-products-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-admin-products-bulk-update">POST api/admin/products/bulk-update</h2>

<p>
</p>



<span id="example-requests-POSTapi-admin-products-bulk-update">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://maire.atelier.test/api/admin/products/bulk-update" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/admin/products/bulk-update"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-admin-products-bulk-update">
</span>
<span id="execution-results-POSTapi-admin-products-bulk-update" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-admin-products-bulk-update"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-admin-products-bulk-update"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-admin-products-bulk-update" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-admin-products-bulk-update">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-admin-products-bulk-update" data-method="POST"
      data-path="api/admin/products/bulk-update"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-admin-products-bulk-update', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-admin-products-bulk-update"
                    onclick="tryItOut('POSTapi-admin-products-bulk-update');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-admin-products-bulk-update"
                    onclick="cancelTryOut('POSTapi-admin-products-bulk-update');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-admin-products-bulk-update"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/admin/products/bulk-update</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-admin-products-bulk-update"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-admin-products-bulk-update"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi--fallbackPlaceholder-">GET api/{fallbackPlaceholder}</h2>

<p>
</p>



<span id="example-requests-GETapi--fallbackPlaceholder-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://maire.atelier.test/api/|{+-0p" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://maire.atelier.test/api/|{+-0p"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi--fallbackPlaceholder-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;ROUTE_NOT_FOUND&quot;,
    &quot;message&quot;: &quot;The requested endpoint does not exist.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi--fallbackPlaceholder-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi--fallbackPlaceholder-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi--fallbackPlaceholder-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi--fallbackPlaceholder-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi--fallbackPlaceholder-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi--fallbackPlaceholder-" data-method="GET"
      data-path="api/{fallbackPlaceholder}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi--fallbackPlaceholder-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi--fallbackPlaceholder-"
                    onclick="tryItOut('GETapi--fallbackPlaceholder-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi--fallbackPlaceholder-"
                    onclick="cancelTryOut('GETapi--fallbackPlaceholder-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi--fallbackPlaceholder-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/{fallbackPlaceholder}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi--fallbackPlaceholder-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi--fallbackPlaceholder-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>fallbackPlaceholder</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fallbackPlaceholder"                data-endpoint="GETapi--fallbackPlaceholder-"
               value="|{+-0p"
               data-component="url">
    <br>
<p>Example: <code>|{+-0p</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
