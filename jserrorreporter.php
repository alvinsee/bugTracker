<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Chapter 2 : JavaScript Error Reporting Demo</title>
<script src="errorreporter.js" type="text/javascript"></script>
<script type="text/javascript">

/* scripts that may trigger errors */
function badCode()
{
  alert('Good code running when suddenly...');
  abooM('bad code!'); /* BAD CODE ON PURPOSE */ 
  que;
  ambd('ello');
}

</script>
</head>
<body>

<h3>JavaScript - Silent Errors, Deadly Errors</h3>
<form action="#">
	<label>Do you dare press it?
	<input type="button" value="BOOM!" onclick="badCode();" />
	</label>
</form>
<br /><br />
<a href="http://ajaxref.com/ch2/jserror.txt">See error file</a>

</body>
</html>
