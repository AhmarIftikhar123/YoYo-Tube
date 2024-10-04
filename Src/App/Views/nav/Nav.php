<!-- logout Logic  -->
<?php
if ($_SERVER['REQUEST_METHOD'] === "GET" & isset($_GET['logout'])) {
<<<<<<< HEAD
    if (!session_id()) {
        session_start();
    }
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
=======
    session_start();
    session_destroy();
>>>>>>> parent of bbd3d4e (Admin Panel Compleated)
    foreach ($_COOKIE as $cookie_name => $cookie_value) {
        setcookie($cookie_name, "", time() - 3600, "/"); // Expire the cookie
    }
    session_write_close();
}
$post_data_address = explode("?", $_SERVER['REQUEST_URI'])[0];
$user = [
    'username' => $_SESSION["username"] ?? "",
    'email' => $_SESSION["email"] ?? "",
    'profile_image' => $_SESSION["profile_img"] ?? ""
];
session_write_close();
?>
<?php $is_user_registered = $_COOKIE['user_name'] ?? "" ?>

<style>
    .navbar {
        background-color: #1f1f1f;
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
    }

    .nav-link {
        color: #e0e0e0 !important;
        transition: color 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        color: #000 !important;
        background: #fff;
        border-radius: .5rem;
    }

    @media (max-width: 991.98px) {
        .navbar-nav {
            background-color: #1f1f1f;
            padding: 10px;
            border-radius: 5px;
        }

        .profile_text_col {
            margin-left: -2rem !important;
        }
    }

    @media (max-width: 768.98px) {
        .profile_text_col {
            margin-left: 0 !important;
        }
    }

    @media (min-width: 768.98px) {
        .profile_text_col {
            margin-left: -.25rem !important;
        }
    }

    @media (min-width: 990px) {
        .profile_text_col {
            margin-left: -1.5rem !important;
        }
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/">YoYo Tube</a>
        <button class="navbar-toggler border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav gap-4 ms-auto align-items-center">
                <?php if ($is_user_registered): ?>
                    <li class="nav-item text-center">
                        <a class="nav-link px-2" href="/upload" id="uploadVideo">Upload
                            Video</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link px-2" href="/videos" id="yourVideos">Your
                            Videos</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link px-2" href="/" id="searchVideos">Search
                            Videos</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link px-2" href="/profile" id="profile">Update Profile</a>
                    </li>
                    <li class="nav-item text-center">
                        <form action="<?= $post_data_address ?>" method="GET" class="mb-0">
                            <button type="submit" id="admin" name="logout" value="true" class="nav-link px-2">Log
                                Out</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item text-center">
                        <a class="nav-link px-2" href="/authentication" id="admin">Log-In</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item text-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="darkModeToggle">
                        <label class="form-check-label text-white" for="darkModeToggle">Dark Mode</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<? if (!(explode("?", $_SERVER['REQUEST_URI'])[0] === "/profile") == "/profile" && !empty($user['username'])) {
    include dirname(__DIR__) . "/UserProfile/UserProfile.php";
} ?>

<script>
    $('.nav-link').click(function (e) {
        // e.preventDefault()
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    $('.navbar-nav>li>a').on('click', function () {
        $('.navbar-collapse').collapse('hide');
    });

    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        $('body').addClass('dark-theme');
        $('#darkModeToggle').prop('checked', true);
    }

    // Save theme preference
    $('#darkModeToggle').change(function () {
        if (this.checked) {
            $('body').addClass('dark-theme');
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
            $('body').removeClass('dark-theme');
        }
    });
</script>