<?php
/**
 * User: jszutkowski
 */

namespace App\Service\Card;


interface CardInterface
{
    function from(): string ;
    function to(): string;
    function renderDescription(): string;
}