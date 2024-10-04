<?php

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
          </style>
</head>

<body>
          <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
          <div class="container mt-4">
                    <h1 class="mb-4">User Management</h1>
                    <div class="card">
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
                                                                      <?php foreach ($AllPosts as $Post): ?>
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
                                                                                                    <button class="btn btn-sm btn-outline-danger action-btn"
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
                                                  message = `Are you sure you want to block ${userName}?`;
                                                  break;
                                        case 'Un-Block':
                                                  message = `Are you sure you want to unblock ${userName}?`;
                                                  break;
                                        case 'Delete':
                                                  message = `Are you sure you want to delete ${userName}?`;
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
                                                                      if (action === "Delete") {
                                                                                tr.remove();  // Use stored reference to the button
                                                                      } else {
                                                                                // Toggle the active class for the row to change the background color
                                                                                // and animate the row to indicate the status change
                                                                                tr.toggleClass("active_tr");
                                                                                tr.fadeTo('fast', 0.5);

                                                                                // Update the button text to the opposite action
                                                                                const updated_action = action === "Block" ? "Un-Block" : "Block";
                                                                                button.text(`${updated_action}`);

                                                                                // Update the status tag in the table row
                                                                                const statusTag = button.closest('tr').find('td:nth-child(5) span');
                                                                                if (statusTag.hasClass("bg-success")) {
                                                                                          statusTag.removeClass("bg-success").addClass("bg-danger");
                                                                                          statusTag.text("Blocked");
                                                                                } else {
                                                                                          statusTag.removeClass("bg-danger").addClass("bg-success");
                                                                                          statusTag.text("Active");

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