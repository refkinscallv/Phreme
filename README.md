# Phreme - PHP Framework MVC

Phreme is a PHP framework offers a comprehensive set of features to streamline web development, including:

- MVC architecture
- Routing capabilities
- Dependency management via Composer
- MySQL query builder for database operations
- Common utility functions
- Model and library loading functionality
- Encrypted cookie support
- Cryptographic security encryption
- Request handling and sanitization for POST, GET, REQUEST, and SERVER variables

To set up your PHP Framework MVC with Composer and start building your web application, follow these detailed steps:

## Installation

### Clone or Download

First, clone the repository or download the source code to your local machine.

```bash
git clone https://github.com/refkinscallv/phreme.git
cd phreme
```

### Platform Configuration For PHP

In the composer.json file, adjust the PHP platform config according to the PHP version you are using.

```json
{
    ...
    "config": {
        "platform": {
            "php": "7.4"
        }
    }
}

```

### Install Dependencies

Make sure you have Composer installed on your system. Then, install the required dependencies by running:

```bash
composer install
```

### Environment Configuration

Next, configure your environment variables. Copy the `.env.example` file to `.env` and modify the values as per your setup.

```bash
cp .env.example .env
```

Edit the `.env` file with your preferred text editor:

```plaintext
# Application
APP_NAME            = "Your Application"
BASE_URL            = "http://your-domain.com/"

# Environment
ENVIRONMENT         = "development"

# Database
DB_HOST             = "localhost"
DB_USER             = "root"
DB_PASS             = ""
DB_NAME             = ""

# Security
CRYPT_PRIVATE_KEY   = "RANDOM_PRIVATE_KEY_HERE"
CRYPT_FILE          = "/crypt_storage/general.txt"
CRYPT_LIMIT         = 500000

# Cookie
COOKIE_NAME         = "COOKIE_NAME_HERE"
COOKIE_EXPIRE       = 48
COOKIE_FILE         = "/crypt_storage/cookie.txt"
```

### Create Controllers

Controllers are created in the `Apps/Controllers` directory. Here’s an example of how to create a simple controller:

Create a new file named `Home.php` in `Apps/Controllers`:

```php
<?php

    namespace Phreme\App\Controller;

    defined("PHREME") OR exit("Forbidden Access");

    class Home extends \Phreme\Systems\Controller {

        public function __construct(){
            parent::__construct();
        }

        public function index(){
            $this->load->view("home", [
                "title" => $_SERVER["APP_NAME"],
                "appName" => $_SERVER["APP_NAME"],
                "message" => "This PHP framework offers a comprehensive set of features to streamline web development",
            ]);
        }

    }
```

### Create Views

Views are created in the `Apps/Views` directory. Create view files as needed. Here’s an example view file:

Create a new file named `home.php` in `Apps/Views`:

```php
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
    <h1>Welcome to <?php echo $appName; ?></h1>
    <p><?php echo $message; ?></p>
</body>
</html>
```

### Set Routes

Before opening your web application. the next step is, set the route to find which route the controller will use to execute and then display on your web application page.

Open the `Routes.php` file in the `Apps/Routes` directory. Follow the existing example and modify it to your needs :

```php
<?php

    namespace Phreme\App\Route;

    defined("PHREME") OR exit("Forbidden Access");

    class Routes {

        public function __construct(){
            $this->route = new  \Phreme\Systems\Route();
        }
        
        /**
         * Define the routes.
         * 
         * @return void
         */
        public function run(): void {
            /**
             * Format to set route for controller
             * 
             * $this->route->set(#PATH, #CONTROLLER, #PARAM);
             * 
             * (String) #PATH : To indicate a controller will be used at a specific path in URL
             * (String) #CONTROLLER : A controller class to be used includes the directory where the controller file is located.
             * (Boolean) #PARAM : For permission to use parameters as values ​​in the controller
             */

            $this->route->setDefault("Home@index", true);
            $this->route->set("/about", "page/About@index", true);
            $this->route->set("/contact", "page/Contact@index", true);

            /* Add your other routes */

            $this->route->run();
        }
    }
```

### Usage

After completing the setup, access your application through the web server. For example, if you've set up a virtual host named `your-domain.com` and created a controller named `Home` as the default, you can access it at:

```bash
http://example.com
```

## Additional Configuration

- Ensure your web server's document root is set to the `public` directory of the framework.
- Configure your server's `.htaccess` (Apache) or `nginx.conf` (Nginx) to route all requests through the framework's `index.php` for proper routing.

Refer to the framework documentation for further details on advanced usage and features. This setup should give you a robust foundation for building your web application with the provided PHP MVC framework.