function shareNettby(url, title)
{
  var tmpUrl = encodeURIComponent(url);
  var tmpTitle = encodeURIComponent(title);
  window.open("http://www.nettby.no/user/edit_link.php?name=" + tmpTitle + "&url=" + tmpUrl + "&description=", "Nettby", "width=450,height=430,location=0,menubar=0,scrollbars=1,status=0,toolbar=0");
}

function shareFacebook(url, title)
{
  var tmpUrl = encodeURIComponent(url);
  var tmpTitle = encodeURIComponent(title);
  window.open("http://www.facebook.com/sharer.php?u=" + tmpUrl + "&t=" + tmpTitle, "Facebook", "width=645,height=436,location=0,menubar=0,scrollbars=1,status=0,toolbar=0");
}

function shareStumbleupon(url, title)
{
  var tmpUrl = encodeURIComponent(url);
  var tmpTitle = encodeURIComponent(title);
  window.open("http://www.stumbleupon.com/submit?url=" + tmpUrl + "&title=" + tmpTitle, "Stumbleupon", "width=720,height=436,location=0,menubar=0,scrollbars=1,status=0,toolbar=0");
}

function shareReddit(url, title)
{
  var tmpUrl = encodeURIComponent(url);
  var tmpTitle = encodeURIComponent(title);
  window.open("http://reddit.com/submit?url=" + tmpUrl + "&title=" + tmpTitle, "Reddit", "width=645,height=436,location=0,menubar=0,scrollbars=1,status=0,toolbar=0");
}

function shareDigg(url, title)
{
  var tmpUrl = encodeURIComponent(url);
  var tmpTitle = encodeURIComponent(title);
  window.open("http://digg.com/submit?url=" + tmpUrl + "&title=" + tmpTitle, "Digg", "width=1000,height=500,location=0,menubar=0,status=0,toolbar=0,scrollbars=1");
}

function shareDelicious(url, title)
{
  var tmpUrl = encodeURIComponent(url);
  var tmpTitle = encodeURIComponent(title);
  window.open("http://del.icio.us/post?url=" + tmpUrl + "&title=" + tmpTitle, "Delicious", "width=750,height=500,location=0,menubar=0,scrollbars=1,status=0,toolbar=0");
}