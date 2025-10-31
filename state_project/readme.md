Какво имаш в момента (обобщение)
•	Laravel: ^12 (PHP ^8.2), с Sanctum за auth.
•	Админ и tooling: Filament v3, Spatie пакети: permission, query-builder, translatable, sluggable, medialibrary.
•	Контролери (API): AddressController.php, AuthController.php, CartController.php, CategoryController.php, CollectionController.php, OrderController.php, ProductController.php, ReviewController.php, WishlistController.php.
•	Resources: ProductResource, ProductVariantResource, CategoryResource, OrderResource, CartItemResource, AddressResource, UserResource и др.
•	Form Requests: напр. AddToCartRequest, UpdateCartRequest, CheckoutRequest, има и UpdateProductRequest (добре за валидация).
•	Миграции: пълна продуктова схема – products, product_variants, product_attributes, връзки, и т.н. Има и поръчки, количка, адреси.
•	routes/api.php: вече има endpoints за:
•	продукти (листинг, featured, show по slug, търсене),
•	категории и колекции (по slug),
•	количка (CRUD на items + validate),
•	auth (register/login/logout/user),
•	поръчки (създаване/детайл/отмяна),
•	адреси (чрез Route::apiResource('addresses', …)),
•	wishlist.


Заключение: Имаш солидна база за публично API + нужните части за админ дейности. Следващата стойност е да „заковем“ стандартизация (версии, формати на отговори, филтри/сортировки, права, кеширане, документация) и да отделим ясно админ API от публично API.
