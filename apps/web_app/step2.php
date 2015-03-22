<?php
require 'fb/fblogin.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
		<link type="text/css" rel="Stylesheet" href="jquery.validity.css" />
        <script type="text/javascript" src="jquery.validity.js"> </script>
        <script type="text/javascript">
            $(function() { 
                $("form").validity(function() {
					$("#password")
                        .require()
                        .match("nonHtml");
						
                });
            });
        </script>
<style type="text/css">
body,td,th {
	font-family: tahoma;
	font-size: 12px;
	color: #000;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	padding:0px 0px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.bd{
	border:2px solid #ff9000;
	width:550px;
	margin:auto;
	padding:20px;
}

</style>
<div   align=center><img src="img/step2.png"></div>
<div class="bd">
<h1>Sharing status</h1>
<?php
	echo "<form id=\"form1\"   action=updatesetting.php?from=step2 method=post>
	  <table width=550 border=0 align=center cellpadding=3px cellspacing=0 id=setting>
	  
		<tr>
		  <td width=100 align=center valign=middle>Data</td>
		  <td width=91 align=center valign=middle>Everyone</td>
		  <td width=91 align=center valign=middle>Password</td>		  
		  <td width=91 align=center valign=top>Friend</td>
		  <td width=91 align=center valign=top>Mutual Friends</td>
		  <td width=91 align=center valign=middle>None</td>
		<tr>
		  <td width=100 align=left valign=top>Name</td>
		  <td width=100 align=center valign=top><input type=radio name=name id=name value=A /></td>
		  <td width=91 align=center valign=top><input type=radio name=name id=name2 value=B /></td>
		  <td width=91 align=center valign=top><input type=radio name=name id=name3 checked value=C /></td>
		  <td width=91 align=center valign=top><input type=radio name=name id=name4 value=D /></td>
		  <td width=91 align=center valign=top><input type=radio name=name id=name5 value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Phone number</td>
		  <td width=91 align=center valign=top><input type=radio name=phone_number id=phone_number value=A /></td>
		  <td width=91 align=center valign=top><input type=radio name=phone_number id=phone_number2 value=B /></td>
		  <td width=91 align=center valign=top><input type=radio name=phone_number id=phone_number3 checked value=C /></td>
		  <td width=91 align=center valign=top><input type=radio name=phone_number id=phone_number4 value=D /></td>
		  <td width=91 align=center valign=top><input type=radio name=phone_number id=phone_number5 value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Address</td>
		  <td width=91 align=center valign=top><input type=radio name=address id=address value=A /></td>
		  <td width=91 align=center valign=top><input type=radio name=address id=address2 value=B /></td>
		  <td width=91 align=center valign=top><input type=radio name=address id=address3 checked value=C /></td>
		  <td width=91 align=center valign=top><input type=radio name=address id=address4 value=D /></td>
		  <td width=91 align=center valign=top><input type=radio name=address id=address5 value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Website</td>
		  <td width=91 align=center valign=top><input type=radio name=website id=website value=A /></td>
		  <td width=91 align=center valign=top><input type=radio name=website id=website2 value=B /></td>
		  <td width=91 align=center valign=top><input type=radio name=website id=website3 checked value=C /></td>
		  <td width=91 align=center valign=top><input type=radio name=website id=website4 value=D /></td>
		  <td width=91 align=center valign=top><input type=radio name=website id=website5 value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Display</td>
		  <td width=91 align=center valign=top><input type=radio name=display id=display value=A /></td>
		  <td width=91 align=center valign=top><input type=radio name=display id=display2 value=B /></td>
		  <td width=91 align=center valign=top><input type=radio name=display id=display3 checked value=C /></td>
		  <td width=91 align=center valign=top><input type=radio name=display id=display4 value=D /></td>
		  <td width=91 align=center valign=top><input type=radio name=display id=display5 value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Status</td>
		  <td width=91 align=center valign=top><input type=radio name=status id=status value=A /></td>
		  <td width=91 align=center valign=top><input type=radio name=status id=status2 value=B /></td>
		  <td width=91 align=center valign=top><input type=radio name=status id=status3 checked value=C /></td>
		  <td width=91 align=center valign=top><input type=radio name=status id=status4 value=D /></td>
		  <td width=91 align=center valign=top><input type=radio name=status id=status5 value=N /></td>
		</tr>
		<tr>
		  <td width=100 align=left valign=top>Email</td>
		  <td width=91 align=center valign=top><input type=radio name=email id=email value=A /></td>
		  <td width=91 align=center valign=top><input type=radio name=email id=email2 value=B /></td>
		  <td width=91 align=center valign=top><input type=radio name=email id=email3 checked value=C /></td>
		  <td width=91 align=center valign=top><input type=radio name=email id=email4 value=D /></td>
		  <td width=91 align=center valign=top><input type=radio name=email id=email5 value=N /></td>
		</tr>
	  </table>
	  <center>
	  <br>
	  <font color=red>*</font>password :: <input name=password type=password id=password size=25>
	  <br>	  
	  <input type=submit name=submit2 id=submit2 value=Submit />
	  <input type=reset name=reset2 id=reset2 value=Reset />
	  </center>
	</form>";
?>
</div>
<?php
require 'dev.html';
?>