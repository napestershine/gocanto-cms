var map;
    
map = new GMaps({
    div: '#map',
    lat: 35.467550,
    lng: -97.520396,
    zoom: 6
});

map.addMarker({
    lat: 35.467550,
    lng: -97.520396,
    title: 'Oklahoma City'
});

$('#btnContactSave').click(function(event) {
    $(this).attr({disabled: 'disabled'});
    $(this).html('Sending ...');
    $('#frmContact').submit();
});

$('#frmContact').ajaxForm({
    dataType: 'JSON',
    success : function(data) { 
        $('#contact-reveal h2').html(data['title']);
        $('#contact-reveal h5').append(data['message']);
        $('#contact-reveal').foundation('reveal', 'open');
        $('#btnContactSave').removeAttr('disabled');
        $('#btnContactSave').html('Send');
        $('#frmContact').trigger("reset");
        if (data['out']=='ok'){
            setTimeout(function(){
                redirect(data['url']);
            }, 4000);
        }
    }
});

$('#frmContact').on('invalid', function(event) {
    $('#btnContactSave').removeAttr('disabled');
    $('#btnContactSave').html('Send');
});