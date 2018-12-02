# Trip Sorter

This project sorts boarding cards and displays information which steps should be taken to complete the trip

#### .env

Create .env file from .env.dist and put it in main directory

Docker uses **PHP_PORT** variable


#### Docker

To run project you need to install docker.

Firstly, install [docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/) and [docker-compose](https://docs.docker.com/compose/install/). 

#### Running application

To run application you need to start docker containers. To do so, please run the following command:
``` docker-compose up ```

To run any php file, type:
``` docker-compose exec php [path_to_file]```

Dependencies should be installed automatically.

Application will be available at the following address *http://localhost:[PHP_PORT]*

#### Unit tests
To run unit tests, you need to run following command:
``` docker-compose exec php vendor/bin/phpunit tests ```

#### Usage

An example file is in `/public` directory

```php
<?php
require '../vendor/autoload.php';

use App\Exception\TripSorterException;
use App\Service\Card\CardFactory;
use App\Service\Sort\CardSorter;
use App\Service\TransportType;
use App\Service\TripSorter;

$data = [];
$data[] = ['type' => TransportType::TRAIN, 'from' => 'Madrid', 'to' => 'Barcelona', 'seat' => '45B'];
$data[] = ['type' => TransportType::BUS, 'from' => 'Barcelona', 'to' => 'Gerona Airport'];
$data[] = ['type' => TransportType::PLANE, 'from' => 'Gerona Airport', 'to' => 'Stockholm', 'gate' => '45B', 'seat' => '3A', 'baggage_drop' => '344'];
$data[] = ['type' => TransportType::PLANE, 'from' => 'Stockholm', 'to' => 'New York JFK', 'gate' => '22', 'seat' => '7B'];


$factory = new CardFactory();
$sorter = new CardSorter();
$tripSorter = new TripSorter($factory, $sorter);

try {
    $text = $tripSorter->findWay($data);
    echo nl2br($text);
} catch (TripSorterException $e) {
    echo $e->getMessage();
}


```