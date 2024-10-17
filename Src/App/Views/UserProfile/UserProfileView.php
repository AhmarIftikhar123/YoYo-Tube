<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
    <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
    <style>
        :root {
            --bg-color: #f8f9fa;
            --text-color: #212529;
            --form-bg: #ffffff;
            --input-bg: #ffffff;
            --input-border: #ced4da;
        }

        .dark-theme {
            --bg-color: #212529;
            --text-color: #f8f9fa;
            --form-bg: #343a40;
            --input-bg: #495057;
            --input-border: #6c757d;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .profile-form {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: var(--form-bg);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid var(--text-color);
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            inset: 0;
            overflow: hidden !important;
            opacity: 0;
        }

        .custom-file-upload {
            border: 1px solid var(--input-border);
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: var(--input-bg);
            color: var(--text-color);
            border-radius: 4px;
        }

        .form-control {
            background-color: var(--input-bg);
            color: var(--text-color);
            border-color: var(--input-border);
        }

        .form-control:focus {
            background-color: var(--input-bg);
            color: var(--text-color);
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .theme-switch {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
<?php
$profile_img = $_SESSION['profile_img'] ?? "https://via.placeholder.com/150";
$username = $_SESSION['username'] ?? "";
$success = $this->message ?? "";
session_write_close();
?>

<body>
    <div class="alert alert-success" role="alert" style="display: <?= $success ? "block" : "none" ?>">
        <?php echo htmlspecialchars($success . " We are redirecting you to Home page") ?? "" ?>
        <?php if ($success)
            echo "<script>
                    setTimeout(() => {
                        document.querySelector('.alert-success').style.display = 'none';
                        window.location.href = '/home';
                    }, 3000);
                    </script>"
                ?>
        </div>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">

            <form class="profile-form" id="profileForm" action="/profile" method="POST" enctype="multipart/form-data">
                <h2 class="text-center mb-4">Update Profile</h2>

                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <img src="data:image/jpeg;base64,<?= $profile_img ?>" alt="Profile Picture" class="profile-picture"
                    id="profilePicture">
                <div class="mt-2">
                    <div class="file-input-wrapper">
                        <label for="profilePictureUpload" class="custom-file-upload" style="cursor: pointer">
                            Choose New Picture
                        </label>
                        <input type="file" id="profilePictureUpload" accept="image/*" name="new_profile_img" autocomplete="off">
                    </div>
                </div>
            </div>

            <!-- Username Input -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="new_username" required maxlength="30"
                    placeholder="<?= "Current: " . $username ?? "" ?>">
                <div class="invalid-feedback">
                    <!-- Please enter a valid username (max 30 characters). -->
                </div>
            </div>

            <!-- Save Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-secondary">Save Changes</button>
            </div>
        </form>
    </div>
    <script>
        // Profile picture preview
        $('#profilePictureUpload').change(function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#profilePicture').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });
        $('#darkModeToggle').change(function () {
            if (this.checked) {
                $('body').addClass('dark-theme');
            } else {
                $('body').removeClass('dark-theme');
            }
        });
    </script>
</body>

</html>