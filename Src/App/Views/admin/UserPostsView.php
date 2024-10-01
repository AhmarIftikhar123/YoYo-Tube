<?php
$SingleUserPost = $this->posts;
$AllUserPosts = $this->all_posts;
$username = $this->username ?? "";
$user_id = $this->user_id ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Admin Panel - Podcast Platform</title>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
          <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
          <style>
                    :root {
                              --bg-color: #f8f9fa;
                              --text-color: #212529;
                              --card-bg: #ffffff;
                              --table-header-bg: #7d8999;
                              --table-hover-bg: #f8f9fa;
                    }

                    .dark-theme {
                              --bg-color: #212529;
                              --text-color: #f8f9fa;
                              --card-bg: #535b65;
                              --table-header-bg: #535b65;
                              --table-hover-bg: #343a40;
                    }

                    body {
                              background-color: var(--bg-color);
                              color: var(--text-color);
                              transition: background-color 0.3s, color 0.3s;
                    }

                    h6 strong {
                              color: var(--bg-color);
                              background-color: var(--text-color);
                    }

                    .card {
                              transition: background-color 0.3s;
                    }

                    .table {
                              color: var(--text-color);
                    }

                    .table thead th {
                              background-color: var(--table-header-bg);
                    }

                    .table-hover tbody tr:hover {
                              background-color: var(--table-hover-bg);
                    }

                    .btn-outline-primary {
                              color: var(--text-color);
                              border-color: var(--text-color);
                    }

                    .active_tr {
                              --bs-table-bg: #3e444c !important;
                    }

                    tr td a {
                              background-color: var(--bg-color) !important;
                              color: var(--text-color) !important;
                              border-color: var(--text-color) !important;
                              transition: opacity .2s ease-in-out;

                              &:hover {
                                        opacity: .75;
                              }
                    }

                    .page-link {
                              background: var(--card-bg) !important;
                              color: var(--text-color) !important;
                              border: gray 1px solid !important;

                              &.active {
                                        background: var(--text-color) !important;
                                        color: var(--bg-color) !important;
                                        border: gray 1px solid !important;
                              }
                    }

                    .btn-outline-primary:hover {
                              color: var(--bg-color);
                              background-color: var(--text-color);
                    }
          </style>
</head>

<body>
          <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
          <div class="container mt-4">
                    <h1 class="mb-4">User Management</h1>
                    <h6 class="mb-4">User Name <strong class="fst-italic rounded" style="padding: 0.25rem .5rem;"
                                        id="username"><?= $username ?></strong></h6>
                    <?php if (empty($SingleUserPost)): ?>
                              <?= "<h3 class='card-title text-center text-danger'>No Record Found</h3>" ?>
                    <?php else: ?>
                              <div class="card mb-2">
                                        <div class="card-body">
                                                  <div class="table-responsive">
                                                            <table class="table table-hover ">
                                                                      <thead>
                                                                                <tr>
                                                                                          <th>#</th>
                                                                                          <th>Title</th>
                                                                                          <th>Catogery</th>
                                                                                          <th>Is Paid</th>
                                                                                          <th>Updated At</th>
                                                                                          <th>Action</th>
                                                                                          <th>View</th>
                                                                                </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                                <?php foreach ($SingleUserPost as $Post): ?>
                                                                                          <?php $is_for_public = $Post['for_public'] == 1 ? 'Block' : 'Un-Block'; ?>
                                                                                          <tr>
                                                                                                    <td><?= $Post['id'] ?></td>
                                                                                                    <td><?= substr($Post['title'], 0, 20) ?>...
                                                                                                    </td>
                                                                                                    <td><?= $Post['category'] ?></td>
                                                                                                    <td><?= $Post['is_paid'] ?>
                                                                                                    <td><?= $Post['updated_at'] ?>
                                                                                                    </td>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                              <button class="btn btn-sm btn-outline-<?= $is_for_public !== "Block" ? "success" : "danger" ?> action-btn"
                                                                                                                        data-action="<?= $is_for_public ?>"><?= $is_for_public ?></button>
                                                                                                              <button class="btn btn-sm btn-outline-danger action-btn"
                                                                                                                        data-action="delete">Delete</button>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                              <a class="btn btn-sm btn-outline-primary reported-posts-btn"
                                                                                                                        target="_blank"
                                                                                                                        href="/home/watch?id=<?= $Post['id'] ?>&is_paid=<?= $Post['is_paid'] ?>">Check
                                                                                                                        Out</a>
                                                                                                    </td>
                                                                                          </tr>
                                                                                <?php endforeach; ?>
                                                                      </tbody>
                                                            </table>
                                                  </div>
                                        </div>
                              <?php endif; ?>
                    </div>
                    <?php
                    $number_of_pages = ceil(count($AllUserPosts) / 8);
                    $current_page = $_GET['page'] ?? 1;
                    ?>
                    <nav aria-label="Video pagination"
                              class="pagination pagination-dark align-items-center justify-content-center ">
                              <ul class="pagination">
                                        <li class="page-item">
                                                  <a href="/admin/posts?user_id=<?= $user_id ?>&username=<?= $username ?>&page=<?= $current_page - 1 ?>"
                                                            class="page-link" tabindex="-1" aria-disabled="true"
                                                            style="<?= $current_page > 1 ? "" : "display: none" ?>">
                                                            <span class="visually-hidden">Previous</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                      height="16" fill="currentColor"
                                                                      class="bi bi-chevron-left" viewBox="0 0 16 16">
                                                                      <path fill-rule="evenodd"
                                                                                d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                                            </svg>
                                                  </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
                                                  <li class="page-item" aria-current="page">
                                                            <a href="/admin/posts?user_id=<?= $user_id ?>&username=<?= $username ?>&page=<?= $i ?>"
                                                                      class="page-link <?= $i == $current_page ? "active" : "" ?>"><?= $i ?></a>
                                                  </li>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                                  <a href="/admin/posts?user_id=<?= $user_id ?>&username=<?= $username ?>&page=<?= $current_page + 1 ?>"
                                                            class="page-link" tabindex="-1" aria-disabled="true"
                                                            style="<?= $current_page < $number_of_pages ? "" : "display: none" ?>">
                                                            <span class="visually-hidden">Next</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                      height="16" fill="currentColor"
                                                                      class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                                      <path fill-rule="evenodd"
                                                                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                                                            </svg>
                                                  </a>
                                        </li>
                              </ul>
                    </nav>
          </div>

          <script>
                    // Action buttons
                    $('.action-btn').click(function () {
                              const action = $(this).data('action');
                              const video_id = $(this).closest('tr').find('td:nth-child(1)').text();
                              const username = $('#username').text();
                              let message = '';
                              const button = $(this);  // Store reference to the clicked button
                              switch (action) {
                                        case 'Block':
                                                  message = `Are you sure you want to Block video ${video_id} of User: ${username} ?`;
                                                  break;
                                        case 'Un-Block':
                                                  message = `Are you sure you want to Un-block video ${video_id} of User: ${username} ?`;
                                                  break;
                                        case 'delete':
                                                  message = `Are you sure you want to delete video ${video_id} of User: ${username} ?`;
                                                  break;
                              }

                              if (confirm(message)) {
                                        $.ajax({
                                                  url: '<?= BASE_URL . "/admin/posts/action"; ?>',  // Make sure this route is correctly set up
                                                  type: 'POST',
                                                  ContentType: 'Application/json',
                                                  data: { action: action, video_id: video_id },
                                                  success: function (response) {
                                                            if (response.success) {
                                                                      alert(`Video ${video_id} has been ${action}d`);
                                                                      // Remove the row from the table if the action is Delete
                                                                      const tr = button.closest('tr');
                                                                      if (action === "delete") {
                                                                                tr.remove();  // Use stored reference to the button
                                                                      } else {
                                                                                // Toggle the active class for the row to change the background color
                                                                                // and animate the row to indicate the status change
                                                                                tr.toggleClass("active_tr");
                                                                                tr.fadeTo('fast', 0.5);

                                                                                // Update the button text to the opposite action
                                                                                const updated_action = action === "Block" ? "Un-Block" : "Block";
                                                                                button.text(`${updated_action}`);
                                                                                button.attr('data-action', updated_action);

                                                                                // Update the status tag in the table row
                                                                                if (button.hasClass("btn-outline-success")) {
                                                                                          button.removeClass("btn-outline-success").addClass("btn-outline-danger");
                                                                                } else {
                                                                                          button.removeClass("btn-outline-danger").addClass("btn-outline-success");
                                                                                }

                                                                                // Animate the row to fade back in after 1 second
                                                                                setTimeout(() => {
                                                                                          tr.toggleClass("active_tr");
                                                                                          tr.fadeTo('fast', 1);
                                                                                }, 1000);
                                                                      }
                                                            } else {
                                                                      alert(`${response.message} ${response.video_id}`);
                                                            }
                                                  },
                                                  error: function (res) {
                                                            alert(`Error: ${res.message} ${res.video_id}`);
                                                  }
                                        });
                              }
                    });
          </script>
</body>

</html>