<?php
$tags = json_decode($this->current_video_info['tags']);
$lates_videos_info = $this->latest_videos_info;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YoYo Tube Video Player</title>
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
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
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
    <div class="container mt-3">
        <h1 class="mb-4">YoYo Tube Video Player
        </h1>
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
                        <button id="playPauseBtn"><i class="fas fa-play"></i></button>
                        <button id="stopBtn"><i class="fas fa-stop"></i></button>
                        <button id="muteBtn"><i class="fas fa-volume-up"></i></button>
                        <button id="fullscreenBtn"><i class="fas fa-expand"></i></button>
                        <select id="qualitySelect" class="form-select d-inline-block w-auto">
                            <option value="240">240p</option>
                            <option value="360">360p</option>
                            <option value="480">480p</option>
                        </select>
                    </div>
                    <div class="paywall d-none">
                        <h2>Premium Content</h2>
                        <p>Please subscribe to access this video.</p>
                        <button class="btn btn-primary">Subscribe Now</button>
                    </div>
                    <div class="age-verification d-none">
                        <h2>Age Restricted Content</h2>
                        <p>You must be 18+ to view this video.</p>
                        <button class="btn btn-primary">Verify Age</button>
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
                        <div class="yoyo-rating">
                            <i class="fas fa-yoyo"></i>
                            <i class="fas fa-yoyo"></i>
                            <i class="fas fa-yoyo"></i>
                            <i class="far fa-yoyo"></i>
                            <i class="far fa-yoyo"></i>
                            <span>(3.0)</span>
                        </div>
                        <button id="reportBtn" class="btn btn-warning mt-2">Report
                            Video</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3>Related Videos</h3>
                    <div id="relatedVideos">
                    <?php foreach ($lates_videos_info as $video): ?>
                        <div class="card mb-3">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <a href="/videos/watch?id=<?= $video['id'] ?>&is_paid=<?= $video['is_paid'] ?>"
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        // Report button
        $('#reportBtn').click(function () {
            alert('Thank you for reporting this video. We will review it shortly.');
        });

        // Dark mode toggle
        $('#darkModeToggle').change(function () {
            $('body').toggleClass('dark-mode');
        });
        // Simulated playback stats tracking
        setInterval(() => {
            console.log(`Current playback time: ${video.currentTime}`);
        }, 5000);

        // Simulated content access control
        // Uncomment these lines to test the paywall or age verification overlay
        // $('.paywall').removeClass('d-none');
        // $('.age-verification').removeClass('d-none');
    </script>
</body>

</html>