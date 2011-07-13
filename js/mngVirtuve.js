$("#add_button").click(function() {
  var params = new Array();

  params[0] = $("#patSaras :selected").val();
  params[1] = $("#virejuSaras :selected").val();
  params[2] = $("input#kiekis").val();
  dataString = makeDataStr(12,params);

  if(!validateInput())
  {
    return false;

  }

  $.ajax({
    type: "POST",
    url: "functions/process.php",
    data: dataString,
    success: function(msg) {

      $("#info").html(msg).show();
    }
  });
  return false;
});

