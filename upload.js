$(document).on('click','#upload',function(){

var form_data = new FormData();
form_data.append('avatar', avatar.files[0]);

$.ajax({
  url: 'upload.php',
  type: 'POST',
  processData: false, // important
  contentType: false, // important
  dataType : 'json',
  data: form_data,
  success:function(response){
  	$("#status").html(response.message);
  	$("#avatar").val('');
  }
});

});