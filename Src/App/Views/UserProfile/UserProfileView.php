<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="/css/4-pages/UserProfileView.css">
    <style>
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
if (session_status() !== PHP_SESSION_ACTIVE)
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

            <form class="profile-form p_3 m_block_3 mx-auto clr_light_gray bg_darkest_black rounded" id="profileForm"
                action="/profile" method="POST" enctype="multipart/form-data">
                <h1 class="text-center mb-4">Update Profile</h1>

                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <img src="data:image/jpeg;base64,<?= $profile_img ?>" alt="Profile Picture"
                    class="profile-picture rounded-circle m_block-end_1_25" id="profilePicture">
                    
                <div class="mt-2 position-relative" data-text="Upload Img">
                    <div class="file-input-wrapper d-inline-block overflow-hidden position-relative rounded">
                        <label for="profilePictureUpload" class="custom-file-upload">
                            <i class="fa-solid fa-upload"></i>
                        </label>
                        <input type="file" class="overflow-hidden position-absolute" id="profilePictureUpload"
                            accept="image/*" name="new_profile_img" autocomplete="off">
                    </div>
                </div>
            </div>

            <!-- Username Input -->
            <div class="mb-3 form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="new_username" required maxlength="30"
                    placeholder="<?= "e.g: " . substr($username, 0, 15) ?? "" ?>">
                <div class="invalid-feedback">
                    Please enter a valid username (max 30 characters).
                </div>
            </div>

            <!-- Save Button -->
            <div class="text-center">
                <button type="submit" id="saveProfile" class="btn btn-primary">Save Changes</button>
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