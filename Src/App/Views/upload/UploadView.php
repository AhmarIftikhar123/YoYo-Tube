<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Upload Platform - Light/Dark Theme</title>
    <link rel="stylesheet" href="/css/4-pages/UploadView.css">
</head>

<body class="bg_darkest_black clr_light_gray">
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>

    <div class="container upload_form_wrapper mx-auto">
        <h1 class="mb-4 text-center text-uppercase">Upload</h1>

        <form id="videoUploadForm" class="d-grid" method="post" action="/upload" enctype="multipart/form-data">
            <!-- Video Upload Section -->
            <div class="mb-4">
                <div class="file-drop-area p-3 text-center" id="fileDropArea">
                    <i class="fa-solid fa-cloud-arrow-up d-block mx-auto my-2"></i>
                    <p class="m-0 fs_85" id="SelectVideo">Drag and drop your video file here or <a href="#"
                            class="nav-link d-inline text-decoration-underline">Browse</a></p>
                    <input type="file" id="videoFile" accept="video/*" name="video" style="display: none;">
                    <small class="text-danger" id="uploadError"><?= $this->upload_video_error ?? "" ?></small>
                </div>
            </div>

            <!-- Video Details Section -->
            <div class="mb-4 video_details_section">
                <div class="mb-3 form-group">
                    <label for="videoTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="videoTitle" name="videoTitle"
                        placeholder="Enter video title">
                    <small class="text-danger" id="videoTitleError"><?= $this->upload_title_error ?? "" ?></small>
                </div>
                <div class="mb-3 form-group">
                    <label for="videoDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="videoDescription" rows="3" name="videoDescription"
                        placeholder="Enter video description"></textarea>
                    <small class="text-danger"
                        id="videoDescriptionError"><?= $this->upload_description_error ?? "" ?></small>
                </div>
                <section class="tags_catogery_wrapper d-grid">

                    <div class="form-group">
                        <label for="videoTags" class="form-label">Tags</label>
                        <input type="text" class="form-control" id="videoTags" name="videoTags"
                            placeholder="Enter At least 3 tags separated by commas">
                        <small class="text-danger" id="videoTagsError"><?= $this->upload_tags_error ?? "" ?></small>
                        <div id="selectedTags" class="mb-3"></div>
                        <!-- Category Section -->
                    </div>
                    <div class="form-group">
                        <label for="videoCategory" class="form-label">Category</label>
                        <input type="text" class="form-control bg_darkest_black clr_light_gray" id="videoCategory"
                            name="videoCategory" list="categoryDetails" placeholder="Enter category">
                        <datalist id="categoryDetails">
                            <option value="Action" selected></option>
                            <option value="Horror"></option>
                            <option value="Comedy"></option>
                            <option value="Drama"></option>
                            <option value="18+"></option>
                        </datalist>
                    </div>
                </section>
                <!-- Content Type Section -->
                <div class="mb-4">
                    <div class="my-3 form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="paidContentSwitch" name="isPaid">
                        <label class="form-check-label" for="paidContentSwitch">Make this content Paid (Default is
                            Free)</label>
                    </div>
                    <div class="mb-3" id="prizeSection" style="display: none;">
                        <label for="price" class="form-label">Prize</label>
                        <div class="input-group form-group">
                            <span class="input-group-text bg_aqua clr_darkest_black" id="basic-addon1">$</span>
                            <input type="text" class="form-control" id="price" name="price"
                                placeholder="Enter Prize Default is $0.00" list="prizeDetails">
                        </div>
                        <datalist id="prizeDetails">
                            <option value="5.00"></option>
                            <option value="10.00"></option>
                            <option value="20.00"></option>
                            <option value="30.00"></option>
                            <option value="40.00"></option>
                            <option value="50.00"></option>
                            <option value="100.00"></option>
                        </datalist>
                        <small class="text-danger" id="priceError"><?= $this->price_error ?? "" ?></small>
                    </div>
                    <div id="paidContentNotice" class="alert alert-light mt-2 clr_teal bg_dark_gray"
                        style="display: none;">
                        Users will need to make a payment to view this content.
                    </div>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1 mx-auto fw-semibold"
                        id="uploadBtn">Upload
                        Video</button>
                </div>
            </div>

        </form>
    </div>

    <!----------- Upload Modal ----------->

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="uploadModalLabel">Upload Message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Message:</strong>
                        <p id="uploadModalBody" class="text-Success"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Upload Toast -->
    <div class="toast-container position-fixed top-25 end-0 p-3">
        <div id="uploadToast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg_light_gray clr_darkest_black">
                <i class="fa-solid fa-exclamation me-2"></i>
                <strong class="me-auto navbar-brand">YOYO Tube</strong>
                <i class="fa-solid fa-xmark ms-1" type="button" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <div class="toast-body bg_darkest_black clr_light_gray">

            </div>
        </div>
    </div>

    <script>
        // ------------- Code to Upload a video ------------- 
        // File Drop Area
        const fileDropArea = document.getElementById('fileDropArea');
        const videoFile = document.getElementById('videoFile');
        let getFile;

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileDropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileDropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileDropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            fileDropArea.classList.add('dragover');
        }

        function unhighlight() {
            fileDropArea.classList.remove('dragover');
        }

        fileDropArea.addEventListener('click', () => {
            videoFile.click();
        });

        videoFile.addEventListener('change', function () {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                getFile = files[0];
                if (getFile.type.startsWith('video/')) {
                    // Here you would typically handle the file, e.g., prepare it for upload
                    $('#uploadError').text('');
                    $('#SelectVideo').text(getFile.name);
                } else {
                    $('#uploadError').text('Please select a valid video file.');
                }
            }
        }

        // ---------- Paid Content Switch ---------- 
        const paidContentSwitch = $('#paidContentSwitch');

        paidContentSwitch.on('change', function () {
            $display = this.checked ? 'block' : 'none';
            $("#prizeSection").css("display", $display);
            $("#paidContentNotice").css("display", $display);
            $('#price').prop('required', this.checked);
        });

        // ------- Upload video with Ajax on clicking submit btn ----------
        let uploadSuccess = false;
        function handleUploadErrors(errors) {
            $.each(errors, function (key, value) {
                $(`#${key}`).text(value);
            });
        }
        $('#uploadBtn').on("click", function (e) {
            // Prevent default form submission
            e.preventDefault();

            const formData = new FormData();
            const videoFile = $('#videoFile')[0].files[0];

            // Add Loader HTML
            addLoader();
            
            if (!videoFile) {
                addUploadText("Upload Video");
                $("#uploadError").text("Please select a video file.");
                return;
            }

            // Append video file to formData
            formData.append('video', videoFile);

            // Clear previous error messages
            $('.text-danger').text('');

            // Validate form and get the data if valid
            const validationResult = validateFormData(formData);

            // If validation failed, stop the process
            if (!validationResult) {
                addUploadText("Upload Video");
                return;
            }
            $.ajax({
                url: '<?= BASE_URL . "/upload" ?>',
                type: 'POST',
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                xhr: function () {
                    const xhr = new XMLHttpRequest();

                    // Event listener for progress updates
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            const percentComplete = ((e.loaded / e.total) * 100).toFixed(2);
                            $('#percentCompleate').text(`${percentComplete}%`);
                        }
                    }, false);

                    return xhr;
                },
                success: function (response) {
                    if (response.success) {
                        addUploadText("Video Uploading Completed");
                        $('#uploadModalBody').html(`${response.message}! </br> <strong style="color: var(--toast-text);">Go To Home Page Click  <a href="/home" class="underline">here</a></strong>`);
                        $('#uploadModal').modal("show");
                        uploadSuccess = true;
                    } else {
                        if (typeof response.message === 'object') {
                            handleUploadErrors(response.message);
                            addUploadText("Upload Video");
                            return;
                        }
                        $('#uploadModalBody').text(`${response.message}`);
                        $('#uploadModal').modal("show");
                        return;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    addUploadText("Upload Video");
                    $('#uploadModalBody').text(`Error occurred during upload: ${errorThrown}`);
                    $('#uploadModal').modal('show');
                    $('.text-danger').text('');
                }
            });
        });

        // For adding Loader
        function addLoader() {
            $('#uploadBtn').html(`<?php echo addslashes(file_get_contents(dirname(__DIR__) . "/partials/Loader.php")); ?> <span id="percentCompleate">0%</span>`);
            $('.loader').show();
        }
        function addUploadText(text) {
            $('.loader').hide();
            $('#uploadBtn').html(text);
        }
        // Function to validate form data
        function validateFormData(formData) {
            let isValid = true;

            // Validate video file
            const videoFile = $('#videoFile')[0].files[0];
            if (!videoFile) {
                $('#uploadError').text("Please select a video file.");
                isValid = false;
            } else {
                formData.append('video', videoFile);
            }

            // Validate title
            const videoTitle = $('#videoTitle').val().trim();
            if (!videoTitle) {
                $('#videoTitleError').text("Title is required.");
                isValid = false;
            } else {
                formData.append('videoTitle', videoTitle);
            }

            // Validate description
            const videoDescription = $('#videoDescription').val().trim();
            if (!videoDescription) {
                $('#videoDescriptionError').text("Description is required.");
                isValid = false;
            } else {
                formData.append('videoDescription', videoDescription);
            }

            // Validate tags
            const videoTags = $('#videoTags').val().trim();
            console.log(`Tags input: ${videoTags}`);
            const isValidTags = processVideoTags(videoTags);
            if (videoTags.length <= 0) {
                $('#videoTagsError').text("Tags are required.");
                isValid = false;
            } else if (typeof isValidTags === "string") {
                isValid = false;
                $('#videoTagsError').text(isValidTags);
            }
            else {
                formData.append('videoTags', isValidTags);
            }

            // Validate category
            const videoCategory = $('#videoCategory').val();
            if (!videoCategory) {
                $('#videoCategoryError').text("Category is required.");
                isValid = false;
            } else {
                formData.append('videoCategory', videoCategory);
            }

            // Check if content is paid and validate price
            const isPaid = $('#paidContentSwitch').is(':checked') ? 1 : 0;
            formData.append('isPaid', isPaid);

            if (isPaid) {
                const price = $('#price').val().trim();
                if (!price) {
                    $('#priceError').text("Price is required for paid content.");
                    isValid = false;
                } else if (isNaN(price) || parseFloat(price) <= 0) {
                    $('#priceError').text("Please enter a valid price.");
                    isValid = false;
                } else {
                    formData.append('price', price);
                }
            } else {
                formData.append('price', 0); // Default price if not paid content
            }

            return isValid;
        }

        // ---------- Video Tags Validation ----------
        function debounce(cb, delay = 500) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => cb.apply(this, args), delay);
            }
        }
        const tagsDebounce = debounce((videoTags) => {
            const tagsArray = processVideoTags(videoTags);

            if (!Array.isArray(tagsArray)) {
                $('#videoTagsError').text(tagsArray);
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
                const sanitizedInput = input.replace(/[^a-zA-Z,\-]/g, '');

                // Convert the input to an array of tags
                const tags = sanitizedInput.split(',');
                // You can now store or further process the tags
                return tags;
            } else if (input.split(',').length < 3) {
                return "Please enter at least 3 tags.";
            }
            else {
                // If input is invalid, return an error message
                return "Please enter alphabetic tags separated by commas.";
            }
        }
        $('#videoTags').on("input", function () {
            const videoTags = $('#videoTags').val().trim();
            if (videoTags.length > 0) {
                $('#videoTagsError').text("");
            };
            tagsDebounce(videoTags);
        });
        $('#uploadModal').on("hidden.bs.modal", function () {
            if (uploadSuccess) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
    </script>
</body>

</html>