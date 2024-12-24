import { BASE_URL } from "/js/config.js";
// ------------- Code to Upload a video -------------
// File Drop Area
const fileDropArea = document.getElementById("fileDropArea");
const videoFile = document.getElementById("videoFile");
let getFile;

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
  fileDropArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}

["dragenter", "dragover"].forEach((eventName) => {
  fileDropArea.addEventListener(eventName, highlight, false);
});

["dragleave", "drop"].forEach((eventName) => {
  fileDropArea.addEventListener(eventName, unhighlight, false);
});

function highlight() {
  fileDropArea.classList.add("dragover");
}

function unhighlight() {
  fileDropArea.classList.remove("dragover");
}

fileDropArea.addEventListener("click", () => {
  videoFile.click();
});

videoFile.addEventListener("change", function () {
  handleFiles(this.files);
});

function handleFiles(files) {
  if (files.length > 0) {
    getFile = files[0];
    if (getFile.type.startsWith("video/")) {
      // Here you would typically handle the file, e.g., prepare it for upload
      $("#uploadError").text("");
      $("#SelectVideo").text(getFile.name);
    } else {
      $("#uploadError").text("Please select a valid video file.");
    }
  }
}

// ---------- Paid Content Switch ----------
const paidContentSwitch = $("#paidContentSwitch");

paidContentSwitch.on("change", function () {
  $display = this.checked ? "block" : "none";
  $("#prizeSection").css("display", $display);
  $("#paidContentNotice").css("display", $display);
  $("#price").prop("required", this.checked);
});

// ------- Upload video with Ajax on clicking submit btn ----------
let uploadSuccess = false;
function handleUploadErrors(errors) {
  $.each(errors, function (key, value) {
    $(`#${key}`).text(value);
  });
}
$("#uploadBtn").on("click", function (e) {
  // Prevent default form submission
  e.preventDefault();

  const formData = new FormData();
  const videoFile = $("#videoFile")[0].files[0];

  // Add Loader HTML
  addLoader();

  if (!videoFile) {
    addUploadText("Upload Video");
    $("#uploadError").text("Please select a video file.");
    return;
  }

  // Append video file to formData
  formData.append("video", videoFile);

  // Clear previous error messages
  $(".text-danger").text("");

  // Validate form and get the data if valid
  const validationResult = validateFormData(formData);

  // If validation failed, stop the process
  if (!validationResult) {
    addUploadText("Upload Video");
    return;
  }
  $.ajax({
    url: `${BASE_URL}/upload`,
    type: "POST",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
    xhr: function () {
      const xhr = new XMLHttpRequest();

      // Event listener for progress updates
      xhr.upload.addEventListener(
        "progress",
        function (e) {
          if (e.lengthComputable) {
            const percentComplete = ((e.loaded / e.total) * 100).toFixed(2);
            $("#percentCompleate").text(`${percentComplete}%`);
          }
        },
        false
      );

      return xhr;
    },
    success: function (response) {
      if (response.success) {
        addUploadText("Video Uploading Completed");
        $("#uploadModalBody").html(
          `${response.message}! </br> <strong style="color: var(--toast-text);">Go To Home Page Click  <a href="/home" class="underline">here</a></strong>`
        );
        $("#uploadModal").modal("show");
        uploadSuccess = true;
      } else {
        if (typeof response.message === "object") {
          handleUploadErrors(response.message);
          addUploadText("Upload Video");
          return;
        }
        $("#uploadModalBody").text(`${response.message}`);
        $("#uploadModal").modal("show");
        return;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      addUploadText("Upload Video");
      $("#uploadModalBody").text(
        `Error occurred during upload: ${errorThrown}`
      );
      $("#uploadModal").modal("show");
      $(".text-danger").text("");
    },
  });
});

// For adding Loader
function addLoader() {
  $("#uploadBtn").html(
    `<?php echo addslashes(file_get_contents(dirname(__DIR__) . "/partials/Loader.php")); ?> <span id="percentCompleate">0%</span>`
  );
  $(".loader").show();
}
function addUploadText(text) {
  $(".loader").hide();
  $("#uploadBtn").html(text);
}
// Function to validate form data
function validateFormData(formData) {
  let isValid = true;

  // Validate video file
  const videoFile = $("#videoFile")[0].files[0];
  if (!videoFile) {
    $("#uploadError").text("Please select a video file.");
    isValid = false;
  } else {
    formData.append("video", videoFile);
  }

  // Validate title
  const videoTitle = $("#videoTitle").val().trim();
  if (!videoTitle) {
    $("#videoTitleError").text("Title is required.");
    isValid = false;
  } else {
    formData.append("videoTitle", videoTitle);
  }

  // Validate description
  const videoDescription = $("#videoDescription").val().trim();
  if (!videoDescription) {
    $("#videoDescriptionError").text("Description is required.");
    isValid = false;
  } else {
    formData.append("videoDescription", videoDescription);
  }

  // Validate tags
  const videoTags = $("#videoTags").val().trim();
  console.log(`Tags input: ${videoTags}`);
  const isValidTags = processVideoTags(videoTags);
  if (videoTags.length <= 0) {
    $("#videoTagsError").text("Tags are required.");
    isValid = false;
  } else if (typeof isValidTags === "string") {
    isValid = false;
    $("#videoTagsError").text(isValidTags);
  } else {
    formData.append("videoTags", isValidTags);
  }

  // Validate category
  const videoCategory = $("#videoCategory").val();
  if (!videoCategory) {
    $("#videoCategoryError").text("Category is required.");
    isValid = false;
  } else {
    formData.append("videoCategory", videoCategory);
  }

  // Check if content is paid and validate price
  const isPaid = $("#paidContentSwitch").is(":checked") ? 1 : 0;
  formData.append("isPaid", isPaid);

  if (isPaid) {
    const price = $("#price").val().trim();
    if (!price) {
      $("#priceError").text("Price is required for paid content.");
      isValid = false;
    } else if (isNaN(price) || parseFloat(price) <= 0) {
      $("#priceError").text("Please enter a valid price.");
      isValid = false;
    } else {
      formData.append("price", price);
    }
  } else {
    formData.append("price", 0); // Default price if not paid content
  }

  return isValid;
}

// ---------- Video Tags Validation ----------
function debounce(cb, delay = 500) {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => cb.apply(this, args), delay);
  };
}
const tagsDebounce = debounce((videoTags) => {
  const tagsArray = processVideoTags(videoTags);

  if (!Array.isArray(tagsArray)) {
    $("#videoTagsError").text(tagsArray);
    return;
  }
  return tagsArray;
});
function processVideoTags(input) {
  // Define the regex pattern
  const pattern = /^[a-zA-Z\-]+(,[a-zA-Z\-]+)*$/;

  // Validate the input
  if (pattern.test(input)) {
    // Sanitize input (trim spaces and remove unwanted characters)
    const sanitizedInput = input.replace(/[^a-zA-Z,\-]/g, "");

    // Convert the input to an array of tags
    const tags = sanitizedInput.split(",");
    // You can now store or further process the tags
    return tags;
  } else if (input.split(",").length < 3) {
    return "Please enter at least 3 tags.";
  } else {
    // If input is invalid, return an error message
    return "Please enter alphabetic tags separated by commas.";
  }
}
$("#videoTags").on("input", function () {
  const videoTags = $("#videoTags").val().trim();
  if (videoTags.length > 0) {
    $("#videoTagsError").text("");
  }
  tagsDebounce(videoTags);
});
$("#uploadModal").on("hidden.bs.modal", function () {
  if (uploadSuccess) {
    setTimeout(() => {
      location.reload();
    }, 1000);
  }
});
