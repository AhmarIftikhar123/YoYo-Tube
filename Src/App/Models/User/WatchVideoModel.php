<?php
namespace Src\App\Models\User;
use Src\App\Modle;
class WatchVideoModel extends Modle
{

          public function is_valid_user($data)
          {
                    if (!isset($_SESSION['user_id'])) {
                              die("User not found.
                     Redirecting to authentication page.
                      <script>setTimeout(() => { window.location.href = '/authentication'; }, 2000);</script>"); // check if user is logged in or false;
                    }
                    if (isset($data['id']) && isset($data['is_paid'])) {
                              try{
                                        $sql = "SELECT * FROM videos WHERE id = :id AND is_paid = :is_paid";
                                        $stmt = $this->db->prepare($sql);
                                        $stmt->bindParam(':id', $data['id']);
                                        $stmt->bindParam(':is_paid', $data['is_paid']);
                                        $stmt->execute();
                                        return $stmt->fetch();
                              } catch (\PDOException $e) {
                                        throw $e;
                              }
                    }
          }
          public function get_lates_videos(){
                    try{
                              $sql = "SELECT * FROM videos ORDER BY created_at DESC LIMIT 4";
                              $stmt = $this->db->prepare($sql);
                              $stmt->execute();
                              return $stmt->fetchAll();
                    } catch (\PDOException $e) {
                              throw $e;
                    }
          }
}