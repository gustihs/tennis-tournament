<?php

namespace App\Exceptions;

use Exception;

class InvalidPlayersGenderException extends Exception
{
    protected $message = 'The players must be of the same gender.';
}