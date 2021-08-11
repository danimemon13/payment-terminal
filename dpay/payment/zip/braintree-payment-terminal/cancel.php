<?php
/******************************************************************************
#                     PHP BrainTree Payment Terminal v1.0
#******************************************************************************
#      Author:     Convergine.com
#      Email:      info@convergine.com
#      Website:    http://www.convergine.com
#
#
#      Version:    1.0
#      Copyright:  (c) 2013 - Convergine.com
#      
#*******************************************************************************/
	
	//REQUIRE CONFIGURATION FILE
	require ("includes/config.php"); //important file. Don't forget to edit it!
    $subid = (!empty($_REQUEST["subid"]))?strip_tags(str_replace("'","`",$_REQUEST["subid"])):'';
    $iagree = (!empty($_REQUEST["iagree"]))?strip_tags(str_replace("'","`",$_REQUEST["iagree"])):'';
    $mess = "";
    $error=0;
    if(isset($_POST["process"]) && !empty($_POST["process"]) && $_POST["process"]=="yes"){
        if(!empty($iagree) && $iagree=="yes"){
        	
        	$result = Braintree_Subscription::cancel($subid);
			if($result->success){
				$arb_response = true;
			}else{
				$arb_response = false;
			}
			
            if ($arb_response)
            {

                if(!$arb_response){
					// se ocupa stripe de erori, nu am nevoie de asta
                    $my_status="<div>Cancellation Un-successful!<br/>";
                    $my_status .=$subid."<br />";
                    $error=0;
                    $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';

                } else {

                    $my_status="<br/><div>Subscription Cancelled!<br/>";
                    $my_status .="Subscripton ID ".$subid." is now cancelled.<br /><br />";
                    #$my_status .="Gateway Response:<br />";
                    $my_status .= "<a href='index.php'>Return to payment page</a></div><br/>";
                    $error=1;
                    $mess = '<div class="ui-widget"><div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';

                }

            }   else    {
                $my_status="<div>Cancellation Un-successful!<br/>";
                $my_status .="There was an error with your subscription cancellation.<br/>Please contact us directly to cancel your subscription<br/>";
                $error=0;
                $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
            }
        } else {
            $my_status="<div>Error!<br/>";
            $my_status .="You need to put a checkmark next to confirmation checkbox in order to proceed with cancellation.<br/>";
            $error=0;
            $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
        }
        
    }

    if(empty($subid)){
        $my_status="<div>Empty subscription ID!<br/>";
        $my_status .="There was an error with your subscription cancellation.<br/>You did not pass subscription ID to this page<br/>";
        $error=1;
        $mess = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">'.$my_status.'</div></div><br />';
    }

    //REQUIRE SITE HEADER TEMPLATE
	require "includes/site.header.php";
?>
<div align="center" class="wrapper">
    <div class="form_container">
    	<h1>BrainTree Payment Terminal</h1>
        <form id="ff1" name="ff1" method="post" action="" enctype="multipart/form-data"  class="pppt_form">
            <input type="hidden" value="yes" name="process" />
            <input type="hidden" value="<?php echo $subid?>" name="subid" />
            <?php echo $mess; ?>
            <div id="accordion">
                <!-- we're not showing form for this one -->
                <?php if((empty($mess) && !empty($subid)) || $error==0){?>
                <div class="pane">
                    <p>Subscription ID: <?php echo $subid?></p>
                    <input type="checkbox" name="iagree" value="yes"/> I understand that clicking submit will cancel above mentioned service
                    <div class="submit-btn"><input src="images/btn_submit.jpg" type="image" name="submit" /></div>
                </div>
                <?php } ?>
            </div>
        </form>
    </div>
</div>
<?php require "includes/site.footer.php"; ?>