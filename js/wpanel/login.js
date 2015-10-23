$('#btnWpLogin').click(function(event)
{
    $(this).attr({disabled: 'disabled'});
    $(this).html('Sending ...');
    $('#frmWpLogin').submit();
});

$('#frmWpLogin').ajaxForm({
    dataType: 'JSON',
    success : function(data)
    {
        if (data.title == 'ok' && data.message =='ok')
        {
            redir(data.url);
        }
        
        else
        { 
            $('#login-reveal h3').empty();
            $('#login-reveal h5').empty();   
            $('#login-reveal h3').html(data.title);
            $('#login-reveal h5').append(data.message);
            $('#login-reveal').foundation('reveal', 'open');
            $('#btnWpLogin').removeAttr('disabled');
            $('#btnWpLogin').html(data.label_button);
            $('#frmWpLogin').trigger("reset");
            $('#txtLogin').focus();
        }
    }
});

$('#frmWpLogin').on('invalid', function(event) {
    $('#btnWpLogin').removeAttr('disabled');
    $('#btnWpLogin').html('Submit');
});

//forgot
$('#formForgot').ajaxForm({
    dataType: 'JSON',
    success : function(data)
    {
        $('#forgotAlerts').removeClass('alert success');
        $('#forgotAlerts').addClass(data.class);

        $('#forgotAlerts  h6').removeClass();
        $('#forgotAlerts  h6').addClass(data.title_class);

        $('#forgotAlerts').fadeIn();
        $('#forgotAlerts h6').html(data.title);
        $('#forgotAlerts div').html(data.message);

        setTimeout(function()
        {     
            if (data.out == 'ok')
            {
                $('#forgotPass').foundation('reveal', 'close');
            }

            $('#forgotAlerts').fadeOut();
            $('#formForgot').trigger("reset");

        }, 4500); 
    }
});