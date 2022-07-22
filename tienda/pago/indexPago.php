<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
<!-- Stripe JavaScript library -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
//set your publishable key
Stripe.setPublishableKey('pk_test_51HLCzZBvo2tPPtyxcUwEJ2vGhSiqpYlUjtZM2vhdCVZJeH9cOoAClCsmP1Jf4zIJDy9aq66aSjh7GqhkNBiuTMNl00Mm8wdBqw');

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        //enable the submit button
        $('#payBtn').removeAttr("disabled");
        //display the errors on the form
        $(".payment-errors").html(response.error.message);
    } else {
        var form$ = $("#paymentFrm");
        //get token id
        var token = response['id'];
        //insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" 
+ token + "' />");
        //submit form to the server
        form$.get(0).submit();
    }
}
$(document).ready(function() {
    //on form submit
    $("#paymentFrm").submit(function(event) {
        //disable the submit button to prevent repeated clicks
        $('#payBtn').attr("disabled", "disabled");
        
        //create single-use token to charge the user
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);
        
        //submit from callback
        return false;
    });
});
</script>


    <div class="wrapper">
        <div class="container-fluidProducto">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                <span class="payment-errors"></span>

                <form action="submit.php" method="POST" id="paymentFrm">
                    <p>
                        <label>Nombre Completo</label>
                        <input type="text" name="name" size="50" />
                    </p>
                    <p>
                        <label>Correo Electronico</label>
                        <input type="text" name="email" size="50" />
                    </p>
                    <p>
                        <label>Numero De Tarjeta</label>
                        <input type="text" name="card_num" size="20" autocomplete="off" 
                class="card-number" />
                    </p>
                    <p>
                        <label>CVV</label>
                        <input type="text" name="cvc" size="4" autocomplete="off" class="card-cvc" />
                    </p>
                    <p>
                        <label>Expiracion (MM/YYYY)</label>
                        <input type="text" name="exp_month" size="2" class="card-expiry-month"/>
                        <span> / </span>
                        <input type="text" name="exp_year" size="4" class="card-expiry-year"/>
                    </p>

                    <button type="submit" id="payBtn">Procesar Pago</button>
                    <a href="../productos.php" class="btn btn-warning pull-right">Regresar</a>   
                </form>
            </div>
        </div>
    </div>
</div>
</div>