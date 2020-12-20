
<div class="row">
    <div class="col">
        <div class="card text-center">
          <div class="card-header">
            מחשבון RGB
          </div>
          <div class="card-body">
            <h5 class="card-title">העלה תמונה מסוג PNG</h5>
            <form name="uploader" action="" method="post" enctype="multipart/form-data">
                <input class="form-control" type="file" name="pngImage" placeholder="asdg">
                <input class="btn btn-info" type="submit" name="submit" value="העלה" >
                <br><br>
                <div class="spinner-border" role="status" id="spinner" style="display:none;"></div>
                <div id="statusText" style="display:none">מעלה את התמונה</div>
            </form>
          </div>
        </div>
    </div>
</div>

<script>
$( document ).ready(function() {
  $("form[name='uploader']").submit(function(e) {
    $( "#spinner" ).show();
    $( "#statusText" ).show();
    $( "#statusText" ).text("מעלה את תמונה");
    $( "#results" ).hide();
    
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: "Controllers/PngUpload.php",
      type: "POST",
      data: formData,
      dataType: 'json',
      success: function (data) {
          if(data.type=='Error'){
              $( "#spinner" ).hide();
              $( "#statusText" ).text(data.message);
          }
          else{
              $( "#results" ).show();
              $( "#imageContainer" ).attr("src","rgbCalculator/"+data.filePath);
              $( "#statusText" ).text("מחשב ערכי RGB נפוצים");
              $.ajax({
                url: "Controllers/GetTopFiveRgbValues.php",
                type: "POST",
                data: {imagePath: data.filePath },
                success: function (data) {
                    $( "#statusText" ).text("");
                    $( "#spinner" ).hide();
                    console.log(data);
                    var colorSpans = "";
                    data = jQuery.parseJSON(data)
                    jQuery(data).each(function(i, item){ 
                        var rgbColor = item.rgbColor;
                        var hexColor = item.hexColor;
                        var percentage = item.percentage.toFixed(2);
                        percentage *= 100;
                        
                        colorSpans = colorSpans+ '<span style="color:'+hexColor+'">'+rgbColor+' - ';
                        if(percentage == 0)
                            colorSpans = colorSpans+ '~';
                        colorSpans = colorSpans+percentage+'%</span><br>';
                    }); 
                    $( "#resultsContainer" ).html(colorSpans);
                }
              });
          }
      },
      cache: false,
      contentType: false,
      processData: false
    });

    e.preventDefault();
  });
});
</script>