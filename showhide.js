function changeContent(toShowId, redirect=0)
{
  if (redirect != 0) {
    window.location.href = "adminpanel.php#" + toShowId;
  }
  else {
    var toHide = document.getElementsByClassName("hideOff");
    var i;
    for (i = 0; i < toHide.length; i++)
    {
      toHide[i].className = "hideOn";
    }
    var toShow = document.getElementById(toShowId);
    toShow.className = "hideOff";
  }
}
