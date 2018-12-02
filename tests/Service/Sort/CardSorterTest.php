<?php

use App\Service\Card\BusCard;
use App\Service\Card\PlaneCard;
use App\Service\Card\TrainCard;
use App\Service\Sort\CardSorter;

/**
 * User: jszutkowski
 */

class CardSorterTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider getData
     */
    public function testSort($cards, $sorted)
    {
        $sorter = new CardSorter();
        $result = $sorter->sort($cards);

        $this->assertCount(7, $result);

        foreach ($result as $key => $card)
        {
            $this->assertEquals($sorted[$key][0], $card->from());
            $this->assertEquals($sorted[$key][1], $card->to());
        }

    }

    /**
     * @dataProvider getInvalidData
     */
    public function testFailSort($cards)
    {
        $sorter = new CardSorter();
        $result = $sorter->sort($cards);

        $this->assertCount(0, $result);
    }

    public function getData()
    {
        return [
          [
              [
                  new TrainCard(['from' => 'G', 'to' => 'H']),
                  new TrainCard(['from' => 'A', 'to' => 'B']),
                  new BusCard(['from' => 'E', 'to' => 'F']),
                  new PlaneCard(['from' => 'B', 'to' => 'C', 'gate' => '1']),
                  new PlaneCard(['from' => 'F', 'to' => 'G', 'gate' => '1']),
                  new BusCard(['from' => 'C', 'to' => 'D']),
                  new PlaneCard(['from' => 'D', 'to' => 'E', 'gate' => '1']),
              ],
              [
                  ['A', 'B'],
                  ['B', 'C'],
                  ['C', 'D'],
                  ['D', 'E'],
                  ['E', 'F'],
                  ['F', 'G'],
                  ['G', 'H'],
              ]
          ],
          [
              [
                  new PlaneCard(['from' => 'C', 'to' => 'D', 'gate' => '1']),
                  new PlaneCard(['from' => 'B', 'to' => 'C', 'gate' => '1']),
                  new TrainCard(['from' => 'D', 'to' => 'E']),
                  new PlaneCard(['from' => 'D', 'to' => 'B', 'gate' => '1']),
                  new TrainCard(['from' => 'A', 'to' => 'B']),
                  new BusCard(['from' => 'C', 'to' => 'D']),
                  new BusCard(['from' => 'B', 'to' => 'C']),
              ],
              [
                  ['A', 'B'],
                  ['B', 'C'],
                  ['C', 'D'],
                  ['D', 'B'],
                  ['B', 'C'],
                  ['C', 'D'],
                  ['D', 'E'],
              ]
          ],
          [
              [
                  new TrainCard(['from' => 'D', 'to' => 'E']),
                  new TrainCard(['from' => 'A', 'to' => 'B']),
                  new BusCard(['from' => 'C', 'to' => 'D']),
                  new PlaneCard(['from' => 'B', 'to' => 'C', 'gate' => '1']),
                  new PlaneCard(['from' => 'D', 'to' => 'B', 'gate' => '1']),
                  new BusCard(['from' => 'B', 'to' => 'C']),
                  new PlaneCard(['from' => 'C', 'to' => 'D', 'gate' => '1']),
              ],
              [
                  ['A', 'B'],
                  ['B', 'C'],
                  ['C', 'D'],
                  ['D', 'B'],
                  ['B', 'C'],
                  ['C', 'D'],
                  ['D', 'E'],
              ]
          ],
        ];
    }

    public function getInvalidData()
    {
        return [
          [
              [
                  new PlaneCard(['from' => 'C', 'to' => 'D', 'gate' => '1']),
                  new PlaneCard(['from' => 'B', 'to' => 'C', 'gate' => '1']),
                  new TrainCard(['from' => 'A', 'to' => 'B']),
                  new BusCard(['from' => 'C', 'to' => 'D']),
              ]
          ],
          [
              [
                  new TrainCard(['from' => 'A', 'to' => 'B']),
                  new PlaneCard(['from' => 'C', 'to' => 'D', 'gate' => '1']),
              ]
          ],
        ];
    }
}