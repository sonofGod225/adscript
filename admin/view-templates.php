<?php 



/*--------------------------------------------------+

|													 |

| Copyright ? 2006 http://www.inoutscripts.com/      |

| All Rights Reserved.								 |

| Email: contact@inoutscripts.com                    |

|                                                    |

+---------------------------------------------------*/






 
include("config.inc.php");
include("../extended-config.inc.php");  
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

///////////////////////////wap 

//if(isset($_GET['wap']))
//{
//	$wap_flag=$_GET['wap'];
//}
//else
//{
//	$wap_flag='';
//}
//phpSafe($wap_flag);
//
//if($wap_flag==1)
//{
//$wap_flag_type=1;
//	$name='wap';
//	$wap_string=' wapstatus=1';
//	$image='wap.png';
//	
//}
//else if($wap_flag=='')
//{
//$wap_flag_type=2;
//	$name='';	
//	$wap_string=' (wapstatus=1 or wapstatus=0)' ;
//	//$wap_flag=2;
//}
//else
//{
//$wap_flag_type=0;
//   $wap_flag==0;
//   $name='';	
//   $wap_string=' wapstatus=0';
//   $image='pc.png';
//    
//   
//}
/////////////////////////wap

if($_REQUEST)
{
$adtype=$_REQUEST['size'];

$st=$_REQUEST['status'];

if($adtype!="")
{
$adty=" and banner_size=$adtype";
}
else
{
$adty="";
}
if($st=="1")
{
	$stat="and status ='1'";
}
elseif($st=="0")
{
	$stat="and status ='0'";	
}
else
{
	$stat="";
}



}
else
{
	$adty="";
	
	$stat="";
}

$blk=$adtype; 
$url=$_SERVER['REQUEST_URI'];
$pageno=1;
if(isset($_REQUEST['page']))
$pageno=getSafePositiveInteger('page');
$perpagesize = 20;
$sqladdstring="";
if(isset($_REQUEST['id']))
$sqladdstring="and id='$_REQUEST[id]'";

//echo "select id,banner_size ,name,status,filename from ppc_ad_templates where id <>-1 $sqladdstring   $adty $stat  order by createtime desc LIMIT ".(($pageno-1)*$perpagesize).", ".$perpagesize;  exit;
$result=mysql_query("select id,banner_size ,name,status,filename from ppc_ad_templates where id <>-1 $sqladdstring   $adty $stat  order by createtime desc LIMIT ".(($pageno-1)*$perpagesize).", ".$perpagesize); 
if(mysql_num_rows($result)==0 && $pageno>1)
	{
		$pageno--;
		$result=mysql_query("select id,banner_size ,name,status,filename from ppc_ad_templates where id <>-1 $sqladdstring   $adty $stat  order by createtime desc LIMIT ".(($pageno-1)*$perpagesize).", ".$perpagesize);

	}
$total=$mysql->echo_one("select count(*) from ppc_ad_templates where  id <>-1 $sqladdstring  $adty $stat");
?><?php include("admin.header.inc.php"); ?>
<script type="text/javascript">
	function promptuser()
		{
		var answer = confirm ("You are about to delete the ad template. Do you want to continue?")
		if (answer)
			return true;
		else
			return false;
		}
		
		function showad(id)
		{
			document.getElementById('ad'+id).style.display='block';
		}

		function hidead(id)
		{
			document.getElementById('ad'+id).style.display='none';
		}
		
		
</script>
<script  language="javascript" type="text/javascript" src="../swfobject.js"></script>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="53" colspan="4"  align="left"><?php include "submenus/ad-template.php"; ?></td>
  </tr>
  <tr>
   <td   colspan="4" scope="row" class="heading">Text Ad Templates</td>
  </tr>
</table>
  <form name="psads" action="view-templates.php" method="post">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="34" colspan="6"><span class="inserted">Text ad templates are listed below. You may block/activate/delete  ad templates. </span></td>
  </tr>
 


<tr height="30px"><td colspan="6" >
Status
    <select name="status" id="status" >
  <option value="1"  <?php 
			  				  if($st=="1")echo "selected";			  
			  ?>>Active</option>
      
  <option value="0" <?php 
			  				  if($st=="0")echo "selected";			  
			  ?>>Blocked</option>
  <option value="4" <?php 
			  				  if(($st!="1") && ($st!="0") )echo "selected";			  
			  ?>>All</option>
    </select>

Adblock
    <select name="size" id="select2">
        <option selected value="">- select -</option>
       

        <?php $result5=mysql_query("select id,width,height,ad_block_name,status from ppc_ad_block where ad_type=3 or ad_type=1 order by id ");
		
$ini_error_status=ini_get('error_reporting');
if($ini_error_status!=0)
{
	echo mysql_error();
}

	while($row5=mysql_fetch_row($result5))
	{
		$qw="<option value=\"$row5[0]\"";
		if($adtype==$row5[0])
		{
			$qw.="selected=selected";
		}
		
		$qw.=">( $row5[1] x $row5[2] ) $row5[3] </option>";	
		echo $qw;
		//echo "<option value=\"$row5[0]\"> ( $row5[1] x $row5[2] ) $row5[3] </option>";
	}
//$selectstring.="</select>";
  
?>
      </select>

       
<input type="submit" name="Submit" value="Submit"></td>
</tr>

</table>
<?php
if($total>0)
{
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">

<tr>
    <td colspan="2"><?php if($total>=1) {?>   Showing Templates<span class="inserted"><?php echo ($pageno-1)*$perpagesize+1; ?></span> -
        <span class="inserted">
        <?php if((($pageno)*$perpagesize)>$total) echo $total; else echo ($pageno)*$perpagesize; ?>
    </span>&nbsp;of <span class="inserted"><?php echo $total; ?></span>&nbsp;
    <?php } ?>    &nbsp;&nbsp;    </td>
    <td colspan="6" align="right" ><?php echo $paging->page($total,$perpagesize,"","view-templates.php?adtype=$adtype&status=$st"); ?></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0"  class="datatable">
<tr height="30" class="headrow">
<td width="27%" ><strong>Name</strong></td>
<td width="24%"><strong>Ad Block</strong></td>
<td width="11%"><strong>Status</strong></td>

<td width="22%" colspan="2"><strong>Action</strong></td>
</tr>


<?php

//echo "select title,link,summary,status,id,adtype from ppc_public_service_ads where id <> 0 $sqladdstring order by createtime desc";
$i=0;
while($row=mysql_fetch_row($result))
{
	if($row[8]==1)
	{
		$image='wap.png';
	}
	else
	{
		$image='pc.png';
	}
?>
<tr <?php if($i%2==1) { ?>class="specialrow" <?php } ?>>
<td>

<span onmouseover="showad(<?php echo $row[0]; ?>)" onmouseout="hidead(<?php echo $row[0]; ?>)"><?php echo $row[2]; ?> </span>
<div  id="ad<?php echo $row[0]; ?>" class="layerbox" >
<table   border="0" cellpadding="5" cellspacing="0"  >
		<td width="<?php echo $catalog_width; ?>" height="<?php echo $catalog_height; ?>" align="center" valign="top"><a href="<?php echo $row[1]; ?>"><img src="ad-templates/<?php echo $row[0]; ?>/<?php echo $row[4]; ?>" border="0" ></a></td>
	
		  </table>
</div>

</td>
<td style="white-space:nowrap">

<?php

$bname=mysql_query("select ad_block_name,width,height from ppc_ad_block where id=$row[1]");
$rowname=mysql_fetch_row($bname);
if($rowname!="")
{
echo $rowname[0]."(".$rowname[1]."x".$rowname[2].")";
}
  ?>
 
 

</td>
<td><?php 
if($row[3]=="0") { ?>Inactive<?php } else { ?> 
        Active
	  
<?php } ?></td>

<td colspan="2"><a href="ppc-delete-ad-template.php?id=<?php echo $row[0]; ?>&url=<?php echo urlencode($url) ?>" onclick="return promptuser()">Delete</a>&nbsp;|&nbsp;<?php if($row[3]==1) echo '<a href="ppc-change-ad-template-status.php?action=block&id='.$row[0].'&url='.urlencode($url).'">Block</a>';  else echo '<a href="ppc-change-ad-template-status.php?action=activate&id='.$row[0].'&url='.urlencode($url).'">Activate</a>';?> </td>
</tr>
<?php 
$i++;
 }
?>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">

<tr> 

 <td colspan="2"><?php if($total>=1) {?>   Showing Templates <span class="inserted"><?php echo ($pageno-1)*$perpagesize+1; ?></span> -
        <span class="inserted">
        <?php if((($pageno)*$perpagesize)>$total) echo $total; else echo ($pageno)*$perpagesize; ?>
    </span>&nbsp;of <span class="inserted"><?php echo $total; ?></span>&nbsp;
    <?php } ?>    &nbsp;&nbsp;    </td>
    <td colspan="4" align="right" ><?php echo $paging->page($total,$perpagesize,"","view-templates.php?adtype=$adtype&status=$st "); ?></td>
</tr>
</table>
<?php 
 }
else
{
		  echo " No records found. ";

}?> 
  </form><?php  
//include("admin.footer.inc.php"); ?>