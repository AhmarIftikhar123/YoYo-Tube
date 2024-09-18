<?php
namespace Src\App\Controllers;

use Src\App\Views;

class PaymentController
{

          public function load_Payment_Page(): Views
          {
                    return Views::make("Payment_Views/Payment_View");
          }
}