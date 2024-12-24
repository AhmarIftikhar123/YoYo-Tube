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
    <script type="module" src="/js/UploadView/Upload.js"></script>
</body>

</html>