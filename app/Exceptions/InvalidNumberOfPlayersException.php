<?php

namespace App\Exceptions;
use Exception;

class InvalidNumberOfPlayersException extends Exception
{
    protected $message = 'The number of players is invalid.';
}