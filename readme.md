# Ambil data Cuaca Dari Website Data BMKG

### Install

```
composer require ezadev/bmkg
```

### Penggunaan

```php
use Ezadev\Bmkg\Cuaca;

$cuaca = new Cuaca('Kalimantan Tengah');

// Respon dalam bentuk Json
$cuaca->get()->json();

// Respon dalam bentuk Array
var_dump($cuaca->get()->json);

// Respon dalam bentuk xml
var_dump($cuaca->get()->xml);
```

