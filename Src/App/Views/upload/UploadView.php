<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Upload Platform - Light/Dark Theme</title>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
    <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
    <style>
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
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .file-drop-area {
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: var(--card-bg);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .file-drop-area.dragover {
            background-color: var(--modal-header-bg);
            border-color: var(--primary-color);
        }

        .modal-content {
            background-color: var(--modal-bg);
            color: var(--modal-text);
        }

        .modal-header {
            background-color: var(--modal-header-bg);
            color: var(--modal-header-text);
            border-bottom: 1px solid var(--border-color);
        }

        .toast {
            background-color: var(--toast-bg);
            color: var(--toast-text);
            border-color: var(--border-color);
        }

        .toast-header {
            background-color: var(--toast-header-bg);
            color: var(--toast-header-text);
            border-bottom: 1px solid var(--border-color);
        }

        .form-control,
        .form-select {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--border-color);
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;

            &::placeholder {
                color: var(--text-color);
            }
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--bs-dark-border-subtle);
            box-shadow: 0 0 0 0.25rem var(--bs-dark-border-subtle);
        }

        .btn-light {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--border-color);
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .btn-light:hover {
            background-color: var(--modal-header-bg);
            color: var(--text-color);
            border-color: var(--primary-color);
        }

        .alert-light {
            background-color: var(--text-color);
            color: var(--bg-color);
            border-color: var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--bs-dark-bg-subtle);
            border-color: var(--bs-dark-bg-subtle);
        }

        #themeToggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>

    <div class="container mt-2">
        <h1 class="mb-4 text-center text-uppercase">Post a Video</h1>

        <form id="videoUploadForm" method="post" action="/upload" enctype="multipart/form-data">
            <!-- Video Upload Section -->
            <div class="mb-4">
                <div class="file-drop-area" id="fileDropArea">
                    <p class="m-0">Drag and drop your video file here or click to select</p>
                    <input type="file" id="videoFile" accept="video/*" name="video" style="display: none;">
                    <small class="text-danger" id="uploadError"><?= $this->upload_video_error ?? "" ?></small>
                </div>
            </div>

            <!-- Video Details Section -->
            <div class="mb-4">
                <div class="mb-3">
                    <label for="videoTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="videoTitle" name="videoTitle"
                        placeholder="Enter video title">
                    <small class="text-danger" id="videoTitleError"><?= $this->upload_title_error ?? "" ?></small>
                </div>
                <div class="mb-3">
                    <label for="videoDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="videoDescription" rows="3" name="videoDescription" placeholder="Enter video description"></textarea>
                    <small class="text-danger"
                        id="videoDescriptionError"><?= $this->upload_description_error ?? "" ?></small>
                </div>
                <div class="mb-3">
                    <label for="videoTags" class="form-label">Tags</label>
                    <input type="text" class="form-control" id="videoTags" name="videoTags"
                        placeholder="Enter tags separated by commas">
                    <small class="text-danger" id="videoTagsError"><?= $this->upload_tags_error ?? "" ?></small>
                </div>
                <div id="selectedTags" class="mb-3"></div>
                <div class="mb-3">
                    <label for="videoCategory" class="form-label">Category</label>
                    <select class="form-select" id="videoCategory" name="videoCategory">
                        <option value="action" selected>Action (default)</option>
                        <option value="horror">Horror</option>
                        <option value="comedy">Comedy</option>
                        <option value="drama">Drama</option>
                        <option value="18+">18+</option>
                    </select>
                </div>
            </div>

            <!-- Content Type Section -->
            <div class="mb-4">
                <h5>3. Content Type</h5>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="paidContentSwitch" name="isPaid">
                    <label class="form-check-label" for="paidContentSwitch">Paid Content</label>
                </div>
                <div class="mb-3" id="prizeSection" style="display: none;">
                    <label for="price" class="form-label">Prize</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">$</span>
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
                <div id="paidContentNotice" class="alert alert-light mt-2" style="display: none;">
                    Users will need to make a payment to view this content.
                </div>
            </div>

            <button type="submit" class="btn btn-light d-flex align-items-center gap-1" id="uploadBtn">Upload
                Video</button>
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
                        <p id="uploadModalBody" class="text-danger"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Upload Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="uploadToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">YoYo Tube</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">

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

        // fileDropArea.addEventListener('drop', handleDrop, false);

        // function handleDrop(e) {
        //     const dt = e.dataTransfer;
        //     const files = dt.files;
        //     handleFiles(files);
        // }

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
                    console.log('Video file selected:', getFile.name);
                } else {
                    alert('Please select a valid video file.');
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

        // Upload video with Ajax on clicking submit btn
        $('#uploadBtn').on("click", function (e) {
            // Prevent default form submission
            e.preventDefault();
            // $('#uploadModal').modal('show');
            // return;
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
                        $('.toast-body').text(`${response.message}`);
                        $('#uploadToast').show();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        console.log(response.message);
                        $('#uploadModalBody').text(`${response.message}`);
                        $('#uploadModal').modal("show");
                        addUploadText("Upload Video");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    addUploadText("Upload Video");
                    $('#uploadMsg').text(`${response.message}`);
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
            if (!videoTags) {
                $('#videoTagsError').text("Tags are required.");
                isValid = false;
            } else {
                formData.append('videoTags', videoTags);
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

    </script>
</body>

</html>