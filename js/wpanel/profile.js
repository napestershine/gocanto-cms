
$('#btnContactSignUp').click(function(event) {
    $(this).attr({disabled: 'disabled'});
    $(this).html('Sending ...');
    $('#frmSignUp').submit();
});

$('#frmSignUp').ajaxForm({
    dataType: 'JSON',
    success : function(data){  console.log(data);

        $('#contact-reveal-signup h2').html(data['title']);
        $('#contact-reveal-signup h5').append(data['message']);
        $('#contact-reveal-signup').foundation('reveal', 'open');

        if (data['out']=='1'){
            setTimeout(function(){
                redirect(data['url']);
            }, 5000);
        }
        $('#btnContactSignUp').removeAttr('disabled');
        $('#btnContactSignUp').html('&nbsp;&nbsp;&nbsp;&nbsp;'+data['label_button']+'&nbsp;&nbsp;&nbsp;&nbsp;');
        
    }
});

$('#close_message').click(function(event) {
    $('#contact-reveal-signup h2').html('');
    $('#contact-reveal-signup h5').html('');
});

$('#frmSignUp').on('invalid', function(event) {
    $('#btnContactSignUp').removeAttr('disabled');
    $('#btnContactSignUp').html('&nbsp;&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;&nbsp;');
});