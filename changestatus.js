function changestatus(sid)
{
  var ldate = document.getElementById("ldate").value;
  var ltime = document.getElementById("ltime").value;
  var changed = document.getElementById(sid).value;
  //document.getElementById("loginBox").innerHTML = "You selected: " + changed;
  if (changed == "absent")
  {
    changed = 0;
  }
  else if (changed == "present")
  {
    changed = 1;
  }
  else if (changed == "late")
  {
    changed = 2;
  }
  document.cookie = "ldate=" + ldate;
  document.cookie = "ltime=" + ltime;
  document.cookie = "changestatus=" +  sid + "," + changed;
  window.location.href = "editlesson.php";
}
