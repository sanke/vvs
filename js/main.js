$(function() {
  $( "#tabs" ).tabs({
    cache:false
  });
  $("#btnDisconnect").button({
    icons : {
      primary:"ui-icon-circle-close"
    }
  });
  $("input:submit").button();
});


$(".salinti").live('click', function(event) {
  $(this).parent().attr('class');
  $(this).parent().parent().fadeOut(300);
});

$("#addVireja").click(function(){
  $("#mainContent").html("Kraunama...").load("pridetiVireja.php");
});

$("#addProdukta").click(function(){
  $("#mainContent").html("Kraunama...").load("pridetiProdukta.php");
});

$("#addPatiekala").click(function(){
  $("#mainContent").html("Kraunama...").load("pridetiPatiekala.php");
});

$("#addPatProd").click(function(){
  $("#maindiv").html("Kraunama...").load("pridetiPatProd.php");
});

$("#mngSandelys").click(function(){
  $("#mainContent").html("Kraunama...").load("sandelys.php");
});

$("#mngVirtuve").click(function(){
  $("#mainContent").html("Kraunama...").load("virtuve.php");
});

$("#mngGamyba").click(function(){
  $("#mainContent").html("Kraunama...").load("gamybosAtaskaita.php");
});

$("#btnDisconnect").click(function(){
  alert("Disconnect");
  $("#tabs").load("atsijungti.php",4);
});