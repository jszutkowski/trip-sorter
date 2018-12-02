<?php

use App\Exception\InvalidCardTypeException;
use App\Service\Card\BusCard;
use App\Service\Card\CardFactory;
use App\Service\Card\PlaneCard;
use App\Service\Card\TrainCard;
use App\Service\TransportType;

/**
 * User: jszutkowski
 */

class CardFactoryTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getCreateData
     */
    public function testCreate($data, $class)
    {
        $factory = new CardFactory();
        $object = $factory->create($data);
        $this->assertEquals(get_class($object), $class);
    }

    /**
     * @dataProvider getInvalidData
     */
    public function testInvalidData($data)
    {
        $this->expectException(InvalidCardTypeException::class);
        $factory = new CardFactory();
        $factory->create($data);
    }

    public function getCreateData()
    {
        return [
            [['from' => 'A', 'to' => 'B', 'type' => TransportType::BUS], BusCard::class],
            [['from' => 'A', 'to' => 'B', 'type' => TransportType::TRAIN], TrainCard::class],
            [['from' => 'A', 'to' => 'B', 'gate' => '11', 'type' => TransportType::PLANE], PlaneCard::class],
        ];
    }

    public function getInvalidData()
    {
        return [
            [['type' => 123]],
            [[]]
        ];
    }
}