<?php 



/*--------------------------------------------------+

|													 |

| Copyright � 2006 http://www.inoutscripts.com/      |

| All Rights Reserved.								 |

| Email: contact@inoutscripts.com                    |

|                                                    |

+---------------------------------------------------*/








include("config.inc.php");
if(!isset($_COOKIE['inout_admin']))
{
	header("Location:index.php");
	exit(0);
}
$inout_username=$_COOKIE['inout_admin'];
$inout_password=$_COOKIE['inout_pass'];
if(!(($inout_username==md5($username)) && ($inout_password==md5($password))))
{
	header("Location:index.php");
	exit(0);
}

?><?php include("admin.header.inc.php"); 
$id=$_GET['id'];
phpsafe($id);

?>
<script language="javascript">
			function test()
				{
				//alert("hai");
				//alert(document.getElementById("ad-type").value);
				t1=document.getElementById("ad-type").value;
				//alert(t1);
				if((t1=="Text")) 
					{
					//alert(document.getElementById('tab1').id.display);
					//window.document.form1.t1.display=none;
					document.getElementById('tab1').style.display="none";
					document.getElementById('t1').style.display="none";
					//document.getElementById('td1').style.display="";
					}
				else
					{
					document.getElementById('tab1').style.display="";
					document.getElementById('t1').style.display="";
					}
				}
			</script>
		 <script type="text/javascript" src="../farbtastic/jquery.js"></script>
 <script type="text/javascript" src="../farbtastic/farbtastic.js"></script>
 <link rel="stylesheet" href="../farbtastic/farbtastic.css" type="text/css" />
 <style type="text/css" media="screen">
   .colorwell {
     border: 2px solid #fff;
     width: 6em;
     text-align: center;
     cursor: pointer;
   }
   body .colorwell-selected {
     border: 2px solid #000;
     font-weight: bold;
   }
 </style>
 
 <script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    var f = $.farbtastic('#picker');
    var p = $('#picker').css('opacity', 0.25);
    var selected;
    $('.colorwell')
      .each(function () { f.linkTo(this); $(this).css('opacity', 0.75); })
      .focus(function() {
        if (selected) {
          $(selected).css('opacity', 0.75).removeClass('colorwell-selected');
        }
        f.linkTo(this);
        p.css('opacity', 1);
        $(selected = this).css('opacity', 1).addClass('colorwell-selected');
      });
  });
 </script>
<style type="text/css">
<!--
.style6 {font-size: 20px}
-->
</style>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" colspan="4"  align="left"><?php include "submenus/colors.php"; ?> </td>
  </tr>
  <tr>
   <td   colspan="4" scope="row" class="heading">Edit credit text/border color combination</td>
  </tr>
</table>
<br />

<form name="form1" action="ppc_update_credittext_bordercolor.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">


	<?php 
	 $result1=mysql_query("select * from ppc_credittext_bordercolor where id='$id'");
	 $row=mysql_fetch_row($result1);
	?>

      <table width="100%" >
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="726" rowspan="4"><div id="picker" style="float: left;"></div></td>
        </tr>
        <tr>
          <td width="280" height="80px"><strong>Credit text color</strong></td>
          <td width="10"><strong>:</strong></td>
          <td width="275"><div class="form-item"><input name="credit_text_color" type="text" ID="credit_text_color" class="colorwell"  style="background-color:<?php echo $row[1]; ?>" value="<?php echo $row[1]; ?>"  ></div></td>
        </tr>
        <tr>
          <td height="80px"><strong>Border color</strong></td>
          <td><strong>:</strong></td>
          <td><div class="form-item"><input name="border_text_color" type="text" ID="border_text_color" class="colorwell"  style="background-color:<?php echo $row[2]; ?>" value="<?php echo $row[2]; ?>"></div></td>
          </tr>
       

        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td >          <input name="Submit" type="submit" id="Submit" value="Update new color "></td>
          <td>&nbsp;</td>
          </tr> 
      </table>

</form>
<?php

 include("admin.footer.inc.php"); ?>
