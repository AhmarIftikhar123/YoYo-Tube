<!-- User Profile Section -->
<div class="profile-container container">
          <div class="row align-items-center my-1">
                    <div class="col-md-1 col-12 text-md-start text-center profile_img_col">
                              <img src="<?= explode("/src", $user['profile_image'])[1] ?? $user['profile_image'] ?? 'https://via.placeholder.com/150' ?>"
                                        alt="Profile Image" class="profile-image rounded-circle"
                                        style="max-width: 2rem; height: 2rem;">
                    </div>
                    <div class="col-md-11 col-12 text-md-start text-center m-1 m-md-0 ps-0 profile_text_col">
                              <h6 class="profile-username mb-1"><?= $user['username']; ?></h6>
                              <p class="profile-email mb-0"><?= $user['email']; ?></p>
                    </div>
          </div>
</div>