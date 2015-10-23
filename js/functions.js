function redir(url){
	var hash=document.location.pathname==''&&location.search.substring(1)=='';
	if(url.substr(0,1)=='#'){
		if(hash)
			document.location.hash=url.substr(1);
		else
			document.location='./'+url;
	}else
		document.location=url;
}

function redirect(url, op){
	if(op){
		window.open(url);
	}else if(url.substr(0,1)=='#'){
		document.location.hash=url.substr(1);
	}else{
		document.location=url;
	}
}

function goToScroll(anchor){
	$('html, body').animate({
    	scrollTop: $(anchor).offset().top-63
	}, 2000);
}
 
function newsletters (){
	$('#frmNewsletters').ajaxForm({
		dataType: 'JSON',
		success : function(data) {
			$('#newsletters-reveal h2').html(data['title']);
			$('#newsletters-reveal h5').html(data['message']);
			$('#newsletters-reveal').foundation('reveal', 'open');
			$('#btnSaveNewsletters').removeAttr('disabled');
			$('#btnSaveNewsletters').html('Suscribirme');
			$('#frmNewsletters').trigger("reset");
		}
	});

	$('#btnSaveNewsletters').click(function(event) {
		$(this).attr({disabled: 'disabled'});
		$(this).html('Enviando ...');
		$('#frmNewsletters').submit();
	});

	$('#frmNewsletters').on('invalid', function(event) {
		$('#btnSaveNewsletters').removeAttr('disabled');
		$('#btnSaveNewsletters').html('Suscribirme');
	});
}

function getCkEditorToolbar(advanced){
	
	var full =
		[
			{ name: 'document', items : [ 'Source','-','NewPage','Preview','Print','-','Templates' ] },
			{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
			{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
			{ name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] },
			'/',
			{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote',
			'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
			{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
			{ name: 'insert', items : [ 'Image','HorizontalRule','Table', 'CreateDiv','Iframe'] },
			{ name: 'styles', items : [ 'Format'] },
			{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		];

	var basic = 
		[
			['Source','-','Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
		];

	return advanced ? full : basic;	
}


function showLayer(layer){
	
  		$(layer).fadeIn('slow');
	
}

function changeStatus(control,id) {
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



