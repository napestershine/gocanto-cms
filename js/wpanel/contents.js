CKEDITOR.replace('body',
    {
        toolbar : getCkEditorToolbar(true)
    }
);

$('.btnSectionsSave').click(function(event) {
    $(this).attr({disabled: 'disabled'});
    $(this).html('Sending ...');
    $('#frmSections').submit();
});

$('#frmSections').ajaxForm({
    dataType: 'json',
    success : function(data) {
        $('html, body').animate({scrollTop : 0},500);
        $('.alert-box').fadeIn();
        $('.alert-box h6').html(data.title+'<p>'+data.message+'</p>');
        $('.btnSectionsSave').removeAttr('disabled');
        $('.btnSectionsSave').html('Submit');
        $("#frmSections").attr("action", "/content/update");
        $('#id').val(data.id);
        if (data.out=='ok'){
            $('.alert-box').removeClass( "alert" ).addClass( "success" );
        }else{
            $('.alert-box').removeClass( "success" ).addClass( "alert" );
        }
        setTimeout(function(){
                $('.alert-box').fadeOut();
        }, 3500);
    }
});

$('#frmSections').on('invalid', function(event) {
    $('.btnSectionsSave').removeAttr('disabled');
    $('.btnSectionsSave').html('Submit');
});