<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'activated' => true,
        'created_at' => $faker->dateTime,
        'deleted_at' => null,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'last_login_at' => $faker->dateTime,
        'last_name' => $faker->lastName,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'updated_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Setting::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'group' => $faker->sentence,
        'key' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'value' => $faker->text(),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Role::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'guard_name' => $faker->sentence,
        'name' => $faker->firstName,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Permission::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'guard_name' => $faker->sentence,
        'name' => $faker->firstName,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'api_key' => $faker->sentence,
        'apps' => $faker->text(),
        'created_at' => $faker->dateTime,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'first_name' => $faker->firstName,
        'global_id' => $faker->sentence,
        'info' => $faker->text(),
        'last_name' => $faker->lastName,
        'name' => $faker->firstName,
        'password' => bcrypt($faker->password),
        'phone' => $faker->sentence,
        'remember_token' => null,
        'store' => $faker->sentence,
        'tenant_id' => $faker->sentence,
        'type' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'username' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Domain::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'domain' => $faker->sentence,
        'tenant_id' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Medium::class, static function (Faker\Generator $faker) {
    return [
        'collection_name' => $faker->sentence,
        'conversions_disk' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'disk' => $faker->sentence,
        'file_name' => $faker->sentence,
        'mime_type' => $faker->sentence,
        'model_id' => $faker->sentence,
        'model_type' => $faker->sentence,
        'name' => $faker->firstName,
        'order_column' => $faker->randomNumber(5),
        'size' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'uuid' => $faker->sentence,
        
        'custom_properties' => ['en' => $faker->sentence],
        'generated_conversions' => ['en' => $faker->sentence],
        'manipulations' => ['en' => $faker->sentence],
        'responsive_images' => ['en' => $faker->sentence],
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'activated' => $faker->boolean(),
        'api_key' => $faker->sentence,
        'apps' => $faker->text(),
        'blocked' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'first_name' => $faker->firstName,
        'global_id' => $faker->sentence,
        'info' => $faker->text(),
        'last_name' => $faker->lastName,
        'name' => $faker->firstName,
        'password' => bcrypt($faker->password),
        'phone' => $faker->sentence,
        'remember_token' => null,
        'store' => $faker->sentence,
        'tenant_id' => $faker->sentence,
        'type' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'username' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Customer::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'phone' => $faker->sentence,
        'email' => $faker->email,
        'address' => $faker->text(),
        'activated' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\UserNotification::class, static function (Faker\Generator $faker) {
    return [
        'sender_id' => $faker->sentence,
        'title' => $faker->sentence,
        'message' => $faker->text(),
        'icon' => $faker->sentence,
        'url' => $faker->sentence,
        'type' => $faker->sentence,
        'user_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Email::class, static function (Faker\Generator $faker) {
    return [
        'to_email' => $faker->sentence,
        'from_email' => $faker->sentence,
        'subject' => $faker->sentence,
        'message' => $faker->text(),
        'type' => $faker->sentence,
        'group_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Country::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'code' => $faker->sentence,
        'phone' => $faker->sentence,
        'lat' => $faker->sentence,
        'lang' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\City::class, static function (Faker\Generator $faker) {
    return [
        'country_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'lang' => $faker->sentence,
        'lat' => $faker->sentence,
        'name' => $faker->firstName,
        'price' => $faker->randomFloat,
        'shipping' => $faker->text(),
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Area::class, static function (Faker\Generator $faker) {
    return [
        'city_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'lang' => $faker->sentence,
        'lat' => $faker->sentence,
        'name' => $faker->firstName,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Currency::class, static function (Faker\Generator $faker) {
    return [
        'arabic' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'iso' => $faker->sentence,
        'name' => $faker->firstName,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Branch::class, static function (Faker\Generator $faker) {
    return [
        'address' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'in' => $faker->randomFloat,
        'name' => $faker->firstName,
        'out' => $faker->randomFloat,
        'phone' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Language::class, static function (Faker\Generator $faker) {
    return [
        'arabic' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'iso' => $faker->sentence,
        'name' => $faker->firstName,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Category::class, static function (Faker\Generator $faker) {
    return [
        'activated' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'description' => $faker->sentence,
        'menu' => $faker->boolean(),
        'name' => $faker->firstName,
        'parent_id' => $faker->sentence,
        'seo_id' => $faker->sentence,
        'slug' => $faker->unique()->slug,
        'sub' => $faker->boolean(),
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Tag::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'name' => $faker->firstName,
        'seo_id' => $faker->sentence,
        'slug' => $faker->unique()->slug,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Seo::class, static function (Faker\Generator $faker) {
    return [
        'buy' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'description' => $faker->text(),
        'keywords' => $faker->text(),
        'like' => $faker->randomFloat,
        'search' => $faker->randomFloat,
        'share' => $faker->randomFloat,
        'title' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'view' => $faker->randomFloat,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Section::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Section::class, static function (Faker\Generator $faker) {
    return [
        'button' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'description' => $faker->text(),
        'html' => $faker->text(),
        'order' => $faker->randomNumber(5),
        'subtitle' => $faker->sentence,
        'table' => $faker->sentence,
        'title' => $faker->sentence,
        'type' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'url' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Feature::class, static function (Faker\Generator $faker) {
    return [
        'button' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'description' => $faker->sentence,
        'icon' => $faker->sentence,
        'order' => $faker->randomNumber(5),
        'place' => $faker->sentence,
        'title' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'url' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Search::class, static function (Faker\Generator $faker) {
    return [
        'counter' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'last_searched' => $faker->date(),
        'search' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Ad::class, static function (Faker\Generator $faker) {
    return [
        'activated' => $faker->boolean(),
        'button' => $faker->sentence,
        'clicked' => $faker->randomFloat,
        'created_at' => $faker->dateTime,
        'description' => $faker->sentence,
        'subtitle' => $faker->sentence,
        'title' => $faker->sentence,
        'type' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'url' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Cart::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'customer_id' => $faker->sentence,
        'discount' => $faker->randomFloat,
        'fee' => $faker->randomFloat,
        'item' => $faker->sentence,
        'item_id' => $faker->sentence,
        'item_type' => $faker->sentence,
        'price' => $faker->randomFloat,
        'promo' => $faker->boolean(),
        'promo_id' => $faker->sentence,
        'qnt' => $faker->randomNumber(5),
        'ref_id' => $faker->sentence,
        'ref_type' => $faker->sentence,
        'return' => $faker->boolean(),
        'total' => $faker->randomFloat,
        'updated_at' => $faker->dateTime,
        'uuid' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Wishlist::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'customer_id' => $faker->sentence,
        'type' => $faker->sentence,
        'type_id' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
