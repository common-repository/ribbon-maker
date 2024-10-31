function getCookie(c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
  {
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value;
}

function can_we_skip(c_name)
{
var skipcount=getCookie(c_name+"_skipcount");
var showat=getCookie(c_name+"_showat");
if (skipcount<showat)
  {
	setCookie(c_name+"_skipcount",skipcount++,365);
	return 1;
  }
else 
  {
	setCookie(c_name+"_skipcount",0,365);
	return 0;
  }
}
