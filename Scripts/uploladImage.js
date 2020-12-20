$( document ).ready(function() {
    alert('x');
  $("form[name='uploader']").submit(function(e) {
  var formData = new FormData($(this)[0]);
  $.ajax({
    url: "Controllers/pngUpload.php",
    type: "POST",
    data: formData,
    success: function (msg) {
      alert(msg);
    },
    cache: false,
    contentType: false,
    processData: false
  });

  e.preventDefault();
});
});