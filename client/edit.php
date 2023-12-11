<head>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>


<main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
<button id="addPaymentMethod" class="inline-flex bg-black text-white items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 mt-4">
    Add Payment Method
</button>

<script>
  document.getElementById('addPaymentMethod').addEventListener('click', function() {
    Swal.fire({
        title: 'Add Payment Method',
        html:
            '<input id="swal-input1" class="swal2-input" placeholder="Card Number">' +
            '<input id="swal-input2" class="swal2-input" placeholder="Card CVV">' +
            '<input id="swal-input3" class="swal2-input" placeholder="Card EXP" type="date">',
        focusConfirm: false,
        preConfirm: function() {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value
            ]
        }
    }).then(function(result) {
        $.ajax({
            type: 'POST',
            url: 'api/edit_profile.php',
            data: {
                card_number: result.value[0],
                card_ccv: result.value[1],
                card_exp: result.value[2]
            },
            success: function(response) {
                Swal.fire('Success!', 'Payment method added.', 'success');
            },
            error: function() {
                Swal.fire('Error!', 'An error occurred.', 'error');
            }
        });
    });
});
</script>
    </main>