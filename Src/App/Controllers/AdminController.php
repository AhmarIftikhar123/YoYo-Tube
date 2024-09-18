<?php
namespace Src\App\Controllers;

use Src\App\Views;

class AdminController
{

          public function load_Dashboard(): Views
          {
                    return Views::make("admin/Dashboard_View");
          }
}