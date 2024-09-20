<?php
namespace Src\App;
use \PDO;
use \PDOException;
class DB
{
          protected PDO $pdo;
          protected array $defaultOptions;

          public function __construct(protected array $db_config)
          {
                    try {
                              $this->pdo = new PDO(
                                        "mysql:host={$this->db_config['host']};dbname={$this->db_config['name']};",
                                        $this->db_config['user'],
                                        $this->db_config['password'],
                                        [
                                                  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                                  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                                  PDO::ATTR_EMULATE_PREPARES => false,
                                        ]
                              );
                    } catch (PDOException $e) {
                              die('Connection failed: ' . $e->getMessage());
                    }
          }


          public function __call(string $name, array $array)
          {
                    return call_user_func_array([$this->pdo, $name], $array);
          }
}

