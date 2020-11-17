if (document.cookie.match(/^(.*;)?\s*scanned\s*=\s*[^;]+(.*)?$/))
{
  if (getCookieValue('scanned') != 0)
  {
    document.body.style.backgroundImage = "linear-gradient(to bottom right, #4ddbff 20%, #20ff35 90%)";
    document.body.style.backgroundColor = "#20ff35";
    document.getElementById("please").innerHTML = getCookieValue('scanned').replace("%20", " ");
    setTimeout(function(){document.getElementById("please").innerHTML = "Put your card"}, 2000);
    setTimeout(function(){document.body.style.backgroundImage = "linear-gradient(to bottom right, #70db70 20%, #0066ff 90%)"}, 2000);
  }
  else
  {
    document.body.style.backgroundImage = "linear-gradient(to bottom right, #4ddbff 20%, #ff2020 90%)";
    document.body.style.backgroundColor = "#ff2020";
    document.getElementById("adminbutton").style.borderColor = "#ff2020";
    document.getElementById("please").innerHTML = "Card unrecognized";
    setTimeout(function(){document.getElementById("please").innerHTML = "Put your card"}, 2000);
    setTimeout(function(){document.getElementById("adminbutton").style.borderColor = "#70db70"}, 1800);
    setTimeout(function(){document.body.style.backgroundImage = "linear-gradient(to bottom right, #70db70 20%, #0066ff 90%)"}, 2000);
  }
  setTimeout(function(){document.body.style.backgroundColor = "#c4c4c4"; }, 2000);
  document.cookie = "scanned=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
}
keys = "";
document.onkeypress = function(e) {
  if (keys.length > 9)
  {
    document.cookie = "idQuery=" + keys;
    keys = "";
    window.location.href = "index.php";
  }
  get = window.event?event:e;
  key = get.keyCode?get.keyCode:get.charCode;
  key = String.fromCharCode(key);
  keys+=key;
}
