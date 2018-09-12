# Vietnam Phone number
Library detect carrier Vietnam telco: Viettel, Vina, MobiFone...

Format Phone number

Library use libphonenumber by Google, version PHP by giggsey

### Installation

**Manual install**

Step 1: Save library to your project

```shell
cd /your/to/path
wget https://github.com/nguyenanhung/vn-telco-phonenumber/archive/master.zip
unzip master.zip
```

Step 2: Init to Project

```php
<?php 
require '/your/to/path/Phone_number.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;

$phone = new Phone_number();

```

**Install with composer**

Step 1: Install package

```shell
composer require nguyenanhung/vn-telco-phonenumber
```

Step 2: Init to Project

```php
<?php 
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();
```

### **How to Use**
**Get Version of Library**
```php
<?php
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();

echo $phone->getVersion(); // Print: 1.0.9
```
**Valid Phone Number**
```php
<?php
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();

$my_number = '0163 295 3760';
$my_number_2 = '0163 295 376';

echo $phone->is_valid($my_number, 'VN'); // Print: true
echo $phone->is_valid($my_number_2, 'VN'); // Print: false
```

**Check is Possible Number**
```php
<?php
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();

$my_number = '0163 295 3760';
$my_number_2 = 'abc';

echo $phone->is_possible_number($my_number, 'VN'); // Print: true
echo $phone->is_possible_number($my_number_2, 'VN'); // Print: false
```

**Format Phone number**

```php
<?php 
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();

$my_number = '0163 295 3760';

echo $phone->format($my_number); // Print: 841632953760
echo $phone->format($my_number, 'vn'); // Print: 01632953760
echo $phone->format($my_number, 'vn_human'); // Print: 0163 295 3760
echo $phone->format($my_number, 'hidden'); // Print: 0163***3760

```

**Detect Carrier from Phone number**

```php
<?php 
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();

$my_number = '0163 295 3760';

echo $phone->detect_carrier($my_number); // Print: Viettel Mobile
echo $phone->detect_carrier($my_number, 'id'); // Print: 2
echo $phone->detect_carrier($my_number, 'name'); // Print: Viettel
echo $phone->detect_carrier($my_number, 'short_name'); // Print: viettel
```

**Conver Old Number to New Number (or New Number to Old Number)**

```php
<?php
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();

$my_number = '0163 295 3760';

echo $phone->vn_convert_phone_number($my_number, 'old'); // Print: 841632953760
echo $phone->vn_convert_phone_number($my_number, 'new'); // Print: 84332953760

echo $phone->vn_convert_phone_number($my_number, 'old', 'vn'); // Print: 01632953760
echo $phone->vn_convert_phone_number($my_number, 'new', 'vn'); // Print: 0332953760

```

**Return Array Old number and New number**

```php
<?php
require '/your/to/path/vendor/autoload.php';
use \nguyenanhung\VnTelcoPhoneNumber\Phone_number;
$phone = new Phone_number();

$my_number = '0163 295 3760';

echo $phone->vn_phone_number_old_and_new($my_number); // Print: ["841632953760", "84332953760"]
echo $phone->vn_phone_number_old_and_new($my_number, 'vn'); // Print: ["01632953760", "0332953760"]

...

other format is the same $phone->format() method: vn, vn_human, hidden ...
```

### Contact

If any quetion & request, please contact following infomation

| Name        | Email                | Skype            | Facebook      |
| ----------- | -------------------- | ---------------- | ------------- |
| Hung Nguyen | dev@nguyenanhung.com | nguyenanhung5891 | @nguyenanhung |

From Hanoi with Love <3