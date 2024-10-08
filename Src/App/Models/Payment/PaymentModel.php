<?php
namespace Src\App\Models\Payment;
use Src\App\Modle;
class PaymentModel extends Modle
{
          public function store_payments_record(
                    int $user_id,
                    int $video_id,
                    string $transaction_id,
                    float $payment_amount,
                    string $payment_method_type,
                    string $card_brand,
                    string $last4,
                    string $payment_status,
                    string $payment_date
          ) {
                    try {
                              $stmt = $this->db->prepare("INSERT INTO payments 
                              (user_id, video_id, transaction_id, payment_amount, payment_method, payment_method_brand, payment_method_last4, payment_status, payment_date)
                              VALUES (:user_id, :video_id, :transaction_id, :payment_amount, :payment_method, :payment_method_brand, :payment_method_last4, :payment_status, :payment_date)");
                              $stmt->execute([
                                        ':user_id' => $user_id,
                                        ':video_id' => $video_id,
                                        ':transaction_id' => $transaction_id,
                                        ':payment_amount' => $payment_amount,
                                        ':payment_method' => $payment_method_type,
                                        ':payment_method_brand' => $card_brand,
                                        ':payment_method_last4' => $last4,
                                        ':payment_status' => $payment_status,
                                        ':payment_date' => $payment_date
                              ]);

                              return $this->db->lastInsertId();
                    } catch (\PDOException $e) {
                              throw $e;
                    }
          }
}