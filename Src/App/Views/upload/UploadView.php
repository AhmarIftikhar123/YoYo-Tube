<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Upload Platform - Dark Theme</title>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
    <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
        }

        .file-drop-area {
            border: 2px dashed #444;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #1e1e1e;
        }

        .file-drop-area.dragover {
            background-color: #2c2c2c;
            border-color: #0d6efd;
        }

        .video-version {
            margin-bottom: 10px;
        }

        .tag-badge {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>

    <div class="container mt-2">
        <h1 class="mb-4">Add new Post</h1>

        <form id="videoUploadForm" method="post" action="/upload" enctype="multipart/form-data">
            <!-- Video Upload Section -->
            <div class="mb-4">
                <h2>1. Upload Video</h2>
                <div class="file-drop-area" id="fileDropArea">
                    <p class="m-0">Drag and drop your video file here or click to select</p>
                    <input type="file" id="videoFile" accept="video/*" name="video" style="display: none;">
                    <small class="text-danger"><?= $this->upload_video_error ?? "" ?></small>
                </div>
            </div>

            <!-- Video Details Section -->
            <div class="mb-4">
                <h2>2. Video Details</h2>
                <div class="mb-3">
                    <label for="videoTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="videoTitle" name="videoTitle">
                    <small class="text-danger"><?= $this->upload_title_error ?? "" ?></small>
                </div>
                <div class="mb-3">
                    <label for="videoDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="videoDescription" rows="3" name="videoDescription"></textarea>
                    <small class="text-danger"><?= $this->upload_description_error ?? "" ?></small>
                </div>
                <div class="mb-3">
                    <label for="videoTags" class="form-label">Tags</label>
                    <input type="text" class="form-control" id="videoTags" name="videoTags"
                        placeholder="Enter tags separated by commas">
                    <small class="text-danger"><?= $this->upload_tags_error ?? "" ?></small>
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
                <h2>3. Content Type</h2>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="paidContentSwitch" name="isPaid">
                    <label class="form-check-label" for="paidContentSwitch">Paid Content</label>
                </div>
                <div id="paidContentNotice" class="alert alert-light mt-2 border-light" style="display: none;">
                    Users will need to make a payment to view this content.
                </div>
            </div>

            <button type="submit" class="btn btn-light">Upload Video</button>
        </form>
    </div>

    <script>

        // File Drop Area
        const fileDropArea = document.getElementById('fileDropArea');
        const videoFile = document.getElementById('videoFile');

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

        fileDropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        fileDropArea.addEventListener('click', () => {
            videoFile.click();
        });

        videoFile.addEventListener('change', function () {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('video/')) {
                    // Here you would typically handle the file, e.g., prepare it for upload
                    console.log('Video file selected:', file.name);
                } else {
                    alert('Please select a valid video file.');
                }
            }
        }

        // Paid Content Switch
        const paidContentSwitch = document.getElementById('paidContentSwitch');
        const paidContentNotice = document.getElementById('paidContentNotice');

        paidContentSwitch.addEventListener('change', function () {
            paidContentNotice.style.display = this.checked ? 'block' : 'none';
        });
    </script>
</body>

</html>