<?php
$tags = json_decode($this->current_video_info['tags']);
$current_video_id = $this->current_video_info['id'];
$lates_videos_info = $this->latest_videos_info;
$comments = $this->comments;
$username = $_COOKIE['user_name'];
$is_user_like = !empty($this->is_user_like_video['is_liked']) ? "active" : "";
$is_user_dislike = (isset($this->is_user_like_video['is_liked']) && $this->is_user_like_video['is_liked'] === 0) ? "active" : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YoYo Tube </title>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
    <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

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
            /* Light theme for toast */
            --toast-bg: var(--card-bg);
            --toast-text: var(--text-color);
            --toast-header-bg: var(--modal-header-bg);
            --toast-header-text: var(--modal-header-text);

        }

        .dark-mode {
            --modal-bg: #343a40;
            --modal-text: #f8f9fa;
            --modal-header-bg: #212529;
            --modal-header-text: #f8f9fa;
            --loader-color: rgba(255, 255, 255, 0.5);
            /* Dark theme for toast */
            --toast-bg: var(--modal-bg);
            --toast-text: var(--modal-text);
            --toast-header-bg: var(--modal-header-bg);
            --toast-header-text: var(--modal-header-text);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
        }

        #videoPlayer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .controls {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .controls button {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .seek-bar {
            width: 100%;
            height: 5px;
            background-color: #666;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .seek-bar-progress {
            height: 100%;
            background-color: var(--primary-color);
            width: 0;
        }

        .yoyo-rating {
            font-size: 1.5rem;
        }

        .yoyo-rating .fa-yoyo {
            color: var(--primary-color);
        }

        .card-img-overlay {
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .card:hover .card-img-overlay {
            opacity: 1;
        }

        .paywall,
        .age-verification {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
        }

        #relatedVideos {
            .col-4 {
                >img {
                    object-fit: cover;
                    height: 100%;
                }
            }
        }

        .dark-mode {
            --text-color: #f8f9fa;
            --bg-color: #333;
            --card-bg: #444;
            --border-color: #555;
        }

        .modal-content {
            background-color: var(--modal-bg);
            color: var(--modal-text);
        }

        .modal-header {
            background-color: var(--modal-header-bg);
            color: var(--modal-header-text);
        }

        .modal-footer .btn-primary {
            background-color: var(--btn-primary-bg);
            color: var(--btn-primary-color);
        }

        .btn-primary {
            background-color: var(--bg-color) !important;
            color: var(--text-color) !important;
            border: 1px solid var(--text-color) !important;

            &:hover {
                background-color: var(--text-color) !important;
                color: var(--bg-color) !important;
                border-color: var(--text-color) !important;

            }
        }

        .card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }

        .like-dislike-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-color);
        }

        .like-dislike-btn.active {
            color: var(--primary-color);
        }

        .comment-section {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .comment {
            border-bottom: 1px solid var(--border-color);
            padding: 0.5rem 0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .btn-primary {
            background-color: var(--bg-color) !important;
            color: var(--text-color) !important;
            border: 1px solid var(--text-color) !important;

            &:hover {
                background-color: var(--text-color) !important;
                color: var(--bg-color) !important;
                border-color: var(--text-color) !important;

            }
        }

        .form-control {
            &:focus {
                border: 1px solid var(--text-color) !important;
                box-shadow: 0 0 0 .125rem var(--text-color);
                color: var(--text-color) !important;
                background-color: var(--bg-color) !important;

                &::placeholder {
                    color: var(--text-color) !important;
                }
            }
        }

        /* Report Toast */
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

        .toast-body {
            color: var(--toast-text);
        }


        @media (max-width: 768px) {
            .controls button {
                font-size: 1rem;
                margin-right: 5px;
            }
        }
    </style>
</head>

<body>
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="video-container mb-4">
                    <video id="videoPlayer">
                        <source src="<?= htmlspecialchars($this->current_video_info['file_path']) ?? "" ?>"
                            type="video/mp4">
                    </video>
                    <div class="controls">

                        <div class="seek-bar">
                            <div class="seek-bar-progress"></div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <button id="playPauseBtn"><i class="fas fa-play"></i></button>
                                <button id="stopBtn"><i class="fas fa-stop"></i></button>
                                <button id="muteBtn"><i class="fas fa-volume-up"></i></button>
                                <span class="like-dislike-container ">
                                    <button class="like-dislike-btn me-0
                                    <?= $is_user_like ?>
                                    " id="likeBtn"><i class="fas fa-thumbs-up"></i>
                                        <span
                                            id="likeCount"><?= htmlspecialchars($this->current_video_info['likes_count']) ?></span></button>
                                    <button class="like-dislike-btn
                                    <?= $is_user_dislike ?>
                                    " id="dislikeBtn"><i class="fas fa-thumbs-down"></i>
                                        <span
                                            id="dislikeCount"><?= htmlspecialchars($this->current_video_info['dislikes_count']) ?></span></button>
                                </span>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-end gap-2">
                                <select id="qualitySelect" class="form-sm-select d-inline-block w-auto">
                                    <option value="240">240p</option>
                                    <option value="360">360p</option>
                                    <option value="480">480p</option>
                                </select>
                                <button id="fullscreenBtn"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h2 id="videoTitle"><?= htmlspecialchars($this->current_video_info['title']) ?? "" ?></h2>
                    <p id="videoDescription" class="mb-2">
                        <?= htmlspecialchars($this->current_video_info['description']) ?? "" ?>
                    </p>
                    <p><strong>Category:</strong> <span
                            id="videoCategory"><?= htmlspecialchars($this->current_video_info['category']) ?? "" ?></span>
                    </p>
                    <p><strong>Tags:</strong> <span id="videoTags"><?php if (isset($tags) && is_array($tags) || is_object($tags)) {
                        foreach ($tags as $tag) {
                            echo $tag . " ";
                        }
                    } else
                        echo $tags ?>
                            </span></p>
                        <button id="reportBtn" class="btn btn-primary mt-2 d-block ms-auto">Report Video</button>
                    </div>

                    <div class="comment-section">
                        <h3>Comments</h3>
                        <form id="commentForm" class="mb-3">
                            <div class="mb-3">
                                <textarea class="form-control" id="commentText" rows="3"
                                    placeholder="Add a comment..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form>
                        <div id="commentList">
                            <!-- Existing comments -->
                        <?php if (empty($comments)): ?>
                            <p>No comments yet.</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment">
                                    <p><strong>
                                            <?php
                                            if ($comment['commenter_name'] === $_COOKIE['user_name'] || $comment['commenter_name'] === $this->current_video_info['user_id']) {
                                                echo "You";
                                            } else {
                                                echo htmlspecialchars($comment['commenter_name']);
                                            }
                                            ?>
                                        </strong>: <?= htmlspecialchars($comment['comment_text']) ?>
                                    </p>
                                    <small><?= htmlspecialchars($comment['comment_created_at']) ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h3>Related Videos</h3>
                <div id="relatedVideos">
                    <?php foreach ($lates_videos_info as $video): ?>
                        <div class="card mb-3">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <a href="/videos/watch?video_id=<?= $video['id'] ?>&user_id=<?= $video['user_id'] ?>&is_paid=<?= $video['is_paid'] ?>"
                                    target="_blank" class="btn btn-light btn-lg rounded-circle" aria-label="Play video">
                                    <i class="bi bi-play-fill"></i>
                                </a>
                            </div>
                            <div class="row g-0">
                                <div class="col-4">
                                    <img src="<?= $video['thumbnail_path'] ?>" class="img-fluid rounded-start"
                                        alt="Thumbnail of <?= htmlspecialchars($video['title']) ?>">
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= htmlspecialchars($video['title']) ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!----------- Report Modal ----------->

    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reportModalLabel">Report message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"
                                placeholder="E.g. The video contin some inappropriate content"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendReportBtn">Send Report</button>
                    <?php include dirname(__DIR__) . "/partials/Loader.php"; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Report Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="reportToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">YoYo Tube</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            if ($('#darkModeToggle').prop('checked')) {
                $('body').addClass('dark-mode');
            }
            const video = $('#videoPlayer')[0];
            const seekBar = $('.seek-bar')[0];
            const seekBarProgress = $('.seek-bar-progress')[0];
            let isPlaying = false;

            // Play/Pause button
            $('#playPauseBtn').click(function () {
                if (isPlaying) {
                    video.pause();
                    $(this).html('<i class="fas fa-play"></i>');
                } else {
                    video.play();
                    $(this).html('<i class="fas fa-pause"></i>');
                }
                isPlaying = !isPlaying;
            });

            // Stop button
            $('#stopBtn').click(function () {
                video.pause();
                video.currentTime = 0;
                isPlaying = false;
                $('#playPauseBtn').html('<i class="fas fa-play"></i>');
            });

            // Mute/Unmute button
            $('#muteBtn').click(function () {
                video.muted = !video.muted;
                $(this).html(video.muted ? '<i class="fas fa-volume-mute"></i>' : '<i class="fas fa-volume-up"></i>');
            });

            // Fullscreen button
            $('#fullscreenBtn').click(function () {
                if (video.requestFullscreen) {
                    video.requestFullscreen();
                } else if (video.mozRequestFullScreen) {
                    video.mozRequestFullScreen();
                } else if (video.webkitRequestFullscreen) {
                    video.webkitRequestFullscreen();
                } else if (video.msRequestFullscreen) {
                    video.msRequestFullscreen();
                }
            });

            // Quality switcher
            $('#qualitySelect').change(function () {
                const quality = $(this).val();
                // In a real implementation, you would switch the video source here
                console.log(`Switching to ${quality}p quality`);
            });

            // Seek bar functionality
            video.addEventListener('timeupdate', function () {
                const value = (100 / video.duration) * video.currentTime;
                seekBarProgress.style.width = value + '%';
            });

            seekBar.addEventListener('click', function (e) {
                const seekTime = (e.offsetX / this.offsetWidth) * video.duration;
                video.currentTime = seekTime;
            });

            // Utility function to debounce the button clicks
            function debounce(func, delay) {
                let timer;
                return function (...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            let likeCount = parseInt($('#likeCount').text(), 10);
            let dislikeCount = parseInt($("#dislikeCount").text(), 10);

            $('#likeBtn').on("click", debounce(function () {
                if ($(this).hasClass('active')) {
                    // Remove like if already active
                    $(this).removeClass('active');
                    // Prevent negative count
                    likeCount = Math.max(likeCount - 1, 0);
                    sendDataToServer(1, "DELETE"); // Remove the like from db
                } else {
                    // Add like, remove dislike if active
                    likeCount++;
                    $(this).addClass('active');

                    if ($('#dislikeBtn').hasClass('active')) {
                        $('#dislikeBtn').removeClass('active');
                        dislikeCount = Math.max(dislikeCount - 1, 0); // Prevent negative count
                    }
                    sendDataToServer(1, "INSERT"); // Add the like
                }
                updateLikeDislikeCounts();
            }, 300)); // 500ms debounce delay

            $('#dislikeBtn').on("click", debounce(function () {
                if ($(this).hasClass('active')) {
                    // Remove dislike if already active
                    $(this).removeClass('active');
                    dislikeCount = Math.max(dislikeCount - 1, 0); // Prevent negative count
                    sendDataToServer(0, "DELETE"); // Remove the dislike
                } else {
                    // Add dislike, remove like if active
                    dislikeCount++;
                    $(this).addClass('active');

                    if ($('#likeBtn').hasClass('active')) {
                        $('#likeBtn').removeClass('active');
                        likeCount = Math.max(likeCount - 1, 0); // Prevent negative count
                        // sendDataToServer(1, "DELETE"); // Remove like if active
                    }
                    sendDataToServer(0, "INSERT"); // Add the dislike
                }
                updateLikeDislikeCounts();
            }, 300)); // 500ms debounce delay


            function updateLikeDislikeCounts() {
                $('#likeCount').text(likeCount);
                $('#dislikeCount').text(dislikeCount);
            }
            function sendDataToServer(like_status, action) {
                $.ajax({
                    url: "<?= BASE_URL . '/' . 'videos/watch/likes' ?>",
                    type: "POST",
                    data: {
                        video_id: "<?= $current_video_id ?>",
                        like_status: like_status,
                        action: action
                    },
                    success: function (data) {
                        console.log('Server Response:', data); // Handle the response
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error); // Handle errors
                    }
                });
            }

            // Comment functionality
            $('#commentForm').submit(function (e) {
                e.preventDefault();
                const commentText = $('#commentText').val().trim();
                if (commentText) {
                    addComment(commentText);
                    $('#commentText').val('');
                }
            });

            function addComment(commenttext) {
                const commentHtml = `
                    <div class="comment">
                        <p><strong>You</strong>: ${commenttext}</p>
                        <small>Just now</small>
                    </div>
                `;
                $('#commentList').prepend(commentHtml);
                saveCommentToDatabase(commenttext);
            }
            function saveCommentToDatabase(commenttext) {
                $.ajax({
                    url: "<?= BASE_URL . "/" . "videos/watch/comments" ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        video_id: "<?= $current_video_id ?>",
                        comment: commenttext
                    },
                    success: function (data) {
                        if (!data.success) {
                            console.error(data.error);
                        }
                        console.log('Server Response:', data.message);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                })
            }
        });
        // ------------ Report Modal ------------
        // Report button
        $('#reportBtn').click(function () {
            $('#reportModal').modal('show');
        });
        // Send reportBtn
        $("#sendReportBtn").on("click", function () {
            const message = $("#message-text").val();
            if (message) {
                $('.loader ').show();
                $.ajax({
                    url: "<?= BASE_URL . '/' . 'videos/watch/report' ?>",
                    type: "POST",
                    dataType: "json",  // Ensure server returns JSON
                    data: {
                        message: message,
                        video_id: "<?= $current_video_id ?>",
                        user_id: "<?= $this->user_id ?>"
                    },
                    success: function (data) {
                        if (!data.success) {
                            console.error(data.error);
                        }
                        // Update toast message and show it
                        $('#reportToast .toast-body').text(data.message);
                        // hide the report Modal

                        $('#reportModal').modal('hide');
                        $('.loader ').hide();

                        // show Toast 
                        $('#reportToast').toast('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

    </script>
</body>

</html>