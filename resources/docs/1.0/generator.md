# CRUD Generator
You can easy generate CURD operations with controllers and views and routes and every thing with just one command, thanks for <b>Craftable</b> & <b>Infyom</b> for that <i class="fa fa-heart text-danger"></i>
<hr>

<a name="schema">
## Create Schema
</a>

our generator use `TABLE_NAME` to make a generate so it's must be table in database before start generate so let's start by make a new migration by this command, and let's for example use `Customers` schema to generate

```bash
php artisan make:migration create_customers_table
```

now to get a new migration file inside `database/migrations` with name of `Customers` schema, go to the file and edit it with your schema like this example

```php
Schema::create('customers', static function (Blueprint $table) {
    $table->increments('id');
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique()->nullable();
    $table->string('phone')->unique();
    $table->string('password');

    $table->boolean('activated')->default(false);
    $table->boolean('forbidden')->default(false);

    $table->timestamps();
});
```
now we when to convert this migration to database table to let's run this command:

```bash
php artisan migrate
```

<hr>

<a name="watcher">
## Load NPM Watcher
</a>

now you must do is to make `NPM` watch changes because our generator use vueJs in Front-end and it's need npm to compatible assets so it's must first of all install npm using `npm i`

```bash
npm run watch
```

<hr>

<a name="start">
## Start Generator
</a>

Now you ready to start generator command and get your files, this command has 2 options `--with-export` use to generate Excel sheet export & `--force` to overriding existing files, and the arg is the table name like in example `customers`

```bash
php artisan admin:generate customers --with-export
```

after you run this command our framework will generate for you this files

1. App/Exports/CustomersExport `Excel Export` <small>if use `--with-export` flag</small>
2. App/Http/Controllers/Admin/CustomersController`CURD Controller`
3. App/Http/Requests/Admin/Customer `CURD Validation Requests`
4. App/Models/Customer.php `Model`
5. database/factories/ModelFactory.php `Model Factory`
6. routes/web.php `CURD Route` 
7. resources/views/admin `CURD Views`
8. resources/views/admin/layout/sidebar.blade.php `Sidebar Link` 
9. resources/js/admin/customer `Vue Components`
10. resources/lang/en/admin.php `Languages Assets`

<hr>



- [Create Schema](#schema)
- [Load NPM Watcher](#watcher)
- [Start Generator](#start)

