<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Card;


use App\Service\Messages;
use Webmozart\Assert\Assert;

abstract class AbstractCard implements CardInterface
{
    protected $from;
    protected $to;
    protected $seat;
    protected $lineNumber;

    public function __construct(array $data)
    {
        $from = $data['from'] ?? '';
        $to = $data['to'] ?? '';
        $seat = $data['seat'] ?? null;
        $lineNumber = $data['line'] ?? null;

        Assert::string($from, 'Start point must be a string');
        Assert::notEmpty($from, 'Start point should not be empty');

        Assert::string($to, 'End point must be a string');
        Assert::notEmpty($to, 'End point should not be empty');

        Assert::nullOrString($seat, 'Seat number should be null or string');
        Assert::nullOrString($lineNumber, 'Line number should be a string');

        $this->from = $from;
        $this->to = $to;
        $this->seat = $seat;
        $this->lineNumber = $lineNumber;
    }

    public function from(): string
    {
        return $this->from;
    }

    public function to(): string
    {
        return $this->to;
    }

    protected function getSeatText(): string
    {
        if ($this->seat) {
            return sprintf(' Sit in seat %s. ', $this->seat);
        } else {
            return ' ' . Messages::NO_SEAT_ASSIGNMENT;
        }
    }
}