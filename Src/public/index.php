<?php
declare(strict_types=1);
// pagination in admin & userViews & make ajax request on click
//  login with fb

use Src\App\{
    App,
    Config
};
use Src\App\Controllers\{
    Forgat_Password_Controller,
    PaymentController,
    AuthenticationController,
    Reset_Password_Controller,
    VideoPlayerController
};
use Src\App\Controllers\Admin\AdminController;
use Src\App\Controllers\FacebookLoginController;
use Src\App\Controllers\Home\HomeController;
use Src\App\Controllers\Profile\ProfileController;
use Src\App\Controllers\Upload\UploadController;
use Src\App\Controllers\User\UserVideoController;
use Src\App\Controllers\User\WatchVideoController;
use Src\App\Router;
use Src\App\Views;


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

define("BASE_URL" , "http://localhost:8000");

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

    // Profile 
    ->get("/profile", [ProfileController::class, "load_profile_page"])
    ->post("/profile", [ProfileController::class, "updateProfile"])

    /*        Panding      */
    ->get("/payment", [PaymentController::class, "load_Payment_Page"])

    // Admin Routes:
    ->get("/admin", [AdminController::class, "load_Admin_Dashboard"])
    ->post("/admin/action", [AdminController::class, "update_user_status"])
    ->get("/admin/posts", [AdminController::class, "load_user_posts"])
    ->post("/admin/posts/action", [AdminController::class, "update_video_status"])


    /*        Panding      */
    // ->get("/admin/users", [AdminController::class, "listUsers"])
    // ->get("/admin/videos", [AdminController::class, "listVideos"])
    // ->post("/admin/videos/block/{id}", [AdminController::class, "blockVideo"])


    /*        Panding      */
    // ->post("/profile/update", [ProfileController::class, "updateProfile"])
    // ->post("/profile/avatar", [ProfileController::class, "updateAvatar"])

    // Videos Routes:
    ->get("/video", [VideoPlayerController::class, "load_video_Player"]);

/*        Panding      */
// ->post("/videos/{id}/pay", [PaymentController::class, "processPayment"])
// ->post("/videos/{id}/pay/callback", [PaymentController::class, "paymentCallback"])


// Video Viewing and Interaction Routes:
// ->get("/videos/{id}", [VideoController::class, "viewVideo"])
// ->post("/videos/{id}/rate", [VideoController::class, "rateVideo"])
// ->post("/videos/{id}/report", [VideoController::class, "reportVideo"])

// Video Upload Routes:
// ->get("/videos/upload", [VideoController::class, "loadUploadPage"])
// ->post("/videos/upload", [VideoController::class, "uploadVideo"])

// 404 Route:
// ->get("Exception_Views/404", [ErrorController::class, "notFound"]);
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
