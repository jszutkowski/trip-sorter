<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Card;


use App\Exception\InvalidCardTypeException;
use App\Service\TransportType;

class CardFactory
{

    /**
     * @param array $data
     * @return CardInterface
     * @throws InvalidCardTypeException
     */
    public function create(array $data): CardInterface
    {
        $type = (int) $data['type'] ?? null;
        switch ($type) {
            case TransportType::BUS:
                return new BusCard($data);
            case TransportType::TRAIN:
                return new TrainCard($data);
            case TransportType::PLANE:
                return new PlaneCard($data);
            default:
                throw new InvalidCardTypeException();
        }
    }
}