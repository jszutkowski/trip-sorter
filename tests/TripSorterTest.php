<?php

use App\Service\Card\CardFactory;
use App\Service\Messages;
use App\Service\TripSorter;

/**
 * User: jszutkowski
 */

class TripSorterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TripSorter
     */
    private $tripSorter;

    public function setUp()
    {
        parent::setUp();

        $factory = new CardFactory();
        $sorter = new \App\Service\Sort\CardSorter();

        $this->tripSorter = new TripSorter($factory, $sorter);
    }

    public function testSuccess()
    {
        $data = [['from' => 'AAA', 'to' => 'BBB', 'type' => 1], ['from' => 'BBB', 'to' => 'CCC', 'type' => 1]];
        $wayDescription = $this->tripSorter->findWay($data);
        $this->assertNotContains(Messages::NO_RESULTS, $wayDescription);
        $this->assertContains('AAA', $wayDescription);
        $this->assertContains('BBB', $wayDescription);
        $this->assertContains('CCC', $wayDescription);
        $this->assertContains(Messages::FINAL_DESTINATION, $wayDescription);

    }

    public function testNoElements()
    {
        $wayDescription = $this->tripSorter->findWay([]);
        $this->assertContains(Messages::NO_RESULTS, $wayDescription);
        $this->assertNotContains(Messages::FINAL_DESTINATION, $wayDescription);
    }

    public function testError()
    {
        $this->expectException(\App\Exception\TripSorterException::class);
        $data = [['from' => 'AAA', 'to' => 'BBB', 'type' => 111], ['from' => 'BBB', 'to' => 'CCC', 'type' => 1]];
        $this->tripSorter->findWay($data);
    }

    public function testWrongArgumentException()
    {
        $this->expectException(\App\Exception\TripSorterException::class);
        $data = [['from' => 'AAA', 'to' => '', 'type' => 1], ['from' => 'BBB', 'to' => 'CCC', 'type' => 1]];
        $this->tripSorter->findWay($data);
    }
}