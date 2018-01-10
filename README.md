# Generators for Laravel 5.5

## Features
* 透過artisan產生Laravel程式檔

## Installation

透過composer require取得此套件
```sh
$ composer require xyzcamp/multt-generators
```

## Usage
### 產生Eloquent
1. Laravel Project先定義好資料庫連線(config/database.php)
2. 於Laravel Project目錄, 執行artisan指令  
--namespace: 產生檔的Namespace與其目錄

```php
php artisan multt:eloquent --namespace=Xyz\Camp
```
