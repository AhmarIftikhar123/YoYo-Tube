<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/4-pages/UserProfileView.css">
    <!-- Cropper CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.css"
        integrity="sha512-087vysR/jM0N5cp13Vlp+ZF9wx6tKbvJLwPO8Iit6J7R+n7uIMMjg37dEgexOshDmDITHYY5useeSmfD1MYiQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Cropper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.js"
        integrity="sha512-lR8d1BXfYQuiqoM/LeGFVtxFyspzWFTZNyYIiE5O2CcAGtTCRRUMLloxATRuLz8EmR2fYqdXYlrGh+D6TVGp3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>
    <!-- Include Navbar -->
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
    <!-- Include Profile Image -->
    <?php
    if (session_status() === PHP_SESSION_NONE)
        session_start();
    $profile_img = isset($_SESSION['profile_img']) ? isfromDB($_SESSION['profile_img']) : $_COOKIE['profile_img'] ?? "images/profile_img.png";
    $username = $_COOKIE['username'] ?? $_SESSION['username'] ?? "";
    if (session_status() !== PHP_SESSION_ACTIVE)
        session_write_close();
    ?>

    <!-- Display success message -->
    <div class="alert alert-success" role="alert" style="display:none;"> <span id="server_res" class="bg_teal clr_light_gray d-inline-block
 p-1 rounded"></span> Changes Saved Successfully!. We are
        redirecting you to Home page
    </div>
    <!-- Main Content -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <form id="profileForm" class="profile-form p_3 m_block_3 mx-auto clr_light_gray bg_darkest_black rounded"
            action="/profile" method="POST" enctype="multipart/form-data">
            <h1 class="text-center mb-4">Update Profile</h1>

            <!-- Profile Picture -->
            <div class="text-center mb-4">
                <img src="<?= $profile_img ?>" alt="Profile Picture"
                    class="profile-picture rounded-circle m_block-end_1_25" id="profilePicture">

                <div class="mt-2 position-relative" data-text="Upload Img">
                    <div class="file-input-wrapper d-inline-block overflow-hidden position-relative rounded">
                        <!-- Label for File Input with Icon -->
                        <label for="profilePictureUpload"
                            class="custom-file-upload d-inline-block p_block_35 p_inline_75 rounded">
                            <i class="fa-solid fa-upload"></i>
                        </label>
                        <!-- Hidden File Input -->
                        <input type="file" class="overflow-hidden position-absolute" id="profilePictureUpload"
                            accept="image/*" name="new_profile_img" autocomplete="off">
                    </div>
                </div>
            </div>

            <!-- Username Input -->
            <div class="mb-3 form-group">
                <label for="new_username" class="form-label">Username</label>
                <input type="text" class="form-control" id="new_username" name="new_username" maxlength="30" required
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

    <!-- Modal Structure -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg_darkest_black clr_light_gray">
                <!-- Apply background and text color -->
                <div class="modal-header bg_darkest_black clr_aqua">
                    <h5 class="modal-title navbar-brand" id="cropperModalLabel">Crop Image</h5>
                    <i class="fa-solid fa-xmark d-block ms-auto clr_light_gray" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body bg_clr_dark_gray text-clr_light_gray" style="max-width: 100%; padding: 0;">

                    <img id="imageForCrop" src="" alt="Image for cropping" class="img-fluid"
                        style="max-width: 100%; height: auto;">
                </div>
                <div class="modal-footer bg_clr_teal text-clr_aqua"> <!-- Footer with teal background and aqua text -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- Cancel button with gray background -->
                    <button type="button" id="saveCroppedImage"
                        class="btn btn-primary bg_darkest_black clr_light_gray">Save Cropped Image</button>
                    <!-- Save button with aqua background -->
                </div>
            </div>
        </div>
    </div>
    <!-- Include JS -->
    <script>
        const profileUrl = "<?php echo BASE_URL . '/profile'; ?>";
    </script>
    <script src="/js/UserProfileView/UserProfileView.js"></script>
</body>

</html>