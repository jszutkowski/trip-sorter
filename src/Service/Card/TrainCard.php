<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Card;


class TrainCard extends AbstractCard
{
    function renderDescription(): string
    {
        $description = sprintf('Take train %s from %s to %s.', $this->lineNumber, $this->from, $this->to);
        $description .= $this->getSeatText();

        return $description;
    }
}