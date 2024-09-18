<?php
namespace Src\App;

class Config
{
          protected array $config;

          public function __construct(
                    protected array $env,
          ) {
                    $this->config = [
                              'db' => [
                                        'host' => $env['DB_HOST'],
                                        'name' => $env['DB_NAME'],
                                        'user' => $env['DB_USER'],
                                        'password' => $env['DB_PASSWORD'],
                                        'port' => $env['DB_PORT'],
                              ]
                    ];

          }
          public function __get($name)
          {
                    return $this->config[$name];
          }
}