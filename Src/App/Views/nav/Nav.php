<!-- logout Logic  -->
<?php
if ($_SERVER['REQUEST_METHOD'] === "GET" & isset($_GET['logout'])) {
    if (!session_id()) {
        session_start();
    }
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    session_start();
    session_destroy();
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
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap');

    :root {
        --primary-color: #ff6b6b;
        --secondary-color: #4ecdc4;
        --text-color: #333;
        --bg-color: #f8f9fa;
        --card-bg: #ffffff;
        --border-color: #dee2e6;
        --modal-bg: #ffffff;
        --modal-text: #212529;
        --modal-header-bg: #f8f9fa;
        --modal-header-text: #212529;
        --loader-color: rgba(0, 0, 0, 0.5);
        --toast-bg: var(--card-bg);
        --toast-text: var(--text-color);
        --toast-header-bg: var(--modal-header-bg);
        --toast-header-text: var(--modal-header-text);
    }

    .dark-mode {
        --text-color: #e0e0e0;
        --bg-color: #121212;
        --card-bg: #1e1e1e;
        --border-color: #444;
        --modal-bg: #343a40;
        --modal-text: #f8f9fa;
        --modal-header-bg: #212529;
        --modal-header-text: #f8f9fa;
        --loader-color: rgba(255, 255, 255, 0.5);
        --toast-bg: var(--modal-bg);
        --toast-text: var(--modal-text);
        --toast-header-bg: var(--modal-header-bg);
        --toast-header-text: var(--modal-header-text);
    }

    body {
        font-family: 'Oswald', sans-serif !important;
        background-color: var(--bg-color);
        color: var(--text-color);
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .navbar {
        background-color: var(--card-bg);
        transition: background-color 0.3s ease;
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
        color: var(--text-color) !important;
    }

    .nav-link {
        color: var(--text-color) !important;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--bg-color) !important;
        background: var(--text-color);
        border-radius: .5rem;
    }

    .navbar-toggler {
        border-color: var(--text-color);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .form-check-label {
        color: var(--text-color);
    }

    @media (max-width: 991.98px) {
        .navbar-nav {
            background-color: var(--card-bg);
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
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/home">YoYo Tube</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
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
                        <a class="nav-link px-2" href="/home" id="searchVideos">Search
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
                        <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php if (!(explode("?", $_SERVER['REQUEST_URI'])[0] === "/profile") && !empty($user['username'])) {
    include dirname(__DIR__) . "/UserProfile/UserProfile.php";
} ?>

<script>
    $('.nav-link').click(function (e) {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    $('.navbar-nav>li>a').on('click', function () {
        $('.navbar-collapse').collapse('hide');
    });

    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        $('#darkModeToggle').prop('checked', true);
    }

    // Save theme preference
    $('#darkModeToggle').change(function () {
        if (this.checked) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
        }

        const isOnPaymentPage = localStorage.getItem('isOnPaymentPage')
        if (isOnPaymentPage) {
            updateCardStyles();
        }
    });
</script>