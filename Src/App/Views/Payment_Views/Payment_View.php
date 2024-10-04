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
          </style>
</head>

<body>
          <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
          <div class="container mt-5">
                    <div class="row justify-content-center">
                              <div class="col-md-8">
                                        <div class="text-center mb-5">
                                                  <h1 class="display-4">Access Denied</h1>
                                                  <p class="lead">This content requires a premium subscription to view.
                                                  </p>
                                        </div>

                                        <div class="card mb-5">
                                                  <div class="row g-0">
                                                            <div class="col-md-4">
                                                                      <img src="https://via.placeholder.com/300x200"
                                                                                class="img-fluid rounded-start"
                                                                                alt="Video Thumbnail">
                                                            </div>
                                                            <div class="col-md-8">
                                                                      <div class="card-body">
                                                                                <h5 class="card-title">Exclusive Video
                                                                                          Title</h5>
                                                                                <p class="card-text">By Creator Name</p>
                                                                                <p class="card-text"><small
                                                                                                    class="text-muted">Premium
                                                                                                    content</small></p>
                                                                      </div>
                                                            </div>
                                                  </div>
                                        </div>

                                        <div class="text-center">
                                                  <p class="mb-3">Get premium access for only $20 per month!</p>
                                                  <button class="btn btn-light btn-lg" id="subscribeBtn">Get Premium
                                                            Subscription</button>
                                        </div>
                              </div>
                    </div>
          </div>
          <!-- <script>
        $(document).ready(function() {
            var stripe = Stripe('your_stripe_publishable_key');

            $('#subscribeBtn').click(function() {
                // Redirect to Stripe Checkout
                stripe.redirectToCheckout({
                    lineItems: [{
                        price: 'your_stripe_price_id', // Replace with your actual Stripe Price ID
                        quantity: 1
                    }],
                    mode: 'subscription',
                    successUrl: 'https://your-website.com/success',
                    cancelUrl: 'https://your-website.com/canceled',
                }).then(function (result) {
                    if (result.error) {
                        // If `redirectToCheckout` fails due to a browser or network
                        // error, display the localized error message to your customer.
                        var displayError = document.getElementById('error-message');
                        displayError.textContent = result.error.message;
                    }
                });
            });
        });
    </script> -->
</body>

</html>