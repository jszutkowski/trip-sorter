<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Sort;


use App\Service\Card\CardInterface;

class Destination
{
    /**
     * @var CardInterface
     */
    public $card;

    /**
     * @var Destination|null
     */
    public $previous;

    /**
     * @var boolean
     */
    public $isFinished;

    public function __construct(CardInterface $card, Destination $previous = null)
    {
        $this->card = $card;
        $this->previous = $previous;
    }
}