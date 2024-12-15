<?php
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
$user_video_model = $this->user_video_model;

$user_id = $_SESSION["user_id"];

$filter_type = isset($_GET["filter"]) ? str_replace(' ', '+', $_GET["filter"]) : "action";

$offset = !isset($_GET["page"]) ? 0 : ((int) $_GET["page"] - 1) * 8;
$get_user_posts = $user_video_model->get_user_posts($user_id, $offset, 8, $filter_type);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YoYo Tube || Your Videos</title>
    <link rel="stylesheet" href="/css/4-pages/HomeView.css">
</head>

<body>
    <!-- Navigation -->
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>

    <!-- Main Content -->
    <div class="container my-2">
        <!-- Search Iput -->
        <div class="container">

            <div class="input-group my-3 mx-auto align-items-ceter justify-content-center">
                <input type="text" name="search" class="form-control rounded-start
    bg_darkest_black  clr_teal" id="searchInput" placeholder="Search Videos..." list="filterDetails">
                <button class="btn btn-primary rounded-end" type="button" id="searchBtn"><i
                        class="fa-solid fa-magnifying-glass"></i></i></button>
                <datalist id="filterDetails">
                </datalist>
            </div>

            <small class="text-danger text-center d-block ms-2 mb-1 fs_75" id="searchError"></small>
        </div>

        <!-- Video Grid -->
        <div class="row" class="videoGrid_warpper">
            <!-- Video cards will be dynamically inserted here -->

            <div id="videoGrid" class="row">
                <?php foreach ($get_user_posts as $post): ?>
                    <div class="col-md-4 col-lg-3 mb-2">
                        <div class="card clr_light_gray bg_darkest_black fs_1">
                            <img src="<?= $post['thumbnail_path'] ?>" alt="vidoe_thumbnail" class="card-img-top">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <a href="/videos/watch?video_id=<?= $post['id'] ?>&user_id=<?= $post['user_id'] ?>&is_paid=<?= $post['is_paid'] ?>"
                                    target="_blank" class="btn btn-primary p_1 rounded-circle">
                                    <i class="fa-solid fa-play"></i> </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1 fs_1"><?= htmlspecialchars($post['title']) ?></h5>

                                <p class="card-text mb-1 clr_teal fs_85"><?= $post['description'] ?></p>
                            <!--------------- Price & Time of Upload --------------->
                            <div
                                class="d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                                <?php if ($post['price'] <= 0): ?>
                                <span
                                    class="fs_75 clr_darkest_black bg_light_gray mb-1 p_inline_75 p_block_25 rounded">Free</span>
                                <?php else: ?>
                                <span class="fs_75 clr_darkest_black bg_teal mb-1 p_inline_75 p_block_25 rounded">
                                    $
                                    <?= $post['price'] ?>
                                </span>
                                <?php endif; ?>

                                <span class="fs_75 clr_light_gray  mb-1 p_inline_75 p_block_25">
                                    <?= timeAgo($post['updated_at']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <? $get_all_user_posts = $user_video_model->get_all_user_posts($user_id, $filter_type);
        $current_page = $_GET['page'] ?? 1;
        $number_of_pages = ceil(count($get_all_user_posts) / 8);
        ?>

        <nav aria-label="Video pagination" class="pagination pagination-dark align-items-center justify-content-center">
            <ul class="pagination">
                <li class="page-item">
                    <a href="/videos?page=<?= $current_page - 1 ?>" class="page-link" tabindex="-1" aria-disabled="true"
                        style="<?= $current_page > 1 ? "" : "display: none" ?>">
                        <span class="visually-hidden">Previous</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                        </svg>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
                <li class="page-item" aria-current="page">
                    <a href="/videos?page=<?= $i ?>&filter=<?= $filter_type ?>"
                        class="page-link rounded <?= $i == $current_page ? "active" : "" ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
                <li class="page-item">
                    <a href="/videos?page=<?= $current_page + 1 ?>" class="page-link" tabindex="-1" aria-disabled="true"
                        style="<?= $current_page < $number_of_pages ? "" : "display: none" ?>">
                        <span class="visually-hidden">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Footer -->
    <?php include dirname(__DIR__) . "/partials/footer.php"; ?>
    <script>
        const adultContentSwitch = $('#adultContentSwitch');
        const darkModeToggle = $('#darkModeToggle');

        // Function to set the dark mode
        function setDarkMode(isDark) {
            if (isDark) {
                $('body').addClass('dark-mode');
            } else {
                $('body').removeClass('dark-mode');
            }
            localStorage.setItem('darkMode', isDark);
        }

        // Check for saved dark mode preference
        const savedDarkMode = localStorage.getItem('darkMode');
        if (savedDarkMode !== null) {
            setDarkMode(savedDarkMode === 'true');
            darkModeToggle.prop('checked', savedDarkMode === 'true');
        }

        // Dark mode toggle event
        darkModeToggle.on('change', function () {
            setDarkMode(this.checked);
        });

        $('#categoryFilter').on('change', function () {
            if (adultContentSwitch.prop('checked')) return;
            const filter = $(this).val().toLowerCase();
            $('#applyFilters').attr("href", `/videos?filter=${filter}`);
        });

        adultContentSwitch.on('change', function () {
            if ($(this).prop('checked')) {
                $('#applyFilters').attr("href", `/videos?filter=18+`);
            } else {
                const filter = $('#categoryFilter').val().toLowerCase();
                $('#applyFilters').attr("href", `/videos?filter=${filter}`);
            }
        });
    </script>
</body>

</html>
<?php session_write_close(); ?>