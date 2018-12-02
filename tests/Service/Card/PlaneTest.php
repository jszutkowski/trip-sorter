<?php

use App\Service\Card\PlaneCard;
use App\Service\Messages;

/**
 * User: jszutkowski
 */

class PlaneTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getCorrectData
     */
    public function testSuccessfulCreation($row)
    {
        $card = new PlaneCard($row);
        $this->assertEquals($card->from(), $row['from']);
        $this->assertEquals($card->to(), $row['to']);
    }

    /**
     * @dataProvider getIncorrectData
     */
    public function testFailCreation($row)
    {
        $this->expectException(InvalidArgumentException::class);
        $card = new PlaneCard($row);
    }

    public function testDescription()
    {
        $card = new PlaneCard(['from' => 'AAA', 'to' => 'BBB', 'seat' => 'CCC', 'gate' => 'DDD']);
        $description = $card->renderDescription();

        $this->assertContains('AAA', $description);
        $this->assertContains('BBB', $description);
        $this->assertContains('CCC', $description);
        $this->assertContains('DDD', $description);
        $this->assertNotContains(Messages::NO_SEAT_ASSIGNMENT, $description);
        $this->assertContains(Messages::NO_BAGGAGE_DROP, $description);

        $card = new PlaneCard(['from' => 'AAA', 'to' => 'BBB', 'gate' => 'DDD', 'baggage_drop' => 'CCC', 'line' => 'EEE']);
        $description = $card->renderDescription();

        $this->assertContains('AAA', $description);
        $this->assertContains('BBB', $description);
        $this->assertContains('CCC', $description);
        $this->assertContains('DDD', $description);
        $this->assertContains('EEE', $description);
        $this->assertContains(Messages::NO_SEAT_ASSIGNMENT, $description);
        $this->assertNotContains(Messages::NO_BAGGAGE_DROP, $description);
    }

    public function getCorrectData()
    {
        return [
            [['from' => 'A', 'to' => 'B', 'seat' => 'A', 'gate' => '4F']],
            [['from' => 'A', 'to' => 'B', 'seat' => null, 'gate' => '22']],
            [['from' => 'A', 'to' => 'B', 'gate' => 'a']],
            [['from' => 'A', 'to' => 'B', 'gate' => 'a', 'baggage_drop' => '']],
            [['from' => 'A', 'to' => 'B', 'gate' => 'a', 'baggage_drop' => null]],
        ];
    }

    public function getIncorrectData()
    {
        return [
            [['from' => '', 'to' => 'B', 'seat' => 'A', 'gate' => '4F']],
            [['from' => null, 'to' => 'B', 'seat' => 'A', 'gate' => '4F']],
            [['to' => 'B', 'seat' => 'A', 'gate' => '4F']],
            [['from' => 'A', 'to' => '', 'seat' => null, 'gate' => '4F']],
            [['from' => 'A', 'to' => null, 'seat' => null, 'gate' => '4F']],
            [['from' => 'A', 'to' => 1, 'seat' => null, 'gate' => '4F']],
            [['from' => 'A', 'seat' => null, 'gate' => '4F']],
            [['from' => [], 'seat' => null, 'gate' => '4F']],
            [['from' => 'A', 'to' => [], 'seat' => null, 'gate' => '4F']],
            [['from' => 'A', 'to' => 'B', 'seat' => '', 'gate' => '']],
            [['from' => 'A', 'to' => 'B', 'seat' => '', 'gate' => null]],
            [['from' => 'A', 'to' => 'B', 'seat' => '', 'gate' => []]],
            [['from' => 'A', 'to' => 'B', 'seat' => '']],
            [['from' => 'A', 'to' => 'B', 'gate' => 'a', 'baggage_drop' => 1]],
            [['from' => 'A', 'to' => 'B', 'gate' => 'a', 'baggage_drop' => []]]
        ];
    }
}