
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('<?=$publishable_key?>');

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response.id;
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }

            $(document).ready(function() {
                $("#payment-form").submit(function(event) {
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");

                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
                });
            });
        </script>

        <h5>Charge $10</h5>
        <!-- to display errors returned by createToken -->
        <div class="row">
            <div data-alert class="alert-box alert radius" style="<?=$error?'':'display:none'?>">
                <?= $error ?>
                <a href="#" class="close">&times;</a>
            </div>
            <div data-alert class="alert-box success radius" style="<?=$success?'':'display:none'?>">
                <?= $success ?>
                <a href="#" class="close">&times;</a>
            </div>  
        </div>  
        <form action="<?=base_url()?>services" method="POST" id="payment-form">
            <input type="hidden" name="email" value="mih@gmail.com">
            <input type="hidden" name="plan" value="1_6">
            <div class="row">
                <div class=" large-6 columns">
                    <label>Card Number</label>
                    <input type="text" size="20" autocomplete="off" class="card-number" />
                </div>
            </div>
            <div class="row">
                <div class=" large-2 columns">
                    <label>CVC</label>
                    <input type="text" size="4" autocomplete="off" class="card-cvc" />
                </div>    
                <div class="large-2 columns">
                <label>Expiration (MM)</label>
                    <input type="text" size="2" class="card-expiry-month "/>
                </div>    
                <div class="large-2 columns">
                <label>(YYYY)</label>
                    <input type="text" size="4" class="card-expiry-year large-1 columns"/>
                </div> 
                <div class="large-6 columns"> </div>  
            </div>
            <button type="submit" class="submit-button tiny">Submit Payment</button>
        </form>
