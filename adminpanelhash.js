function hashRedirect()
{
  if (window.location.hash) {
    var toHide = document.getElementsByClassName("hideOff");
    var i;
    for (i = 0; i < toHide.length; i++)
    {
      toHide[i].className = "hideOn";
    }
    var toShow = document.getElementById(window.location.hash.substring(1));
    toShow.className = "hideOff";
  }
}
