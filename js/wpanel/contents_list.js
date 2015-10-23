$( "#cboListContentFilter" ).change(function() {

	$('#out_ajax').html('Cargando ...');

	$.ajax({
		url: $(this).attr("domain")+'content/ajax_grid/'+$(this).val(),
		type:  'POST',
		dataType: 'HTML',
		success:  function (data) {
			$('#out_ajax').html(data);
		}
	});

});
function status_change(control,id) {
     $.ajax({
       url: control+id+'/'+$('#status_'+id).val(),
       dataType: 'json',
       success: function(data){ 
       	 $('#status_'+id).val(data.sta);
       	 var img=data.sta==1? '/img/Checked.png':'/img/Unchecked.png';
         $(".img_"+id).attr('src',img);
       }
     });
}
function deleteRecord(id, title){
	$('#confirm-reveal h5').append('<strong>'+title+'</strong>');
	$('#confirm-reveal').foundation('reveal', 'open');
	$( "#delete" ).click(function() {
		$.ajax({
			url: '/content/delete/'+id,
			dataType: 'JSON',
			success:  function (data) {
				if (data.out=='ok'){
					$('#confirm-reveal').foundation('reveal', 'close');
					$('#tr_'+id).fadeOut( "slow");
			    }
			}
		});
	});	
}