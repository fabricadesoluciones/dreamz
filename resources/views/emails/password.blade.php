<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body style="font-family:Arial, Helvetica, sans-serif">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td><img src="http://159.203.131.155/login-mail.jpg" />	</td>
    
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Para establecer o restablecer tu contraseña por favor haz click en el siguiente enlace:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <a href="{{ url('password/reset/'.$token) }}">Establecer contraseña</a>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
