<?php
session_start();
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit;
}

$bookingid = $_GET['bookingid'] ?? null;

if (isset($_POST['pay_card'])) {
    // Process card payment logic 
    echo "<script>alert('Payment successful via Card!');</script>";
    echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
    exit();
}

if (isset($_POST['pay_khalti'])) {
    // Process Khalti payment logic 
    echo "<script>alert('Payment successful via Khalti!');</script>";
    echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
    exit();
}

if (isset($_POST['pay_esewa'])) {
    // Process eSewa payment logic 
    echo "<script>alert('Payment successful via eSewa!');</script>";
    echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="payment_method.css">
</head>
<body>
    <div class="container py-4">
        <div class="payment-container">
            <ul class="nav nav-tabs mb-4" id="paymentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="card-tab" data-bs-toggle="tab" data-bs-target="#card" type="button" role="tab">Card</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="khalti-tab" data-bs-toggle="tab" data-bs-target="#khalti" type="button" role="tab">Khalti</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="esewa-tab" data-bs-toggle="tab" data-bs-target="#esewa" type="button" role="tab">eSewa</button>
                </li>
            </ul>
            <div class="tab-content" id="paymentTabsContent">
                <div class="tab-pane fade show active" id="card" role="tabpanel">
                    <form method="post" onsubmit="return validateCardForm()">
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="number" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                            <div class="invalid-feedback" id="cardNumberError"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="expiry" class="form-label">Expiry</label>
                                    <input type="month" class="form-control" id="expiry">
                                    <div id="expiryHelp" class="form-text text-muted">Please select the expiry date (MM/YY).</div>
                                    <div class="invalid-feedback" id="expiryError"></div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="number" class="form-control" id="cvv" placeholder="123">
                                <div class="invalid-feedback" id="cvvError"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cardName" class="form-label">Card Holder Name</label>
                            <input type="text" class="form-control" id="cardName" placeholder="Full name on card">
                            <div class="invalid-feedback" id="cardNameError"></div>
                        </div>
                        <button type="submit" class="btn btn-primary pay-btn" name="pay_card">Pay</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="khalti" role="tabpanel">
    <form method="post" onsubmit="return validateKhaltiForm()">
        <div class="mb-3">
            <label for="khaltiID" class="form-label">Khalti ID</label>
            <input type="number" class="form-control" id="khaltiID" placeholder="Khalti account number">
            <div class="invalid-feedback" id="khaltiIDError"></div>
        </div>
        <div class="mb-3">
            <label for="khaltiAmount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="khaltiAmount" placeholder="Enter amount">
            <div class="invalid-feedback" id="khaltiAmountError"></div>
        </div>
        <button type="submit" class="btn btn-success pay-btn" name="pay_khalti">Pay with Khalti</button>
    </form>
</div>

<script>
function validateKhaltiForm() {
  let khaltiID = document.getElementById('khaltiID').value.trim();
  let khaltiAmount = document.getElementById('khaltiAmount').value.trim();
  let isValid = true;
  let missingFields = [];

  // Reset error messages
  document.getElementById('khaltiIDError').textContent = '';
  document.getElementById('khaltiAmountError').textContent = '';

  if (khaltiID === '') {
    missingFields.push('Khalti ID');
    document.getElementById('khaltiIDError').textContent = 'Please enter your Khalti ID.';
    isValid = false;
  }

  if (khaltiAmount === '') {
    missingFields.push('Amount');
    document.getElementById('khaltiAmountError').textContent = 'Please enter the amount.';
    isValid = false;
  }

  if (!isValid) {
    let alertMessage = 'Please enter all details for Khalti.';
    if (missingFields.length === 1) {
      alertMessage = `Please enter ${missingFields[0]} for Khalti.`;
    } else if (missingFields.length > 1) {
      alertMessage = `Please enter the following details for Khalti: ${missingFields.join(', ')}.`;
    }
    alert(alertMessage);
  }

  return isValid;
}
</script>
<div class="tab-pane fade" id="esewa" role="tabpanel">
    <form method="post" onsubmit="return validateEsewaForm()">
        <div class="mb-3">
            <label for="esewaID" class="form-label">eSewa ID</label>
            <input type="number" class="form-control" id="esewaID" placeholder="eSewa account number">
            <div class="invalid-feedback" id="esewaIDError"></div>
        </div>
        <div class="mb-3">
            <label for="esewaAmount" class="form-label">Amount</label>
            <input type="text" class="form-control" id="esewaAmount" placeholder="Enter amount">
            <div class="invalid-feedback" id="esewaAmountError"></div>
        </div>
        <button type="submit" class="btn btn-success pay-btn" name="pay_esewa">Pay with eSewa</button>
    </form>
</div>

<script>
function validateEsewaForm() {
  let esewaID = document.getElementById('esewaID').value.trim();
  let esewaAmount = document.getElementById('esewaAmount').value.trim();
  let isValid = true;
  let missingFields = [];

  // Reset error messages
  document.getElementById('esewaIDError').textContent = '';
  document.getElementById('esewaAmountError').textContent = '';

  if (esewaID === '') {
    missingFields.push('eSewa ID');
    document.getElementById('esewaIDError').textContent = 'Please enter your eSewa ID.';
    isValid = false;
  }

  if (esewaAmount === '') {
    missingFields.push('Amount');
    document.getElementById('esewaAmountError').textContent = 'Please enter the amount.';
    isValid = false;
  }

  if (!isValid) {
    let alertMessage = 'Please enter all details for eSewa.';
    if (missingFields.length === 1) {
      alertMessage = `Please enter ${missingFields[0]} for eSewa.`;
    } else if (missingFields.length > 1) {
      alertMessage = `Please enter the following details for eSewa: ${missingFields.join(', ')}.`;
    }
    alert(alertMessage);
  }

  return isValid;
}
</script>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ensure tabs work properly
            $('button[data-bs-toggle="tab"]').on('click', function() {
                var target = $(this).data('bs-target');
                $('.tab-pane').removeClass('show active');
                $(target).addClass('show active');
            });
        });

function validateCardForm() {
  let cardNumber = document.getElementById('cardNumber').value.trim();
  let expiry = document.getElementById('expiry').value.trim();
  let cvv = document.getElementById('cvv').value.trim();
  let cardName = document.getElementById('cardName').value.trim();
  let isValid = true;
  let missingFields = [];

  // Reset error messages
  document.getElementById('cardNumberError').textContent = '';
  document.getElementById('expiryError').textContent = '';
  document.getElementById('cvvError').textContent = '';
  document.getElementById('cardNameError').textContent = '';

  if (cardNumber === '') {
    missingFields.push('Card Number');
    document.getElementById('cardNumberError').textContent = 'Please enter your card number.';
    isValid = false;
  }

  if (expiry === '') {
    missingFields.push('Expiry Date');
    document.getElementById('expiryError').textContent = 'Please select the expiry date.';
    isValid = false;
  }

  if (cvv === '') {
    missingFields.push('CVV');
    document.getElementById('cvvError').textContent = 'Please enter the CVV.';
    isValid = false;
  }

  if (cardName === '') {
    missingFields.push('Card Holder Name');
    document.getElementById('cardNameError').textContent = 'Please enter the card holder name.';
    isValid = false;
  }

  if (!isValid) {
    let alertMessage = 'Please enter all details.';
    if (missingFields.length === 1) {
      alertMessage = `Please enter ${missingFields[0]}.`;
    } else if (missingFields.length > 1) {
      alertMessage = `Please enter the following details: ${missingFields.join(', ')}.`;
    }
    alert(alertMessage);
  }

  return isValid;
}
</script>
</body>
</html>