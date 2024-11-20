<?php
$current_video_id = $this->current_video_info['id'];
$lates_videos_info = $this->latest_videos_info;
$comments = $this->comments;
$username = $_COOKIE['user_name'] ?? "";
$is_user_like = !empty($this->is_user_like_video['is_liked']) ? "active" : "";
$is_user_dislike = (isset($this->is_user_like_video['is_liked']) && $this->is_user_like_video['is_liked'] === 0) ? "active" : "";

// Format the Time
function timeAgo($time)
{
    $time_difference = time() - strtotime($time);

    if ($time_difference < 1) {
        return 'Just now';
    }

    $condition = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YoYo Tube</title>
    <link rel="stylesheet" href="/css/4-pages/videosWatch.css">
    <style>
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



        .comment {
            border-bottom: 1px solid var(--border-color);
            padding: 0.5rem 0;
        }

        .comment:last-child {
            border-bottom: none;
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
    </style>
</head>

<body class="clr_light_gray">
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="video-container mb-4">
                    <video id="videoPlayer" class="w-100 h-100 rounded">
                        <source src="<?= htmlspecialchars($this->current_video_info['file_path']) ?? "" ?>"
                            type="video/mp4">
                    </video>
                    <div class="controls p_6">

                        <div class="seek-bar w-100 m_block-end_6">
                            <div class="seek-bar-progress h-100 bg_aqua"></div>
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

                <div class="mb-2">

                    <h4 class="video_title" id="videoTitle">
                        <?= htmlspecialchars($this->current_video_info['title']) ?? "" ?>
                    </h4>
                    <div class="position-relative">
                        <div id="videoDescription" class="videoDescription mb-1 bg_dark_gray rounded">
                            <span class="upload_time fs_75 fw-bold clr_teal my-1">
                                <?php
                                $uploadTime = htmlspecialchars(string: $this->current_video_info['created_at']) ?? "";
                                $formated_time = timeAgo($uploadTime);
                                echo $formated_time;
                                ?>
                            </span>
                            <p class="my-2"> <?= htmlspecialchars($this->current_video_info['description']) ?? "" ?>
                            </p>
                        </div>
                        <i class="fa-solid fa-chevron-down rounded-circle position-absolute"></i>
                    </div>
                    <button id="reportBtn" class="btn btn-primary my-2 fw-medium">Report Video</button>
                </div>

                <div class="comment-section p_1 rounded">
                    <h6> Comments: <strong class="clr_teal"><?= count($comments) ?? 0 ?></strong></h6>
                    <form id="commentForm" class="mb-3 form-group">
                        <div class="my-3 d-grid position-relative">
                            <!-- Profile img -->
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="data:image/jpeg;base64,<?= $user['profile_image'] ?>" alt="Profile Image"
                                    class="profile_image rounded-circle">

                            <?php else: ?>
                                <i class="fa-solid fa-user"></i>
                            <?php endif; ?>

                            <input class="form-control" id="commentText" rows="3"
                                placeholder="Share your thoughts..."></input>
                            <!-- Submit Comment -->
                            <button type="submit"
                                class="btn btn-primary fs_85 my_2 position-absolute top-0 end-0">Comment</button>
                        </div>
                    </form>
                    <div id="commentList">
                        <!-- Existing comments -->
                        <?php if (empty($comments)): ?>
                            <p class="fs_90">No comments yet.</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment position-relative">
                                    <p><strong>
                                            <?php
                                            if ($comment['commenter_name'] === $_COOKIE['user_name'] || $comment['commenter_name'] === $this->current_video_info['user_id']) {
                                                echo "You";
                                            } else {
                                                echo htmlspecialchars($comment['commenter_name']);
                                            }
                                            ?>
                                        </strong>: <?= html_entity_decode(
                                            $comment['comment_text'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </p>
                                    <small class="position-absolute end-0 top-0"><?php
                                    $comment_txt = htmlspecialchars($comment['comment_created_at']);
                                    $date = timeAgo($comment_txt);
                                    echo $date;
                                    ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-1">
                <h5>Related Videos</h5>
                <div id="relatedVideos">
                    <?php foreach ($lates_videos_info as $video): ?>
                        <div class="card mb-3">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <a href="/videos/watch?video_id=<?= $video['id'] ?>&user_id=<?= $video['user_id'] ?>&is_paid=<?= $video['is_paid'] ?>"
                                    target="_blank" class="btn btn-primary btn-md rounded-circle" aria-label="Play video">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                            <div class="row g-0">
                                <div class="col-4 col-md-3 col-lg-4 p-1 rounded">
                                    <img src="<?= $video['thumbnail_path'] ?>" class="img-fluid rounded-start"
                                        alt="Thumbnail of <?= htmlspecialchars($video['title']) ?>">
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h6 class="card-title clr_light_gray fs_85 my-1">
                                            <?= substr(htmlspecialchars($video['title']), 0, 40) ?>
                                        </h6>
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

    <div class="modal fade h-100" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reportModalLabel">Report</h1>
                    <button type="button" class="ms-auto bg-transparent border-0" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-solid fa-xmark clr_light_gray" type="button" data-bs-dismiss="offcanvas"
                            aria-label="Close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 form-group">
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
    <div class="toast-container position-fixed end-0 p-3">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="reportToast">
            <div class="toast-header bg_light_gray clr_darkest_black">
                <i class="fa-solid fa-exclamation me-2"></i>
                <strong class="me-auto navbar-brand">YOYO Tube</strong>
                <i class="fa-solid fa-xmark ms-1" type="button" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <div class="toast-body bg_darkest_black clr_light_gray text-center">
            </div>
        </div>
    </div>
    <script>
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
        // ------------ Report Modal ------------
        // Report button
        $('#reportBtn').click(function () {
            $('#reportModal').modal('show');
        });
        // Send reportBtn
        $("#sendReportBtn").on("click", function () {
            $(this).focus();
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
        // Toogle Description
        $('.fa-chevron-down').on('click', function () {
            $(this).toggleClass('rotate');
            $('#videoDescription').toggleClass('animate');
        })
    </script>
</body>

</html>