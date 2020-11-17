function buttonclick(a, b=0)
{
  var shade = document.getElementById(a);
  var btn = document.getElementById(b);
  if (shade.className == "hideOn")
  {
    if(b != 0)
    {
      btn.innerText = "Hide students table";
    }
    shade.className = "hideOff";
  }
  else
  {
    if(b != 0)
    {
      btn.innerText = "Show students table";
    }
    shade.className = "hideOn";
  }
}
