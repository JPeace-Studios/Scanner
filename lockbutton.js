function lockButton(name1, name2)
{
  var firstValue = document.forms["loginBox"][name1].value;
  var secoundValue = document.forms["loginBox"][name2].value;
  if (firstValue == null || firstValue == "" || secoundValue == null || secoundValue == "")
  {
    document.getElementById("submitButton").disabled = true;
    document.getElementById("submitButton").style.cursor = 'not-allowed';
  }
  else
  {
    document.getElementById("submitButton").disabled = false;
    document.getElementById("submitButton").style.cursor = 'pointer';
  }
}
