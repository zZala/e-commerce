<?php
include("../db/connection.php");
if (isset($_GET["type"])) {
    $type = $_GET["type"];

    echo "  <div class='modal-dialog w-auto'>
        <div class='modal-content'>
        <div class='modal-header'>
            <h4 class='modal-title'>New Payment Method</h4>
        </div>
        <div class='modal-body'>
        <form id='form' method='post' action='check/addPaymentMethod.php' enctype='multipart/form-data'>";

    if ($type == 'PayPal') {
        echo "  <h5>Paypal</h5>
                <div class='row'>
                    <div class='col-md-3'>Email: </div>
                    <div class='col-md-3'><input type='email' name='email' id='email' class='form-control w-auto' required></div>
                    <input type='hidden' name='type' value='$type'>
                </div>
                <div class='row'>
                    <div class='col-md-12'><b><p id='error'></p></b></div>
                </div>
                </form>
                </div>
                <div class='modal-footer'>
                    <button class='btn' onclick='toAddPaymentMethod()'>Add</button>
                    <a href='my-account.php?pag=payment'><button type='button' class='btn btn-default'>Cancel</button></a>
                </div>
                </div>
                </div>
                <script>
                function toAddPaymentMethod() {
                    if($('#email').val() != ''){
                        $('#form').submit();
                    } else {
                        $('#error').text('Enter all required fields!');
                    }
                }
                </script>";
    } else if ($type == 'Credit Card') {
        echo "  <h5>Credit Card</h5>
                <div class='row'>
                    <div class='col-md-3'>Card Number: </div>
                    <div class='col-md-3'><input type='text' name='cardNumber' id='cardNumber' class='form-control w-auto' required></div>
                </div>
                <div class='row'>
                    <div class='col-md-3'>Name on Card: </div>
                    <div class='col-md-3'><input type='text' name='nameOnCard' id='nameOnCard' class='form-control w-auto' required></div>
                </div>
                <div class='row'>
                    <div class='col-md-3'>Expiration Date: </div>
                    <div class='col-md-3'><input type='month' name='expirationDate' id='expirationDate' class='form-control w-auto' required></div>
                </div>
                <input type='hidden' name='type' value='$type'>
                <div class='row'>
                    <div class='col-md-12'><b><p id='error'></p></b></div>
                </div>
                </form>
                </div>
                <div class='modal-footer'>
                    <button class='btn' onclick='toAddPaymentMethod()'>Add</button>
                    <a href='my-account.php?pag=payment'><button type='button' class='btn btn-default'>Cancel</button></a>
                </div>
                </div>
                </div>
                <script>
                function toAddPaymentMethod() {
                    if($('#cardNumber').val() != '' && $('#nameOnCard').val() != '' && $('#expirationDate').val() != ''){
                        $('#form').submit();
                    } else {
                        $('#error').text('Enter all required fields!');
                    }
                }
                </script>";
    }
}
