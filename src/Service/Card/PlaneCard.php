<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Card;


use App\Service\Messages;
use Webmozart\Assert\Assert;

class PlaneCard extends AbstractCard
{
    private $gate;
    private $baggageDrop;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $gate = $data['gate'] ?? null;
        $baggageDrop = $data['baggage_drop'] ?? null;

        Assert::string($gate, 'Gate number should be a string');
        Assert::minLength(trim($gate), 1, 'Gate should not be empty');

        Assert::nullOrString($baggageDrop, 'Baggage drop should be a string');

        $this->gate = $gate;
        $this->baggageDrop = $baggageDrop;
    }

    public function gate(): string
    {
        return $this->gate;
    }

    function renderDescription(): string
    {
        $description = sprintf('From %s, take flight %s to %s. Gate %s,', $this->from, $this->lineNumber, $this->to, $this->gate);
        $description .= $this->getSeatText();
        $description .= "\n";

        if ($this->baggageDrop) {
            $description .= sprintf('Baggage drop at ticket counter %s', $this->baggageDrop);
        } else {
            $description .= Messages::NO_BAGGAGE_DROP;
        }

        return $description;
    }
}