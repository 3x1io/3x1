- [Install BackBox Linux](#linux)
- [Install dependencies packages](#packages)
- [Install PHP & it's extensions](#php)
- [Install MySql Server](#mysql)
- [Install Composer](#composer)
- [Install Valet Linux+](#valet)


# Environment Setup
this steps to make our framework development environment run perfectly and without any errors, thanks for Linux and Laravel Valet for suppport that

<hr>

<a name="linux">
## Install BackBox Linux
</a>

we are like to use <a href="https://www.backbox.org/download/" target="_blank">BackBox</a> Linux it's has a lot of tools and support our environment, so form the link we support download the ISO image and put it in USB using <a href="https://rufus.ie/en/">Rufus</a> and than boot your computer into it

<hr>

<a name="packages">
## Install dependencies packages
</a>
let's start by open our terminal and update the system to the last one, and after that install some packages

```bash
sudo apt-get update
```

```bash
sudo apt-get upgrade
```

after it finished reboot your computer and after that run this command

```bash
sudo apt-get install network-manager libnss3-tools jq xsel
```

<hr>


<a name="php">
## Install PHP & it's extensions
</a>
```bash
sudo apt install php8.0-fpm
```

```bash
sudo apt install php8.0-cli php8.0-common php8.0-curl php8.0-mbstring php8.0-opcache php8.0-readline php8.0-xml php8.0-zip php8.0-mysql php8.0-gd
```
<hr>


<a name="mysql">
## Install MySql Server
</a>

```bash
sudo apt-get -y install mysql-server
```

```bash
sudo mysql_secure_installation
```

use `0` for password and use any password something like `12345678`

after the installation finished, start mysql server

```bash
sudo mysql
```

and on the mysql server console use this command 

```bash
mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '12345678';
```
```bash
mysql> FLUSH PRIVILEGES;
```
```bash
mysql> exit;
```
<hr>

<a name="composer">
## Install Composer 
</a>

```bash
sudo apt install curl
```

```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```
<hr>

<a name="valet">
## Install Valet Linux+
</a>

```bash
composer global require genesisweb/valet-linux-plus
```

no you need to export Valet use
```bash
PATH="$PATH:$HOME/.composer/vendor/bin"
```
Or use the following
```bash
PATH="$PATH:$HOME/.config/composer/vendor/bin"
```

and now it will be easy to start install valet 

```bash
valet install
```

it will ask you for a password input `12345678`

<hr>



