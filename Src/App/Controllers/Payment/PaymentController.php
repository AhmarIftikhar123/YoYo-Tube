<?php
namespace Src\App\Controllers\Payment;
use Src\App\Models\Payment\PaymentModel;
use Src\App\Views;

class PaymentController
{
          private $PaymentModel;
          public function __construct()
          {
                    $this->PaymentModel = new PaymentModel();
          }
          public function load_Payment_Page(): Views
          {
                    return Views::make("Payment/PaymentView");
          }
          public function processPayment()
          {
                    \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']); // Replace with your secret key

                    $payment_method_id = $_POST['payment_method_id'];

                    try {
                              // Create a PaymentIntent
                              $paymentIntent = \Stripe\PaymentIntent::create([
                                        'amount' => 1000, // Amount in cents (e.g., $10.00)
                                        'currency' => 'usd',
                                        'payment_method' => $payment_method_id,
                                        'confirmation_method' => 'manual',
                                        'confirm' => true,
                                        'return_url' => BASE_URL . '/payment'
                              ]);

                              echo 'Payment successful! Payment Intent ID: ' . $paymentIntent->id;
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                              // Handle error
                              echo 'Payment failed: ' . $e->getMessage();
                    }
          }
}