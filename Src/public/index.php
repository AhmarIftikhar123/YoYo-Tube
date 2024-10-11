<?php
declare(strict_types=1);
// Make /admin/posts page dynamic
//  login with fb

use Src\App\{
    App,
    Config
};
use Src\App\Controllers\{
    Forgat_Password_Controller,
    AuthenticationController,
    Reset_Password_Controller,
};
use Src\App\Controllers\{
    Payment\PaymentController,
    Admin\AdminController,
    FacebookLoginController,
    Home\HomeController,
    Profile\ProfileController,
    Upload\UploadController,
    User\UserVideoController,
    User\WatchVideoController
};
use Src\App\{Router, Views};

// /var/www/src
define('APP_ROOT', dirname(__DIR__));

// /var/www/src/controllers
define('CONTROLLERS', dirname(__DIR__) . '/Controllers');

// /var/www
define("BASE_ROOT", dirname(APP_ROOT));

// var/www/src/storage
define("STORAGE_DIR", APP_ROOT . "/storage");

// var/www/src/app/Views
define("VIEWS_PATH", BASE_ROOT . "/src/app/Views");

define("BASE_URL", "http://localhost:8000");

// importing Autoloader
require_once BASE_ROOT . '/vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../..');
$dotenv->load();

$Router = new Router();
$Router
    ->get("/home", [HomeController::class, "load_home_page"])
    ->get("/authentication", [AuthenticationController::class, "load_Authentication_Page"])
    ->post("/auth/register", [AuthenticationController::class, "register"])

    ->get("/auth/forgot-password", [Forgat_Password_Controller::class, "load_Forgat_Password_Page"])
    ->post("/auth/forgot-password", [Forgat_Password_Controller::class, "Forgat_Password"])

    ->get("/auth/reset-password", [Reset_Password_Controller::class, "load_Reset_Password_Page"])
    ->post("/auth/reset-password", [Reset_Password_Controller::class, "reset_Password"])

    ->post("/auth/login", [AuthenticationController::class, "login"])

    ->get("/facebook-login", [FacebookLoginController::class, "facebook_login"])


    ->get("/upload", [UploadController::class, "load_upload_page"])
    ->post("/upload", [UploadController::class, "upload_video"])

    ->get("/videos", [UserVideoController::class, "load_User_Videos_Page"])


    ->get("/videos/watch", [WatchVideoController::class, "load_video_watch_page"])
    ->get("/home/watch", [WatchVideoController::class, "load_video_watch_page"])

    ->post("/videos/watch/likes", [WatchVideoController::class, "like_dislike_video"])
    ->post("/videos/watch/comments", [WatchVideoController::class, "video_comments"])

    // Profile 
    ->get("/profile", [ProfileController::class, "load_profile_page"])
    ->post("/profile", [ProfileController::class, "updateProfile"])

    /*        Panding      */
    ->get("/payment", [PaymentController::class, "load_Payment_Page"])
    ->post("/payment", [PaymentController::class, "processPayment"])

    // Admin Routes:
    ->get("/admin", [AdminController::class, "load_Dashboard"])
    ->get("/admin/posts", [AdminController::class, "load_user_posts"])
    ->post("/admin/action", [AdminController::class, "admin_action"]);

try {
    (new App(
        $Router,
        [
            "request_method" => strtolower($_SERVER['REQUEST_METHOD']),
            "request_uri" => $_SERVER["REQUEST_URI"]
        ],
        new Config($_ENV)
    ))->run();

} catch (\Throwable $e) {
    echo Views::make("Exception_Views/404", ["message" => $e->getMessage() . $e->getFile() . $e->getLine()]);
    exit();
}
