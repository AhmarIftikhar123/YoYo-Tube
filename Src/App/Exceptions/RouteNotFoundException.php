<?php
namespace Src\App\Exceptions;

class RouteNotFoundException extends \Exception
{
          public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null, string $file = "", ?int $line = null)
          {
                    parent::__construct($message, $code, $previous);

          }
}
