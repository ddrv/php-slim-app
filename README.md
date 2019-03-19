# ddrv/slim-app

Skeleton application based on [`slim/slim`](https://packagist.org/packages/slim/slim) and [`symfony/console`](https://packagist.org/packages/symfony/console)

# Requirements

- [`PHP`](https://php.net): version 5.6 or later
- [`slim/slim`](https://packagist.org/packages/slim/slim#3.12.0): version 3.12
- [`symfony/console`](https://packagist.org/packages/symfony/console#v3.4.23): version 3.4
- [`symfony/process`](https://packagist.org/packages/symfony/process#v3.4.23): version 3.4
- [`twig/twig`](https://packagist.org/packages/twig/twig#v1.38.2): version 1.38
- [`analog/analog`](https://packagist.org/packages/analog/analog#1.0.12-stable): version 1.0
- [`phpunit/phpunit`](https://packagist.org/packages/phpunit/phpunit#5.7.27): version 5.7

# Install

1. Create project with [`composer`](https://getcomposer.org/)
    ```
    composer create-project ddrv/slim-app path/to/project
    ```
    
2. Change config files `/path/to/project/config/local.php` and `/path/to/project/config/test.php`.
3. If you using environment variable `APP_ENV`, rename config file
    ```
    mv ./config/local.php ./config/{$APP_ENV}.php
    ```
4. Add to cron every minutes command
    ```
    * * * * * /path/to/php /path/to/project/bin/console schedule:run
    ```
    see ./config/global.php -> schedule
# Testing

```
php ./vendor/bin/phpunit
```

# Development

1. Start development server
    ```
    php ./bin/console app:dev 8080
    ```

2. Open [home page](http://localhost:8080) or [hello page](http://localhost:8080/bro)

