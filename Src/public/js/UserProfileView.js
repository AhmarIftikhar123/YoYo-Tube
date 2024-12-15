let cropper;
let formData = new FormData(); // Initialize globally accessible formData

// Profile Picture Upload & Preview
$("#profilePictureUpload").on("change", function (event) {
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      $("#imageForCrop").attr("src", e.target.result);
      $("#cropperModal").modal("show");

      // Wait for modal to be visible before initializing Cropper.js
      $("#cropperModal").on("shown.bs.modal", function () {
        // Destroy previous cropper instance if exists
        if (cropper) cropper.destroy();

        // Initialize Cropper.js
        cropper = new Cropper(document.getElementById("imageForCrop"), {
          aspectRatio: 16 / 9,
          viewMode: 1,
          responsive: true,
          zoomable: true,
          scalable: true,
          rotatable: true,
          autoCropArea: 0.8,
        });
      });
    };
    reader.readAsDataURL(file);
  }
});

// Save cropped image and close the modal
$("#saveCroppedImage").on("click", function () {
  if (cropper) {
    const canvas = cropper.getCroppedCanvas({
      width: 300,
      height: 300,
    });

    // Convert the cropped canvas to a Blob
    canvas.toBlob(function (blob) {
      // Create a new file from the Blob
      const file = new File([blob], "new_profile_img.jpg", {
        type: "image/jpeg",
      });
      // Update formData with the cropped image file
      formData.set("new_profile_img", file); // Use `set` to overwrite if it exists
      // Update the profile picture preview
      const croppedImageUrl = canvas.toDataURL("image/jpeg");
      $("#profilePicture").attr("src", croppedImageUrl);

      // Close the modal
      $("#cropperModal").modal("hide");

      // Optionally destroy the cropper instance
      cropper.destroy();
      cropper = null;
    }, "image/jpeg");
  }
});

// Submit the form with AJAX
$("#profileForm").on("submit", function (e) {
  e.preventDefault();
  formData.append("new_username", $("#new_username").val());
  // AJAX request
  $.ajax({
    url: profileUrl,
    type: "POST",
    data: formData,
    processData: false, // Prevent automatic processing of FormData
    contentType: false, // Prevent setting default Content-Type
    success: function (response) {
      // Show success message
      $(".alert-success").show();
      $("#server_res").text(response.message);

      // Hide success message after 3 seconds & redirect
      setTimeout(() => {
        $(".alert-success").hide();
        window.location.href = "/home";
      }, 3000);
    },
    error: function (error) {
      console.error("Error updating profile:", error);
    },
  });
});
