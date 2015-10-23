$('#btnResetPassSend').click(function(event)
{
    
    if ($('#txtPass1').val() == $('#txtPass2').val())
    {
        $('#fromResetPass').submit();
    }

    else
    {
        $('#resetPass-error-reveal').foundation('reveal', 'open');
        setTimeout(function()
        {    
            $('#resetPass-error-reveal').foundation('reveal', 'close');
            $('#txtPass1').focus();
        }, 4000);
    }
});

$('#fromResetPass').ajaxForm({
    dataType: 'JSON',
    success : function(data)
    {
        $('#resetPass-success-reveal h3').empty();
        $('#resetPass-success-reveal h5').empty();
        $('#resetPass-success-reveal h3').html(data.title);
        $('#resetPass-success-reveal h5').append(data.message);
        $('#resetPass-success-reveal').foundation('reveal', 'open');

        if (data.out == 'ok')
        {
            setTimeout(function()
            {    
                redir(data.url);
            }, 4000);
        }

        else
        {
            $('#resetPass-success-reveal').foundation('reveal', 'close');
            $('#txtPass1').focus();
        }   
    }
});