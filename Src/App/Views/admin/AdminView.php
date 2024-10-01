<?php
$Posts = $this->posts;
$AllPosts = $this->all_posts;
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
          <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

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

                    .btn-outline-primary:hover {
                              color: var(--bg-color);
                              background-color: var(--text-color);
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
          </style>
</head>

<body>
          <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
          <div class="container mt-4">
                    <h1 class="mb-4">User Management</h1>
                    <div class="card mb-4">
                              <div class="card-body">
                                        <div class="table-responsive">
                                                  <table class="table table-hover">
                                                            <thead>
                                                                      <tr>
                                                                                <th>#</th>
                                                                                <th>User</th>
                                                                                <th>Email</th>
                                                                                <th>Role</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th>
                                                                                <th>Total Posts</th>
                                                                      </tr>
                                                            </thead>
                                                            <tbody>
                                                                      <?php foreach ($Posts as $Post): ?>
                                                                                <?php $is_blocked = !$Post['is_blocked'] ? "Block" : "Un-Block"; ?>
                                                                                <tr>
                                                                                          <td><?= $Post['id'] ?></td>
                                                                                          <td><?= $Post['username'] ?></td>
                                                                                          <td><?= $Post['email'] ?></td>
                                                                                          <td><?= (int) $Post['role'] === 1 ? "Admin" : "User" ?>
                                                                                          </td>
                                                                                          <td><span class="badge bg-<?= $is_blocked !== "Block" ? "danger" : "success" ?>"><?= $Post['is_blocked'] === 1 ? "Blocked" : "Active" ?></span>
                                                                                          </td>
                                                                                          <td>
                                                                                                    <button class="btn btn-sm btn-outline-<?= $is_blocked !== "Block" ? "success" : "danger" ?> action-btn"
                                                                                                              data-action="<?= $is_blocked ?>"><?= $is_blocked ?></button>
                                                                                                    <button class="btn btn-sm btn-outline-danger action-btn"
                                                                                                              data-action="delete">Delete</button>
                                                                                          </td>
                                                                                          <td>
                                                                                                    <a class="btn btn-sm btn-outline-primary reported-posts-btn"
                                                                                                              target="_blank"
                                                                                                              href="<?= BASE_URL . "/admin/posts?user_id=" . $Post['id'] . "&username=" . $Post['username'] ?>"><?= $Post['total_posts'] ?></a>
                                                                                          </td>
                                                                                </tr>
                                                                      <?php endforeach; ?>
                                                            </tbody>
                                                  </table>
                                        </div>
                              </div>
                    </div>
                    <?php
                    $number_of_pages = ceil(count($AllPosts) / 8);
                    $current_page = $_GET['page'] ?? 1;
                    ?>
                    <nav aria-label="Video pagination"
                              class="pagination pagination-dark align-items-center justify-content-center ">
                              <ul class="pagination">
                                        <li class="page-item">
                                                  <a href="/admin?page=<?= $current_page - 1 ?>" class="page-link"
                                                            tabindex="-1" aria-disabled="true"
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
                                                            <a href="/admin?page=<?= $i ?>"
                                                                      class="page-link <?= $i == $current_page ? "active" : "" ?>"><?= $i ?></a>
                                                  </li>
                                        <?php endfor; ?>
                                        <li class="page-item">
                                                  <a href="/admin?page=<?= $current_page + 1 ?>" class="page-link"
                                                            tabindex="-1" aria-disabled="true"
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
                              const userName = $(this).closest('tr').find('td:nth-child(2)').text();
                              const user_id = $(this).closest('tr').find('td:nth-child(1)').text();
                              let message = '';
                              const button = $(this);  // Store reference to the clicked button
                              switch (action) {
                                        case 'Block':
                                                  message = `Are you sure you want to Block ${userName}?`;
                                                  break;
                                        case 'Un-Block':
                                                  message = `Are you sure you want to Un-block ${userName}?`;
                                                  break;
                                        case 'delete':
                                                  message = `Are you sure you want to Delete ${userName}?`;
                                                  break;
                              }

                              if (confirm(message)) {
                                        $.ajax({
                                                  url: '<?= BASE_URL . "/admin/action"; ?>',  // Make sure this route is correctly set up
                                                  type: 'POST',
                                                  data: {
                                                            action: action,
                                                            user_id: user_id
                                                  },
                                                  success: function (response) {
                                                            if (response.success) {
                                                                      alert(`${userName} has been ${action}d`);
                                                                      // Remove the row from the table if the action is Delete
                                                                      const tr = button.closest('tr');
                                                                      if (action === "delete") {
                                                                                tr.remove();  // Use stored reference to the button
                                                                      } else {
                                                                                // Toggle the active class for the row to change the background color
                                                                                // and animate the row to indicate the status change
                                                                                tr.toggleClass("active_tr");
                                                                                tr.fadeTo('fast', 0.5);

                                                                                // Update the button text and data-action attribute to the opposite action
                                                                                const updated_action = action === "Block" ? "Un-Block" : "Block";
                                                                                button.text(`${updated_action}`);
                                                                                button.attr('data-action', updated_action);

                                                                                // Update the status tag in the table row
                                                                                const statusTag = button.closest('tr').find('td:nth-child(5) span');
                                                                                if (statusTag.hasClass("bg-success")) {
                                                                                          statusTag.removeClass("bg-success").addClass("bg-danger");
                                                                                          button.removeClass("btn-outline-danger").addClass("btn-outline-success");
                                                                                          statusTag.text("Blocked");
                                                                                } else {
                                                                                          statusTag.removeClass("bg-danger").addClass("bg-success");
                                                                                          statusTag.text("Active");
                                                                                          button.removeClass("btn-outline-success").addClass("btn-outline-danger");

                                                                                }

                                                                                // Animate the row to fade back in after 1 second
                                                                                setTimeout(() => {
                                                                                          tr.toggleClass("active_tr");
                                                                                          tr.fadeTo('fast', 1);
                                                                                }, 1000);
                                                                      }
                                                            } else {
                                                                      alert(`Failed to ${action} user ${userName}.`);
                                                            }
                                                  },
                                                  error: function (res) {
                                                            alert(`Error: ${res.responseText}`);
                                                  }
                                        });
                              }
                    });
          </script>
</body>

</html>