<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="submitPayuForm()" class="bg-light">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow p-4" style="width: 400px;">
            <div class="card-body text-center">
                <div class="spinner-border text-primary mb-4" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4 class="card-title mb-3">Processing Payment...</h4>
                <p class="text-muted">Please do not refresh the page or click the back button.</p>
                <form action="{{$action}}" method="post" name="payuForm">
                    <input type="hidden" name="key" value="{{$MERCHANT_KEY}}" />
                    <input type="hidden" name="hash" value="{{$hash}}" />
                    <input type="hidden" name="txnid" value="{{$txnid}}" />
                    <input type="hidden" name="amount" value="{{$amount}}" />
                    <input type="hidden" name="firstname" id="firstname" value="{{$name}}" />
                    <input type="hidden" name="email" id="email" value="{{$email}}" />
                    <input type="hidden" name="productinfo" value="Webappfix" />
                    <input type="hidden" name="surl" value="{{ $successURL }}" />
                    <input type="hidden" name="furl" value="{{ $failURL }}" />
                    <input type="hidden" name="service_provider" value="payu_paisa" />
                    <?php if (!$hash) { ?>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var payuForm = document.forms.payuForm;
        payuForm.submit();
    </script>
</body>
</html>
