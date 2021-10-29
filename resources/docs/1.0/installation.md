# Installation
it's very easy to create a new project with 3x1 framework, thanks for Packagist <i class="fa fa-heart text-danger"></i>
<hr>

<a name="install">
## Install
</a>

```bash
composer create-project --prefer-dist 3x1io/3x1
```

<hr>

<a name="env">
## Setup .env
</a>

Go to project folder
```bash
cd 3x1
```
And than edit .env file:

```dotenv
APP_NAME=3x1
APP_URL=https://3x1.test
APP_DOMAIN=3x1.test
DB_DATABASE=3x1
DB_USERNAME=root
DB_PASSWORD=3x1
```

Clear cache to reset .env vars

```bash
php artisan config:cache
```

<hr>

<a name="migration">
## Run Migrations
</a>

Now you ready for migration run

```bash
php artisan migrate
```

<hr>

<a name="mix">
## Mix Assets
</a>

Now install npm modules
```bash
npm i
```

Run npm dev
```bash
npm run dev
```
<hr>

<a name="admin">
## View
</a>

use this username `admin@3x1.io` and password `3x1@2021`

1. Using Laravel Valet: visit `yourdomain.test/admin/login`.
2. Using Laravel serve: `http://127.0.0.1:8000/admin/login`.

- [Install](#install)
- [Setup .env](#env)
- [Migration](#migration)
- [Mix](#mix)
- [View](#admin)

