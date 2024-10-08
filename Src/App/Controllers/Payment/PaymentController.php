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
                    \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

                    $payment_method_id = $_POST['payment_method_id'];
                    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
                    $video_id = filter_input(INPUT_POST, 'video_id', FILTER_SANITIZE_NUMBER_INT);
                    try {
                              // Create PaymentIntent
                              $paymentIntent = \Stripe\PaymentIntent::create([
                                        'amount' => $price * 100, // Amount in cents
                                        'currency' => 'usd',
                                        'payment_method' => $payment_method_id,
                                        'confirmation_method' => 'manual',
                                        'confirm' => true,
                                        'return_url' => BASE_URL . '/videos/watch'
                              ]);

                              // Retrieve payment details
                              $transaction_id = $paymentIntent->id;
                              $payment_amount = $paymentIntent->amount / 100; // Convert to dollars
                              $payment_method_details = \Stripe\PaymentMethod::retrieve($paymentIntent->payment_method);
                              $payment_method_type = $payment_method_details->type;
                              $card_brand = $payment_method_details->card->brand ?? null;
                              $last4 = $payment_method_details->card->last4 ?? null;
                              $payment_status = $paymentIntent->status;
                              $payment_date = date('Y-m-d H:i:s', $paymentIntent->created);

                              // Store payment details in database
                              $this->PaymentModel->store_payments_record(
                                        $user_id,
                                        $video_id,
                                        $transaction_id,
                                        $payment_amount,
                                        $payment_method_type,
                                        $card_brand,
                                        $last4,
                                        $payment_status,
                                        $payment_date
                              );
                              header("Content-Type: application/json");
                              echo json_encode([
                                        'transaction_id' => $transaction_id,
                                        'payment_amount' => $payment_amount,
                                        'payment_method_type' => $payment_method_type,
                                        'card_brand' => $card_brand,
                                        'last4' => $last4,
                                        'payment_status' => $payment_status,
                                        'payment_date' => $payment_date
                              ]);

                    } catch (\Stripe\Exception\ApiErrorException $e) {
                              // Handle error
                              echo json_encode([
                                        'error' => 'Payment failed: ' . $e->getMessage()
                              ]);
                    }
          }


}