<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Card;


class BusCard extends AbstractCard
{
    function renderDescription(): string
    {
        $description = sprintf('Take the airport bus from %s to %s.', $this->from, $this->to);
        $description .= $this->getSeatText();

        return $description;
    }
}