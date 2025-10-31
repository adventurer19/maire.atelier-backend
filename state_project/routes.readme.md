📘 Публично API (без auth)
Method	Endpoint	Контролер	Описание
GET	/api/health	closure	Health check – връща {status, timestamp, locale, version}
GET	/api/products	ProductController@index	Листинг на активни продукти (пагиниран)
GET	/api/products/featured	ProductController@featured	Featured продукти
GET	/api/products/{slug}	ProductController@show	Детайли за продукт по slug
GET	/api/search?q=...	ProductController@search	Търсене по име, описание, SKU
GET	/api/categories	CategoryController@index	Листинг на категории
GET	/api/categories/{slug}	CategoryController@show	Детайли за категория
GET	/api/collections	CollectionController@index	Листинг на колекции
GET	/api/collections/{slug}	CollectionController@show	Детайли за колекция
GET	/api/cart	CartController@index	Връща текущата количка (guest или user)
GET	/api/cart/count	CartController@count	Връща броя артикули в количката
POST	/api/cart/items	CartController@addItem	Добавяне на продукт в количката
PUT	/api/cart/items/{item}	CartController@updateItem	Обновяване на количков артикул
DELETE	/api/cart/items/{item}	CartController@removeItem	Премахване на артикул
DELETE	/api/cart	CartController@clear	Изчистване на количката
POST	/api/cart/validate	CartController@validateCart	Проверка на количката (stock, цени и т.н.)
🔐 Authentication API (Sanctum)
Method	Endpoint	Контролер	Описание
POST	/api/register	AuthController@register	Регистрация на потребител
POST	/api/login	AuthController@login	Логин – връща Bearer Token
GET	/api/user	AuthController@user	Данни за текущия потребител (auth:sanctum)
POST	/api/logout	AuthController@logout	Изход от текущата сесия (auth:sanctum)
POST	/api/logout-all	AuthController@logoutAll	Изход от всички устройства (auth:sanctum)
🧾 Order / Checkout API (изисква auth:sanctum)
Method	Endpoint	Контролер	Описание
GET	/api/orders	OrderController@index	Списък с поръчки на текущия потребител
GET	/api/orders/{order}	OrderController@show	Детайли за конкретна поръчка
POST	/api/orders	OrderController@store	Създаване на нова поръчка (checkout)
POST	/api/orders/{order}/cancel	OrderController@cancel	Отмяна на поръчка (ако е допустимо)
💖 Wishlist API (auth:sanctum)
Method	Endpoint	Контролер	Описание
GET	/api/wishlist	WishlistController@index	Листинг на продукти в желани
POST	/api/wishlist	WishlistController@add	Добавяне на продукт
DELETE	/api/wishlist/{product}	WishlistController@remove	Премахване от желани
POST	/api/wishlist/toggle/{product}	WishlistController@toggle	Добавя/премахва в зависимост от състоянието
🏠 Addresses API (auth:sanctum)
Method	Endpoint	Контролер	Описание
GET	/api/addresses	AddressController@index	Списък адреси на потребителя
GET	/api/addresses/{id}	AddressController@show	Детайли за адрес
POST	/api/addresses	AddressController@store	Добавяне на нов адрес
PUT/PATCH	/api/addresses/{id}	AddressController@update	Обновяване на адрес
DELETE	/api/addresses/{id}	AddressController@destroy	Изтриване на адрес
🛠️ Admin API (auth:sanctum + admin middleware)
Method	Endpoint	Контролер	Описание
GET	/api/admin/dashboard/stats	closure	Статистика: orders, products, users
GET	/api/admin/orders/export	closure	Експорт на поръчки
GET	/api/admin/products/export	closure	Експорт на продукти
POST	/api/admin/products/bulk-update	closure	Масово обновяване на продукти

(възможно е по-късно тук да влязат и CRUD контролери като Admin\ProductController, Admin\CategoryController и т.н.)

🧩 Общо открити endpoint-и
Категория	Брой
Public API	~15
Auth API	5
Orders API	4
Wishlist API	4
Address API	5
Admin API	4
Общо	≈37 JSON endpoint-а
🔎 Примерна структура за документация (Swagger/Scribe)

Ако искаш да генерираме OpenAPI (Swagger), можеш да използваш:

composer require knuckleswtf/scribe --dev
php artisan scribe:generate


Това ще ти направи /docs страница с всички endpoint-и, примерни JSON отговори и auth flow.

🧭 Обобщение

✅ Твоето JSON API вече покрива пълния decoupled eCommerce бекенд слой:

продукти, категории, колекции

количка и checkout

auth и user info

wishlist и адреси

базов админ панел чрез middleware

💡 Какво можем да добавим следващо (по roadmap):

/api/v1 namespace + versioning

OpenAPI (Swagger / Scribe) документация

Rate limiting и caching middleware

Разделяне на Admin namespace за бъдещи CRUD endpoint-и

Тестове за основните JSON ресурси

Искаш ли следващата стъпка да е генериране на OpenAPI / Swagger спецификация за всичките тези endpoint-и (за да имаш /api/docs автоматично)?
