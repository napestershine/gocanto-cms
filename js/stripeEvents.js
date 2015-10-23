
                    var handler = StripeCheckout.configure({
                        key: 'pk_test_Q3VpM2oceh1JmWMWXBsMEkUC',
                        image: 'http://simple.web/img/logo_w_strip.png',
                        token: function(token) {
                            $('#process_form .stripeToken').val(token.id);
                            $('#process_form .email').val(token.email);
                            $('#process_form').submit();
                        }
                    });
                
                    $('#quarterly_btn').on('click', function(e) {
                            handler.open({
                            name: 'Antvel eCommerce',
                            description: 'Quarterly',
                            amount: 5999,
                            email: ''
                        });

                        $('#process_form .plan').val('1_3');

                        e.preventDefault();

                    });
                
                    $('#semesterly_btn').on('click', function(e) {
                            handler.open({
                            name: 'Antvel eCommerce',
                            description: 'Semesterly',
                            amount: 9999,
                            email: ''
                        });

                        $('#process_form .plan').val('1_6');

                        e.preventDefault();

                    });
                
                    $('#yearly_btn').on('click', function(e) {
                            handler.open({
                            name: 'Antvel eCommerce',
                            description: 'Yearly',
                            amount: 15999,
                            email: ''
                        });

                        $('#process_form .plan').val('1_12');

                        e.preventDefault();

                    });
                 
            $(window).on('popstate', function() {
            handler.close();
            });
        