<?php

// 1) install spatie -- composer require spatie/laravel-activitylog

// 2) add activity in .env file -- ACTIVITY_LOGGER_DB_CONNECTION=true

// 3) clear config file -- php artisan config:clear

// 4) php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"


// SQL: select * from `products` where exists (select * from `stocks` where `products`.`product_id` = `stocks`.`id` and `active_product` = product stock is available and `stocks`.`deleted_at` is null) and `products`.`deleted_at` is null

//  select * from `template_names` where exists (select * from `template_field_details` where `template_names`.`id` = `template_field_details`.`template_name_id` and `template_name_id` = ? and `template_field_details`.`deleted_at` is null) and `template_names`.`deleted_at` is null

