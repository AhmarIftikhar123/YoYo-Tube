<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Video Player Interface</title>
          <!-- Bootstrap CSS -->
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <!-- Custom CSS -->
          <style>
                    .bg-card {
                              background-color: #fff;
                    }

                    .bg-muted {
                              background-color: #f8f9fa;
                    }

                    .text-muted-foreground {
                              color: #6c757d;
                    }

                    .text-card-foreground {
                              color: #000;
                    }

                    .aspect-video {
                              aspect-ratio: 16/9;
                    }

                    .slider {
                              height: 4px;
                              width: 100%;
                    }

                    .btn-outline-secondary {
                              color: #6c757d;
                              border-color: #6c757d;
                    }

                    .btn-outline-secondary:hover {
                              color: #fff;
                              background-color: #6c757d;
                    }

                    .btn-outline-primary {
                              color: #007bff;
                              border-color: #007bff;
                    }

                    .btn-outline-primary:hover {
                              color: #fff;
                              background-color: #007bff;
                    }

                    .recommended-video {
                              display: flex;
                              margin-bottom: 15px;
                    }

                    .recommended-video img {
                              width: 120px;
                              height: 68px;
                              object-fit: cover;
                    }

                    .recommended-video .details {
                              margin-left: 10px;
                    }
          </style>
</head>

<body>
          <div class="container my-4">
                    <!-- Video Player -->
                    <div class="bg-card text-card-foreground rounded-lg shadow-lg overflow-hidden">
                              <div class="relative aspect-video bg-black">
                                        <div
                                                  class="absolute inset-0 d-flex justify-content-center align-items-center text-white">
                                                  Video Player Placeholder
                                        </div>
                                        <!-- Video Controls -->
                                        <div
                                                  class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3">
                                                  <div
                                                            class="d-flex justify-content-between align-items-center text-white">
                                                            <button class="btn btn-light" id="playPauseBtn">
                                                                      <svg id="playIcon"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24" fill="currentColor"
                                                                                class="w-6 h-6">
                                                                                <path fill-rule="evenodd"
                                                                                          d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z"
                                                                                          clip-rule="evenodd" />
                                                                      </svg>
                                                                      <svg id="pauseIcon"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24" fill="currentColor"
                                                                                class="w-6 h-6 d-none">
                                                                                <path fill-rule="evenodd"
                                                                                          d="M6.75 5.25a.75.75 0 01.75-.75H9a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75V5.25zm7.5 0A.75.75 0 0115 4.5h1.5a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H15a.75.75 0 01-.75-.75V5.25z"
                                                                                          clip-rule="evenodd" />
                                                                      </svg>
                                                            </button>
                                                            <input type="range" class="slider" id="progressSlider"
                                                                      min="0" max="100" value="0">
                                                            <div class="d-flex align-items-center">
                                                                      <button class="btn btn-light" id="volumeBtn">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                          viewBox="0 0 24 24"
                                                                                          fill="currentColor"
                                                                                          class="w-6 h-6">
                                                                                          <path
                                                                                                    d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z" />
                                                                                          <path
                                                                                                    d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z" />
                                                                                </svg>
                                                                      </button>
                                                                      <input type="range" class="slider w-25"
                                                                                id="volumeSlider" min="0" max="100"
                                                                                value="50">
                                                            </div>
                                                            <button class="btn btn-light">
                                                                      <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24" fill="currentColor"
                                                                                class="w-6 h-6">
                                                                                <path fill-rule="evenodd"
                                                                                          d="M15 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.56l-3.97 3.97a.75.75 0 11-1.06-1.06l3.97-3.97h-2.69a.75.75 0 01-.75-.75zm-12 0A.75.75 0 013.75 3h4.5a.75.75 0 010 1.5H5.56l3.97 3.97a.75.75 0 01-1.06 1.06L4.5 5.56v2.69a.75.75 0 01-1.5 0v-4.5zm11.47 11.78a.75.75 0 111.06-1.06l3.97 3.97v-2.69a.75.75 0 011.5 0v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5h2.69l-3.97-3.97zm-4.94-1.06a.75.75 0 010 1.06L5.56 19.5h2.69a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-4.5a.75.75 0 011.5 0v2.69l3.97-3.97a.75.75 0 011.06 0z"
                                                                                          clip-rule="evenodd" />
                                                                      </svg>
                                                            </button>
                                                  </div>
                                        </div>
                              </div>

                              <!-- Video Details -->
                              <div class="p-4">
                                        <h1 class="h3 font-weight-bold mb-2">Awesome Video Title</h1>
                                        <div class="d-flex justify-content-between mb-3">
                                                  <div class="d-flex align-items-center">
                                                            <img src="/placeholder.svg?height=40&width=40"
                                                                      alt="Channel Avatar" class="rounded-circle mr-3"
                                                                      style="width: 40px; height: 40px;">
                                                            <div>
                                                                      <p class="font-weight-bold mb-1">Channel Name</p>
                                                                      <p class="text-muted">1M subscribers</p>
                                                            </div>
                                                  </div>
                                                  <button class="btn btn-secondary">Subscribe</button>
                                        </div>
                                        <p class="text-muted-foreground mb-3">Lorem ipsum dolor sit amet, consectetur
                                                  adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante
                                                  dapibus diam.</p>
                                        <div class="d-flex mb-3">
                                                  <button class="btn btn-outline-primary mr-2" id="likeBtn">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                      fill="currentColor" class="w-6 h-6">
                                                                      <path
                                                                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                            </svg>
                                                            <span id="likeCount">123K</span>
                                                  </button>
                                                  <button class="btn btn-outline-secondary" id="dislikeBtn">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                      fill="currentColor" class="w-6 h-6">
                                                                      <path
                                                                                d="M12 3.5l1.45 1.32C18.6 8.64 22 11.72 22 15.5c0 3.08-2.42 5.5-5.5 5.5-1.74 0-3.41-.81-4.5-2.09C8.91 20.69 7.24 21.5 5.5 21.5 2.42 21.5 0 19.08 0 16c0-3.78 3.4-6.86 8.55-11.54L12 3.5z" />
                                                            </svg>
                                                            <span id="dislikeCount">1.2K</span>
                                                  </button>
                                        </div>
                                        <textarea class="form-control mb-3" rows="4"
                                                  placeholder="Add a public comment..."></textarea>
                                        <button class="btn btn-primary">Comment</button>
                              </div>
                    </div>

                    <!-- Recommended Videos -->
                    <div class="mt-4">
                              <h2 class="h4 font-weight-bold mb-3">Recommended Videos</h2>
                              <div class="row">
                                        <div class="col-md-4 recommended-video">
                                                  <img src="/path/to/thumbnail1.jpg" alt="Video Thumbnail">
                                                  <div class="details">
                                                            <h5 class="mb-1">Recommended Video 1</h5>
                                                            <p class="text-muted">Channel Name</p>
                                                  </div>
                                        </div>
                                        <div class="col-md-4 recommended-video">
                                                  <img src="/path/to/thumbnail2.jpg" alt="Video Thumbnail">
                                                  <div class="details">
                                                            <h5 class="mb-1">Recommended Video 2</h5>
                                                            <p class="text-muted">Channel Name</p>
                                                  </div>
                                        </div>
                                        <div class="col-md-4 recommended-video">
                                                  <img src="/path/to/thumbnail3.jpg" alt="Video Thumbnail">
                                                  <div class="details">
                                                            <h5 class="mb-1">Recommended Video 3</h5>
                                                            <p class="text-muted">Channel Name</p>
                                                  </div>
                                        </div>
                              </div>
                    </div>
          </div>

          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
          <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>

          <script>
                    $(document).ready(function () {
                              $('#playPauseBtn').click(function () {
                                        $('#playIcon').toggleClass('d-none');
                                        $('#pauseIcon').toggleClass('d-none');
                              });
                              $('#volumeBtn').click(function () {
                                        // Toggle volume icon or functionality
                              });
                    });
          </script>
</body>

</html>