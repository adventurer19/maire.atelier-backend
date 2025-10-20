<?php

// lang/bg/enums.php

return [
    'order_status' => [
        'pending' => 'В изчакване',
        'processing' => 'Обработва се',
        'shipped' => 'Изпратена',
        'delivered' => 'Доставена',
        'cancelled' => 'Анулирана',
        'refunded' => 'Възстановена',
    ],

    'payment_status' => [
        'pending' => 'Изчаква плащане',
        'paid' => 'Платена',
        'failed' => 'Неуспешна',
        'refunded' => 'Възстановена',
    ],

    'product_status' => [
        'draft' => 'Чернова',
        'active' => 'Активен',
        'archived' => 'Архивиран',
        'out_of_stock' => 'Няма наличност',
    ],

    'user_role' => [
        'customer' => 'Клиент',
        'admin' => 'Администратор',
    ],
];
