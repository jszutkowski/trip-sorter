<?php
/**
 * User: jszutkowski
 */

namespace App\Service;


use App\Exception\TripSorterException;
use App\Service\Card\CardFactory;
use App\Service\Card\CardInterface;
use App\Exception\InvalidCardTypeException;
use App\Service\Sort\CardSorter;

class TripSorter
{
    const NO_RESULTS_MESSAGE = 'Way couldn\'t be found';

    /**
     * @var CardFactory
     */
    private $factory;
    /**
     * @var CardSorter
     */
    private $sorter;

    public function __construct(CardFactory $factory, CardSorter $sorter)
    {
        $this->factory = $factory;
        $this->sorter = $sorter;
    }

    /**
     * @param array $elements Array containing boarding cards {
     *      @option string "type" 1 for bus, 2 for train, 3 for plane
     *      @option string "from" Start location
     *      @option string "to" Destination
     *      @option string "seat" Seat number (optional)
     *      @option string "line" Line number (optional), only for plane and train
     *      @option string "gate" Gate number, only for plane
     *      @option string "baggage_drop" Baggage drop number, only for plane
     *
     *
     *
     * }
     * @return string
     * @throws TripSorterException
     */
    public function findWay(array $elements)
    {
        try {
            $cards = $this->buildCards($elements);
            $sorted = $this->sorter->sort($cards);
            return $this->buildDescription($sorted);
        } catch (\InvalidArgumentException | InvalidCardTypeException $e) {
            throw new TripSorterException($e->getMessage());
        }
    }

    /**
     * @param array $cards
     * @return CardInterface[]
     * @throws InvalidCardTypeException
     */
    private function buildCards(array $cards): array
    {
        $result = [];

        foreach ($cards as $card) {
            $result[] = $this->factory->create($card);
        }

        return $result;
    }

    /**
     * @param CardInterface[] $cards
     * @return string
     */
    private function buildDescription(array $cards): string
    {
        if (!$cards) {
            return Messages::NO_RESULTS;
        }

        $result = [];
        foreach ($cards as $key => $card) {
            $result[] = sprintf('%d. %s', $key + 1, $card->renderDescription());
        }

        $result[] = sprintf('%d. %s', $key + 2, Messages::FINAL_DESTINATION);

        return join("\n", $result);
    }
}