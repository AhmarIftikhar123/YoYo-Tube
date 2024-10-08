<?php
$current_video_info = $this->current_video_info;
if (!session_id()) {
    session_start();
}
$user_id = $_SESSION['user_id'] ?? $_COOKIE['user_id'];
if (session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Premium Subscription Required</title>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
    <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
    <style>
        :root {
            --bg-color: #f8f9fa;
            --text-color: #212529;
            --card-bg: #ffffff;
            --btn-primary-bg: #0d6efd;
            --btn-primary-color: #ffffff;
        }

        .dark-theme {
            --bg-color: #212529;
            --text-color: #f8f9fa;
            --card-bg: #343a40;
            --btn-primary-bg: #0d6efd;
            --btn-primary-color: #ffffff;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .card {
            background-color: var(--card-bg);
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: var(--btn-primary-bg);
            color: var(--btn-primary-color);
        }

        .modal-content {
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .loader {
            display: flex;
            align-items: center;
        }

        .bar {
            display: inline-block;
            width: 3px;
            height: 10px;
            background-color: rgba(255, 255, 255, .5);
            border-radius: 10px;
            animation: scale-up4 1s linear infinite;
        }

        .bar:nth-child(2) {
            height: 20px;
            margin: 0 5px;
            animation-delay: .25s;
        }

        .bar:nth-child(3) {
            animation-delay: .5s;
        }

        @keyframes scale-up4 {
            20% {
                background-color: #ffff;
                transform: scaleY(1.5);
            }

            40% {
                transform: scaleY(1);
            }
        }
    </style>
</head>

<body>
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mb-5">
                    <h1 class="display-4">Access Denied</h1>
                    <p class="lead">
                        You need to Buy to Watch this video.
                    </p>
                </div>

                <div class="card mb-5">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $current_video_info['thumbnail_path'] ?? "https://via.placeholder.com/300x200" ?>"
                                class="img-fluid rounded-start" alt="Video Thumbnail">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= substr($current_video_info['title'] ?? "", 0, 20) ?? "Title is Not found" ?>...
                                </h5>
                                <p class="card-text">By Creator Name</p>
                                <p class="card-text"><small
                                        class="text-muted fw-bold"><?= $current_video_info['is_paid'] ? "Paid" : "Free" ?></small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="mb-3">Pay only $<span class="fw-bold"
                            id="price"><?= $current_video_info['price'] ?? "0.00" ?></span> to watch this video!</p>
                    <button class="btn btn-light btn-lg" id="subscribeBtn">Pay Now</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Secure Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="payment-form">
                        <div id="card-element">
                            <!-- Stripe Card Element will be inserted here -->
                        </div>
                        <div id="card-errors" role="alert" class="mt-2 text-danger"></div>
                        <button id="submit" class="btn btn-light mt-3">Pay Now</button>
                        <div class="loader m-2">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </div>
                    </form>
                    <div id="payment-result" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const hideLoader = () => {
        $('.loader').hide();
        $('.loader').css("display", "none");
    }
    const showLoader = () => {
        $('.loader').show();
        $('.loader').css("display", "flex");
    }
    const stripe = Stripe('pk_test_51Q5gn6EQVKGjbQGAtUA9x0HT3lBThNmARbHCutAi87uNtZ5fWGL8e1C9AnAS2W7nNGKE2VLj3yUdKlFu5ydg4v8u00I7kJQ9kD'); // Replace with your publishable key
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');
    hideLoader();

    // Subscribe button click handler
    $('#subscribeBtn').click(function () {
        $('#paymentModal').modal('show');
    });

    $('#payment-form').on('submit', function (event) {
        event.preventDefault();
        showLoader();
        // Create PaymentMethod
        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        }).then(function (result) {
            if (result.error) {
                // Show error to your customer
                $('#payment-result').text(result.error.message);
                hideLoader();

            } else {
                // Send paymentMethod.id to your server (see Step 5)
                $.ajax({
                    url: "<?= BASE_URL . "/" . "payment" ?>",
                    type: 'POST',
                    data: {
                        payment_method_id: result.paymentMethod.id,
                        price: <?= $current_video_info['price'] ?? "0.00" ?>,
                        video_id: <?= $current_video_info['id'] ?? "0" ?>,
                        user_id: <?= $user_id ?>
                    },
                    success: function (response) {
                        hideLoader();
                        $('#payment-result').html(`
            Transaction ID: ${response.transaction_id} <br>
            Payment Amount: $${response.payment_amount} <br>
            Payment Method: ${response.payment_method_type} <br>
            Card Brand: ${response.card_brand} <br>
            Last 4 digits: ${response.last4} <br>
            Payment Status: ${response.payment_status} <br>
            Payment Date: ${response.payment_date}
        `);
                    },
                    error: function (xhr, status, error) {
                        $('#payment-result').text('Payment processing failed: ' + error);
                    }
                });
            }
        });
    });
</script>

</html>