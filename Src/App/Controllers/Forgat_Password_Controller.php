<?php
namespace Src\App\Controllers;

use Src\App\Views;
use Src\App\Models\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Exception;
use Src\App\Models\Authentication\Forgat_Password_Model;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class Forgat_Password_Controller
{
    // Load the forget password page
    public function load_Forgat_Password_Page(): Views
    {
        return Views::make("Authentication/Forgat_Password_View");
    }

    // Handle forget password request
    public function Forgat_Password(): Views
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if (empty($email)) {
            return $this->renderView('Authentication/Forgat_Password_View', [
                'emailError' => 'Email is required',
            ]);
        }


        $forgetPasswordModel = new Forgat_Password_Model();
        $isEmailFound = $forgetPasswordModel->findByEmail($email);

        if (!$isEmailFound) {
            return $this->renderView('Authentication/Forgat_Password_View', [
                'emailError' => 'Email not found',
            ]);
        }

        $token = bin2hex(random_bytes(32));

        $isTokenStored = $forgetPasswordModel->storeResetToken($email, $token);

        if ($isTokenStored) {
            try {
                $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
                $mailer = new Mailer($transport);

                $resetLink = "http://localhost:8000/auth/reset-password?token=$token";

                $htmlContent = <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body style="background-color: #121212; color: #fff; font-family: Arial, sans-serif; padding: 20px;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #1e1e1e; border-radius: 8px;">
                        <h1 style="color: #fff;">Password Reset Request from YOYO Tube</h1>
                        <p style="color: #fff;">Click <a href="$resetLink" style="color: #1e88e5; text-decoration: none;">here</a> to reset your password.</p>
                        <p style="color: #fff;">If you did not request this, please ignore this email.</p>
                    </div>
                </body>
                </html>
                HTML;

                $textContent = <<<TEXT
                                           Password Reset Request

                                           Click the link below to reset your password:
                                           $resetLink

                                           If you did not request this, please ignore this email.
                                           TEXT;

                $emailMessage = (new Email())
                    ->from('coadersworldandais@gmail.com')
                    ->to($email)
                    ->subject('Password Reset')
                    ->html($htmlContent)
                    ->text($textContent);

                $mailer->send($emailMessage);

                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['email'] = $email;
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_write_close();
                }

                return Views::make('Authentication/Password_Reset_Email_Sent');
            } catch (\Throwable $e) {
                return Views::make('Exception_Views/404', [
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }



    public function renderView(string $view, array $data): Views
    {
        return Views::make($view, $data);
    }
}
