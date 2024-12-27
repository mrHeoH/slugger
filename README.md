# Генерация адреса страницы по правилам транслитерации

Создание адреса веб-страницы по правилам Яндекса или ГОСТа. 

Разница между ними минимальная, но существует. И может быть принципиальной для проекта, 
который должен или учитывать SEO-оптимизацию, или выполняется с учетом различных ГОСТов.


## Требования

Требуется PHP 8.1 и старше.


## Установка

Используйте composer для установки:

```shell
composer require mrheoh\slugger
```

## Как пользоваться

По умолчанию используется алгоритм транслитерации от Яндекс.

```php
use Mrheoh\Slugger\Slugger;

...

$slugger = new Slugger();
```

Для переопределения алгоритма выберите необходимый:

```php
$mode = new Mrheoh\Slugger\Interface\Yandex();
```
или 

```php
$mode = new Mrheoh\Slugger\Interface\Gost();
```

Вызовите с указанием алгоритма:
```php
$slugger = new Slugger($mode);
```

Вторым параметром можно передать boolean значение, 
которое отвечает за конвертацию результата в нижний регистр (по умолчанию `true`).

Например, можно использовать алгоритм по умолчанию и не изменять регистр букв.

```php
$slugger = new Slugger(null, false);
```
