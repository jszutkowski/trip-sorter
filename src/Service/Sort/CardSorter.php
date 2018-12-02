<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Sort;


use App\Service\Card\CardInterface;

class CardSorter
{
    /**
     * @param CardInterface[] $cards
     * @return CardInterface[]
     */
    public function sort(array $cards): array
    {
        $prepareData = $this->prepareData($cards);
        foreach($prepareData as $startLocation => $locationCards) {
            $path = $this->findPath($prepareData, $startLocation, new Destination($locationCards[0]));
            if ($path->isFinished) {
                return $this->buildList($path);
            }
        }

        return [];
    }

    /**
     * @param CardInterface[] $cards
     * @return array
     */
    private function prepareData(array $cards): array
    {
        $data = [];
        foreach ($cards as $card) {
            $data[$card->from()][] = $card;
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $startLocation
     * @param Destination $currentPlace
     * @return Destination
     */
    private function findPath(array $data, string $startLocation, Destination $currentPlace): Destination
    {
        if (empty($data)) {
            $currentPlace->isFinished = true;
            return $currentPlace;
        } elseif(empty($data[$startLocation])) {
            return $currentPlace;
        }

        foreach ($data[$startLocation] as $cardKey => $card) {

            /** @var $card CardInterface */
            $leftData = $data;
            unset($leftData[$startLocation][$cardKey]);
            if (empty($leftData[$startLocation])) {
                unset($leftData[$startLocation]);
            }

            $newPlace = new Destination($card, $currentPlace);

            $place = $this->findPath($leftData, $card->to(), $newPlace);
            if ($place->isFinished) {
                return $place;
            }
        }

        return $currentPlace;
    }

    /**
     * @param Destination $destination
     * @return array
     */
    private function buildList(Destination $destination): array
    {
        $list = [];
        while($destination->previous !== null) {
            array_unshift($list, $destination->card);
            $destination = $destination->previous;
        }

        return $list;
    }
}