<?php
namespace Src\App\Exceptions;

class ViewNotFoundException extends \Exception
{
          public function __construct(string $message)
          {
                    parent::__construct($message);
          }
}