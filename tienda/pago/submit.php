<?php 
session_start();
//Database credentials
$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName     = 'tiendae';

//Connect with the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//Display error if failed to connect
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

//check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){
    //get token, card and user info from the form
    $token  = $_POST['stripeToken'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $card_num = $_POST['card_num'];
    $card_cvc = $_POST['cvc'];
    $card_exp_month = $_POST['exp_month'];
    $card_exp_year = $_POST['exp_year'];
    
    //include Stripe PHP library
    require_once('../vendor/stripe/stripe-php/init.php');
    
    //set api key
    $stripe = array(
      "secret_key"      => "sk_test_51HLCzZBvo2tPPtyxl4hEgvGSjIzQdU9wMrjLGHKnNoIBPEW5CVACUAKbgdrndr4L2CCmJIeuExQiObPqmQffc5NC00uH5ZRu6l",
      "publishable_key" => "pk_test_51HLCzZBvo2tPPtyxcUwEJ2vGhSiqpYlUjtZM2vhdCVZJeH9cOoAClCsmP1Jf4zIJDy9aq66aSjh7GqhkNBiuTMNl00Mm8wdBqw"
    );
    
    \Stripe\Stripe::setApiKey($stripe['secret_key']);
    
    //add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => $email,
        'source'  => $token
    ));
    
    //item information
    $itemName = $_SESSION["nomProd"];
    $itemNumber = "234";
    $itemPrice = $_SESSION["precioProd"];
    $currency = "mxn";
    $orderID = "Null";
    
    //charge a credit or a debit card
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $itemPrice,
        'currency' => $currency,
        'description' => $itemName,
        'metadata' => array(
            'order_id' => $orderID
        )
    ));
    
    //retrieve charge details
    $chargeJson = $charge->jsonSerialize();

    //check whether the charge is successful
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson
['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
        //order details 
        $amount = $chargeJson['amount'];
        $balance_transaction = $chargeJson['balance_transaction'];
        $currency = $chargeJson['currency'];
        $status = $chargeJson['status'];
        $date = date("Y-m-d H:i:s");
        

        
        //insert tansaction data into the database
        $sql = 
"INSERT INTO orders(name,email,card_num,card_cvc,card_exp_month,card_exp_year,
item_name,item_number,item_price,item_price_currency,paid_amount,
paid_amount_currency,txn_id,payment_status,created,modified) VALUES
('".$name."','".$email."','".$card_num."','".$card_cvc."','".$card_exp_month."',
'".$card_exp_year."','".$itemName."','".$itemNumber."','".$itemPrice."','".$currency."',
'".$amount."','".$currency."','".$balance_transaction."'
,'".$status."','".$date."','".$date."')";
        $insert = $db->query($sql);
        $last_insert_id = $db->insert_id;
        
        //if order inserted successfully
        if($last_insert_id && $status == 'succeeded'){
            $statusMsg = "<h2>EL Pago Ha Sido Exitoso.</h2>
<h4>Nmero De Orden: {$last_insert_id}</h4>";

        }else{
            $statusMsg = "La Transaction Ha Fallado";
        }
    }else{
        $statusMsg = "La Transaction Ha Fallado";
    }
}else{
    $statusMsg = "Error en el relleno de datos.......";
}

//show success or error message
echo $statusMsg;

 ?>

<a href="../compras.php" class="btn btn-warning pull-right">Ver Compras</a>   
