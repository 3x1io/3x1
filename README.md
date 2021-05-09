
<br />
<p align="center">
  <a href="https://3x1.io">
    <img src='https://svgshare.com/i/WCM.svg' width="150px;">
  </a>

  <h3 align="center">3x1 Framework</h3>

  <p align="center">
    Full Stack Web Framework Build in Laravel & Craftable
    <br />
    <a href="https://github.com/3x1io/3x1"><strong>Explore the docs »</strong></a>

  </p>
</p>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li>
      <a href="#usage">Usage</a>
      <ul>
        <li><a href="#generator">Generator</a></li>
        <li><a href="#widgets">Widgets</a></li>
        <li><a href="#themes">Theme Manager</a></li>
        <li><a href="#locations">Locations & GPS</a></li>
        <li><a href="#notifications">Notifications</a></li>
        <li><a href="#setting">Settings</a></li>
      </ul>
    </li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

### Review This Packages First
Thanks for this packages that's create our framework base
- [Carftable](https://www.getcraftable.com/) [It's a Core Folder & CURD Generator & Admin Panel]
- [Infyom](https://www.infyom.com/open-source) [APIs Scaffolding]
- [Barcode](https://github.com/milon/barcode) [Generate Barcode]
- [Tenancy](https://tenancyforlaravel.com/) [SaaS]
- [Gravatar](https://github.com/creativeorange/gravatar) [Profile Avatar]
- [Sweet Alert](https://github.com/realrashid/sweet-alert) [Alerts]
- [Laravel](https://laravel.com/) [Main Framework]
- [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) [APIs Token Auth]
- [Laravel Socialite](https://laravel.com/docs/8.x/socialite) [Social Media Links]
- [Laravel Permission](https://spatie.be/docs/laravel-permission/v4/introduction) [User ACL]
- [Laravel Widgets](https://packagist.org/packages/arrilot/laravel-widgets) [Widgets]
- [Laravel Module](https://nwidart.com/laravel-modules/v6/introduction) [MVC Modular Arch]
- [Laravel Excel](https://laravel-excel.com/) [Import & Export Excel]
- [Laravel Sitemap](https://github.com/spatie/laravel-sitemap) [Sitemap Generator]
- [Laravel Translatable](https://github.com/spatie/laravel-translatable) [Translation]
- [Laravel Media Library](https://github.com/spatie/laravel-medialibrary) [Media & Upload]
- [Laravel Backup](https://github.com/spatie/laravel-backup) [Backup]
### Installation
1. create a new 3x1 project
```bash
composer create-project --prefer-dist 3x1io/3x1
```
2. go to project folder
```bash
cd 3x1
```
3. Go to .env file and change:
```dotenv
APP_NAME=3x1
APP_URL=https://3x1.test
APP_DOMAIN=3x1.test
DB_DATABASE=3x1
DB_USERNAME=root
DB_PASSWORD=3x1
```
4. clear cache to reset .env vars

```bash
php artisan config:cache
```
5. now you ready for migration run

```bash
php artisan migrate
```
6. now install npm modules
```bash
npm i
```
7. run npm watch
```bash
npm run dev
```
8. Go to app/Providers/AppServiceProvider in boot function add this code

```PHP
Config::set('mail.mailers.smtp', [
    'transport' => 'smtp',
    'host' => setting('email.host'),
    'port' => setting('email.port'),
    'encryption' => setting('email.encryption'),
    'username' => setting('email.username'),
    'password' => setting('email.password'),
    'timeout' => null,
    'auth_mode' => null,
]);

Config::set('mail.from', [
    'address' => setting('email.from'),
    'name' => setting('email.from.name'),
]);

Config::set('broadcasting.connections.pusher', [
    'driver' => 'pusher',
    'key' => setting('pusher.key'),
    'secret' => setting('pusher.secret'),
    'app_id' => setting('pusher.app_id'),
    'options' => [
        'cluster' => setting('pusher.cluster'),
        'useTLS' => true,
    ],
]);

Config::set('services.messagebird', [
    'access_key' => setting('messagebird.access_key'),
    'originator' => setting('messagebird.originator'),
    'recipients' => setting('messagebird.recipients'),
]);

JavaScript::put([
    'pusherKey' => setting('pusher.key'),
]);

if(auth('admin')->user()){
    JavaScript::put([
        'authId' => auth('admin')->user()->id
    ]);
}
else {
    JavaScript::put([
        'authId' => null
    ]);
}
```

### Generator
you can easy generate CURD operations with controllers and views and routes and every thing with just one command
1. first create new migration
```bash
php artisan make:migration create_customers_table
```
2. build your schema and run
```bash
php artisan migrate
```
3. after migration load npm watch
```bash
npm run watch
```
4. now you ready for generator
```bash
php artisan admin:generate customers --with-export
```
5. it will generate every thing for you 
- [App/Exports/CustomersExport] `Excel Export` 
- [App/Http/Controllers/Admin/CustomersController] `CURD Controller`
- [App/Http/Requests/Admin/Customer] `CURD Validation Requests`
- [App/Models/Customer.php] `Model`
- [database/factories/ModelFactory.php] `Model Factory`
- [routes/web.php] `CURD Route` 
- [resources/views/admin] `CURD Views`
- [resources/views/admin/layout/sidebar.blade.php] `Sidebar Link` 
- [resources/js/admin/customer] `Vue Components`
- [resources/lang/en/admin.php] `Languages Assets`

### Widgets
now it's very easy to make a widget like counter of user or products in your dashboard home for documentation [arrilot/laravel-widgets](https://github.com/arrilot/laravel-widgets)

### Themes
our framework support front theme by easy way you can add a new theme by this way
1. create a new folder inside **resources/views/themes** wuth you theme name
2. inside this folder create a new json file named **info.json**
3. inside this json file add this info about theme
```json
{
    "name": "3x1 Theme",
    "ar": "3x1 ثيم",
    "description": "3x1 Theme Is Default Theme Of 3x1 Framework",
    "description_ar": "الثيم الافتراضي",
    "keywords": [],
    "aliases": "3x1",
    "files": [],
    "requires": [],
    "image": "placeholder.webp"
}
```
4. the `aliases` must be the same as folder name
5. go to **routes/themes** and create new routes file for your theme with the same theme name
6. add your theme assets to path **public/themes/THEME_NAME/**
7. now go to route **admin/themes** and you will show your theme name you can active it

our theme manager has some helper functions like
```php
theme_assets()
```
this function take `url` make it easy to access your theme path **public/themes/THEME_NAME/**

### Locations
in the homepage of dashboard you will see google map and it will ask you for location access to take your longitude and latitude and put it in the map and it's easy to change **Google Map Key** by change it in location setting in this route **admin/localization**

we save the longitude and latitude on the admin table with fields `lang` & `lat` for future use

you can change any string in the system by using **Translation** function by adding any string in
```php
trans('your sting')
//OR
__('your sting')
```
and go to route **admin/translations** and make rescan and you will get the string you add on the table and you can set it to any thing you went

you can import and export translation as excel sheet and a new languages by change the config in **config/translatable**

you can access a lot of location features by helper function like
```php
dollar()
```
it will echo the selected currency IOS with tag `<small>EGP</small>`

### Notifications
you build notification system with **[Pusher](https://pusher.com/)**

to use Notification System 
1. create a pusher account
2. create a new pusher chanel for your project
3. go to route **admin/services/pusher** and change data with yours and save

now you connected with pusher and you can send WebNotification to all users or selected user by GUI go to route **admin/user-notifications** and create new notification

you can use notification by event PushNotification
```php
event(new PushNotifcation($title, $message, $icon, $image, $url,$type, $authId))
```
it's take some params 
- $title `Title Of Notification`
- $message `The Message Of Notification`
- $icon `Font Awesome Icon like fa-user`
- $url `url of onclick event`
- $image `image for WebPushNotification`
- $type `Type of Notification [all, user]`
- $authId `Selected User ID`

you can get user notification by use helper 
```php
get_notifications()
```
it will get all user unread notifications as array

### Settings
to create a new setting it's easy by use GUI 
1. go to route **/admin/settings/dev**
2. create new setting by add
- group `the group of setting`
- key `the key you will use to get setting value`
- value `the value you went`

you can use setting helper by call this function on any where
```php 
setting($key);
```
it's take on param `key` to get value of this setting 

and to show settings input on any view you can use this helper
```php 
setting_show($key, $label, $type, $option=[], $id="");
```
it's take some params 
- $key `Key Of Setting`
- $label `Description Of this setting`
- $type `Type Of Input [text, textarea, select, checkbox, email, password, rang]`
- $option `If Type is select you can send options as array like sening User::all()`
- $id `it's use for 2 way one way for every inputs to add a custome id and for select to select what field you went to show in value`

now in the controller to update your setting you can use this helper
```php
setting_update($key, $value);
```
it's take some params 
- $key `Key Of Setting`
- $value `The Value You Get In the request to update it`

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact

Your Name - [@3x1io](https://twitter.com/3x1io) - info@3x1.io

Project Link: [https://github.com/3x1io/3x1](https://github.com/3x1io/3x1)
