
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
    <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
    <style>
        body {
            background-color: #121212;
            /* Dark background */
            color: #e0e0e0;
            /* Light text color */
            /* display: grid; */
            place-items: center;
            min-height: 100dvh;
        }


        .container-custom {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem 1rem;
            background-color: #1e1e1e;
            /* Darker container background */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            background-color: #333;
            /* Dark input background */
            color: #e0e0e0;
            /* Light input text color */
            border: 1px solid #444;
            /* Input border */
        }

        .form-control::placeholder {
            color: #888;
            /* Placeholder text color */
        }

        .btn-custom {
            background-color: #007bff;
            /* Bootstrap primary color */
            border-color: #007bff;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            border-color: #0056b3;
        }

        .form-label {
            color: #e0e0e0;
            /* Label text color */
        }
    </style>
</head>

<body>
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>

    <div class="container container-custom">
        <h1 class="text-2xl font-bold mb-6">Payment</h1>
        <!-- <form class="space-y-6"> -->
<!-- <div class="mb-3">
                <label for="card-number" class="form-label">Card Number</label>
                <input type="text" id="card-number" class="form-control" placeholder="1234 5678 9012 3456" required />
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="expiry-date" class="form-label">Expiry Date</label>
                    <input type="text" id="expiry-date" class="form-control" placeholder="MM/YY" required />
                </div>
                <div class="col">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" id="cvv" class="form-control" placeholder="123" required />
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name on Card</label>
                <input type="text" id="name" class="form-control" placeholder="John Doe" required />
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" id="amount" class="form-control" placeholder="0.00" required />
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label">Currency</label>
                <select id="currency" class="form-select">
                    <option value="" disabled selected>Select currency</option>
                    <option value="usd">USD</option>
                    <option value="eur">EUR</option>
                    <option value="gbp">GBP</option>
                </select>
            </div> -->
<form id="payment-form">
    <div id="card-element"><!-- A Stripe Element will be inserted here --></div>
    <button type="submit" id="submit">Pay</button>
    <div id="error-message"></div>
</form>

<!-- <button type="submit" class="btn btn-custom w-100">
                Pay Now
            </button>
        </form> -->
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('pk_test_51Q5gn6EQVKGjbQGAtUA9x0HT3lBThNmARbHCutAi87uNtZ5fWGL8e1C9AnAS2W7nNGKE2VLj3yUdKlFu5ydg4v8u00I7kJQ9kD');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    // $('#payment-form').on('submit', function (event) {
    //     event.preventDefault();

    //     stripe.createPaymentMethod({
    //         type: 'card',
    //         card: cardElement,
    //     }).then(function (result) {
    //         if (result.error) {
    //             // Show error to your customer (e.g., insufficient funds)
    //             $('#error-message').text(result.error.message);
    //         } else {
    //             // Send the PaymentMethod ID to your server
    //             $.ajax({
    //                 url: 'process_payment.php',
    //                 method: 'POST',
    //                 data: { payment_method_id: result.paymentMethod.id },
    //                 success: function (response) {
    //                     // Handle server response (e.g., success or failure message)
    //                     console.log(response);
    //                 }
    //             });
    //         }
    //     });
    // });

</script>

</html>


