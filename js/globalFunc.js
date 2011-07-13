
$.ajaxSetup ({
  cache: false
});

function PrintContent(ctrl)
{
  window.print();
}

var $tabs;

$(function() {
  $(".btnPlus").button({
    icons : {
      primary:"ui-icon-plus"
    }, 
    text:false
  });
  $(".btnMinus").button({
    icons : {
      primary:"ui-icon-minus"
    }, 
    text:false
  });
  $(".btnEdit").button({
    icons : {
      primary:"ui-icon-pencil"
    }, 
    text:false
  });
  $tabs = $('#tabs').tabs();
  $(".btn_print").button({
    icons : {
      primary:"ui-icon-print"
    }, 
    text:false
  });

});

function reloadCurrentTab(){
  var $tabs = $('#tabs').tabs();
  var selected = $tabs.tabs('option', 'selected');
  $('#tabs').tabs("load", selected);
}

function getDate()
{
  var d = new Date();
  var y = d.getFullYear();
  var m = d.getMonth() + 1;
  var day = d.getDate();

  return y + "-" + m + "-" + day;
}

function error(msg){
  $("#messages").prepend('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0.7em;"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><span>' + msg + '</span></div></div>');
  removeLastMessage();
  return false;
}

function info(msg){
  $("#messages").prepend('<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0.7em;"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><span>' + msg + '</span></div></div>');
  removeLastMessage();
  return false;
}


function removeLastMessage(){
  $("#messages div:first-child").delay(6000).fadeOut(3000, function() {
    $(this).remove();
  });
}

function rebindHover(elem){
  $(elem).hover(
    function() {
      $(this).children("td").addClass("tbl-hover");
    },
    function() {
      $(this).children("td").removeClass("tbl-hover");
    });
}

function makeDataStr(id, strArray){
  var str="&ID=" + id;
  if(!strArray)
    return str;
  for(var i=0;i<strArray.length;i++)
    str=str + "&var" + i + "=" + strArray[i];
  return str;
}

function showLoading(elem) {
  
}


function validateInput(){
  var rtrn=true;
  $(".numbers").each(function(){
    var str = $(this).val();
    var patt=/\D/g;
    if(patt.test(str))
    {
      rtrn=false;
      $("#info").html("Įveskite skaičių.").show();
      $(this).css("background-color", "#E38A95");
      $(this).blur();
    }
  });
  return rtrn;
}

$(".numbers").focus(function(){
  $(this).css("background-color", "#BEC8D0");
});
