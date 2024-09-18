<?php
namespace Tests\Unit;

class RouterDataProvider
{
          public static function RouteNotFoundCases(): array
          {
                    return [
                              ["/user", "put"], // Action not set
                              ["/Invoice", "post"], // Class | Route not found
                              ["/user", "get"], // Request-Method(post set) doesn't exist 
                              ["/user", "post"] // Method doesn't exist
                    ];
          }
}
