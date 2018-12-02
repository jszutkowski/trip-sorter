<?php

use App\Service\Card\BusCard;
use App\Service\Messages;

/**
 * User: jszutkowski
 */

class BusTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getCorrectData
     */
    public function testSuccessfulCreation($row)
    {
        $busCard = new BusCard($row);
        $this->assertEquals($busCard->from(), $row['from']);
        $this->assertEquals($busCard->to(), $row['to']);
    }

    /**
     * @dataProvider getIncorrectData
     */
    public function testFailCreation($row)
    {
        $this->expectException(InvalidArgumentException::class);
        $card = new BusCard($row);
    }

    public function testDescription()
    {
        $card = new BusCard(['from' => 'AAA', 'to' => 'BBB', 'seat' => 'CCC']);
        $description = $card->renderDescription();

        $this->assertContains('AAA', $description);
        $this->assertContains('BBB', $description);
        $this->assertContains('CCC', $description);
        $this->assertNotContains(Messages::NO_SEAT_ASSIGNMENT, $description);

        $card = new BusCard(['from' => 'AAA', 'to' => 'BBB']);
        $description = $card->renderDescription();
        $this->assertContains(Messages::NO_SEAT_ASSIGNMENT, $description);
    }

    public function getCorrectData()
    {
        return [
            [['from' => 'A', 'to' => 'B', 'seat' => 'A']],
            [['from' => 'A', 'to' => 'B', 'seat' => null]],
            [['from' => 'A', 'to' => 'B']],
        ];
    }

    public function getIncorrectData()
    {
        return [
            [['from' => '', 'to' => 'B', 'seat' => 'A']],
            [['from' => null, 'to' => 'B', 'seat' => 'A']],
            [['to' => 'B', 'seat' => 'A']],
            [['from' => 'A', 'to' => '', 'seat' => null]],
            [['from' => 'A', 'to' => null, 'seat' => null]],
            [['from' => 'A', 'to' => 1, 'seat' => null]],
            [['from' => 'A', 'seat' => null]],
            [['from' => [], 'seat' => null]],
            [['from' => 'A', 'to' => [], 'seat' => null]],
            [['from' => 'A', 'to' => [], 'seat' => []]],
        ];
    }
}