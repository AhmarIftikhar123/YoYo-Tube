<?php
namespace Src\App;
abstract class Modle
{
          protected DB $db;

          public function __construct()
          {
                    $this->db = App::$db;
          }
}
