<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
</head>

<body>
    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('processPayment') }}',
                type: 'POST',
                data: $('#payment-form').serialize(),
                success: function(response) {
                    window.snap.pay(response.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = response.redirect_url;
                        },
                        onPending: function(result) {
                            window.location.href = response.redirect_url;
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal!');
                        },
                        onClose: function() {
                            alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                        }
                    });
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.error) {
                        alert(error.responseJSON.error);
                    } else {
                        alert('Terjadi kesalahan!');
                    }
                }
            });
        });
    </script>

</body>

</html>
