<?php 
$url = 'https://'.$_SERVER['SERVER_NAME'];
$date          = date('Y-m-d H:i:s');
$strtotime = strtotime($date);
if(isset($_GET["token_id"])){
    if($strtotime<=$_GET["token_id"]){
    }
    else{
        header("Location: ".$url."");
    }
}
else{
    header("Location: ".$url."");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.11.custom.css" />
<link rel="shortcut icon" href="https://seopromisers.com/images/favi.png" />
<link rel="stylesheet" media="screen" href="css/colorbox.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<meta name="robots" content="noindex" />

</head>

<noscript>
<style>
	.noscriptCase { display:none; }
	#accordion .pane { display:block;}
</style>
</noscript>