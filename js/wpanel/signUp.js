$('#btnSignUp').click(function(event) 
{
    if ($('#txtPass01').val() == $('#txtPass02').val())
    {
        $(this).attr({disabled: 'disabled'});
        $(this).html('Sending ...');
        $('#frmSignUp').submit();
    }

    else
    {
        $('#reveal-signup-error').foundation('reveal', 'open');
        setTimeout(function()
        {    
            $('#reveal-signup-error').foundation('reveal', 'close');
            $('#txtPass01').focus();
        }, 5000);
    }
});

$('#frmSignUp').ajaxForm({
    dataType: 'JSON',
    success : function(data)
    {
        $('#reveal-signup h2').empty();
        $('#reveal-signup h5').empty();
        $('#reveal-signup h2').html(data.title);
        $('#reveal-signup h5').append(data.message);
        $('#reveal-signup').foundation('reveal', 'open');

        if (data.out=='ok')
        {
            setTimeout(function(){
                redirect(data.url);
            }, 5000);
        }
        $('#btnSignUp').removeAttr('disabled');
        $('#btnSignUp').html(data.label_button);
    }
});

$('#close_message').click(function(event)
{
    $('#reveal-signup h2').html('');
    $('#reveal-signup h5').html('');
});

$('#frmSignUp').on('invalid', function(event)
{
    $('#btnSignUp').removeAttr('disabled');
    $('#btnSignUp').html('Submit');
});
