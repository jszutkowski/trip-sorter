<?php
require '../vendor/autoload.php';

use App\Exception\TripSorterException;
use App\Service\Card\CardFactory;
use App\Service\Sort\CardSorter;
use App\Service\TransportType;
use App\Service\TripSorter;

$data = [];
$data[] = ['type' => TransportType::PLANE, 'from' => 'Stockholm', 'to' => 'New York JFK', 'gate' => '22', 'seat' => '7B'];
$data[] = ['type' => TransportType::BUS, 'from' => 'Barcelona', 'to' => 'Gerona Airport'];
$data[] = ['type' => TransportType::PLANE, 'from' => 'Gerona Airport', 'to' => 'Stockholm', 'gate' => '45B', 'seat' => '3A', 'baggage_drop' => '344'];
$data[] = ['type' => TransportType::TRAIN, 'from' => 'Madrid', 'to' => 'Barcelona', 'seat' => '45B'];


$factory = new CardFactory();
$sorter = new CardSorter();
$tripSorter = new TripSorter($factory, $sorter);

try {
    $text = $tripSorter->findWay($data);
    echo nl2br($text);
} catch (TripSorterException $e) {
    echo $e->getMessage();
}

