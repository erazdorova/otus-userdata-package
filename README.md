# Калькулятор некоторых данных пользователя

Пакет позволяет из пришедших данных (отчество, дата рождения) определить пол, возрастную категорию
## Требования

- php >= 7.4
- nesbot/carbon >= 2.57

## Установка
Используя composer:  
```
$ composer require erazdorova/otus-userdata-package
``` 
```json
{
  "require": {
    "erazdorova/otus-userdata-package": "^1.0"
  }
}
```
## Использование
```php
<?php
require 'vendor/autoload.php';

use ERazdorova\OtusUserDataPackage\Processor\UserDataProcessor;

$userData = new UserDataProcessor('Александровна', '01.01.1999');

printf("Пол: %s\n", $userData->getGender() ?? '<не определен>');
printf("Возраст: %s\n", $userData->getAge() ?? '<не определен>');
printf("Возрастная категория (согласно ВОЗ): %s\n", $userData->getAgeGrade() ?? '<не определена>');
```