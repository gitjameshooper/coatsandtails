<?php
  

  if($pay_type === 'paypal'){

    $email = $details['order_details']['email'];
        $rhds = "From: $SITE_NAME <$SALES_EMAIL>\nX-Mailer: PHP/".phpversion()
          . "\nReply-To: $SALES_EMAIL\nX-Priority: 3\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\n";

        $rmsgH = '<html><head><title>' . $SITE_NAME . '</title></head><body>
        <table width="100%" border="0" cellpadding=0 cellspacing=0 style="font-family:Arial; font-size: 16px;">
        <tr height="40">
          <td colspan=2 style="text-align:center;"><img src="http://s3.amazonaws.com/coatandtails/img/logo.png" alt="Coat and Tails"></td>
        </tr>
        <tr>
          <td>Hi <span style="text-transform: capitalize;">'.$first_name.'!</span> <br /><br />
        Thanks for the order! Just wanted to let you know that I received it, and that I\'ll be in touch soon with a status.<br /><br />
         <br /><br />
         Thanks again!<br /><br /><br />
         -- <br />
          Bryce Dishongh<br />
          Coat & Tails Pet Portraits<br /><br />
          For great deals and updates, be sure to follow us!<br /><br />
          <a style="float: left; display: inline-block; background: #3b5998; padding: 5px 10px; border-radius: 5px; color: #fff; text-decoration: none; text-align: center;" href="https://www.facebook.com/coatandtails">Facebook</a>
          <a style="float: left; margin-left:10px; display: inline-block; background: #4099ff; padding: 5px 10px; border-radius: 5px; color: #fff; text-decoration: none; text-align: center;" href="https://twitter.com/coatandtails">Twitter</a>
          <a style="float: left; margin-left:10px; display: inline-block; background: #3f729b
; padding: 5px 10px; border-radius: 5px; color: #fff; text-decoration: none; text-align: center;" href="https://instagram.com/coatandtails/">Instagram</a><br /><br />
         </td></tr>';
        $rmsgF = '</table></body ></html>';
 
        $rsubject = "Thanks! Your order number is " . $order_id;

        $rmsg=$rmsgH.$rmsgF;
         @mail($ADMIN_EMAIL, $rsubject, $rmsg, $rhds);
         @mail($email, $rsubject, $rmsg, $rhds);


  }else{
        $rhds = "From: $SITE_NAME <$SALES_EMAIL>\nX-Mailer: PHP/".phpversion()
          . "\nReply-To: $SALES_EMAIL\nX-Priority: 3\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\n";

        $rmsgH = '<html><head><title>' . $SITE_NAME . '</title></head><body>
        <table width="100%" border="0" cellpadding=0 cellspacing=0 style="font-family:Arial; font-size: 16px;">
        <tr height="40">
          <td colspan=2 style="text-align:center;"><img src="https://s3.amazonaws.com/coatandtails/img/logo.png" alt="Coat and Tails"></td>
        </tr>
        <tr>
          <td>Hi <span style="text-transform: capitalize;">'.$first_name.'!</span> <br /><br />
        Thanks for the order! Just wanted to let you know that I received it, and that I\'ll be in touch soon with a status.<br /><br />
         For now, below is your receipt and a description of your order.<br /><br />
         Thanks again!<br /><br /><br />
         -- <br />
          Bryce Dishongh<br />
          Coat & Tails Pet Portraits<br /><br />
          For great deals and updates, be sure to follow us!<br /><br />
          <a style="float: left; display: inline-block; background: #3b5998; padding: 5px 10px; border-radius: 5px; color: #fff; text-decoration: none; text-align: center;" href="https://www.facebook.com/coatandtails">Facebook</a>
          <a style="float: left; margin-left:10px; display: inline-block; background: #4099ff; padding: 5px 10px; border-radius: 5px; color: #fff; text-decoration: none; text-align: center;" href="https://twitter.com/coatandtails">Twitter</a>
          <a style="float: left; margin-left:10px; display: inline-block; background: #3f729b
; padding: 5px 10px; border-radius: 5px; color: #fff; text-decoration: none; text-align: center;" href="https://instagram.com/coatandtails/">Instagram</a><br /><br />
         </td></tr>';
        $rmsgF = '</table></body ></html>';


        $rmsg .= '<tr><td   style="background: #eee; padding: 10px; font-weight:bold;">Order Details</td></tr><br /><br />';
        $items_count = count($items);
        if($items_count > 0){
           
          $i = 0;
          for($i;$i<$items_count;$i++){
            $rmsg .= "<b>Product:</b> " . $items[$i]['itemName']
              . "<br /><b>Description:</b> " . $items[$i]['description']
              . "<br /><b>Amount:</b> " . $items[$i]['amount'];
            
            if(isset($items[$i]['size'])){
              $rmsg .= "<br /><b>Size:</b> " . $items[$i]['size'];
            }
            if(isset($items[$i]['clothe'])){
              $pets_query = $DB->query("SELECT * FROM order_pet LEFT JOIN clothes ON clothes.clothes_id=order_pet.order_pet_clothe_ref_id WHERE order_pet_session_id='$stored_session'");
              if(isset($pets_query[0])){
                $pets_count = count($pets_query);
                if($pets_count > 0){
                  $rmsg .= "<br /><br /><b>Pets:</b>";
                  $k = 0;
                  for($k;$k<$pets_count;$k++){
                    $rmsg .= "<br ><b>Pet #" . ($k + 1)
                      . "</b><br />Name:" . $pets_query[$k]['order_pet_name']
                      . "<br>Collection Name:" . $pets_query[$k]['clothes_title'];
                  }
                }
              }
            }
            if($items[$i]['type'] == 'merch'){
              $rmsg .= '<br /><br />View Item <a href="' . $BASE_URL . 'product.php?id=' . $items[$i]["id"] . '">Here</a>';
               
            }else if($items[$i]['type'] == 'frame'){
              $rmsg .= '<br /><br />View Item <a href="' . $BASE_URL . 'admin/frames_edit.php?id=' . $items[$i]["id"] . '">Here</a>';
            }
            $rmsg .='<br /><br /><hr /><br /><br />';
          }
        }

        $rmsg .= '<tr><td  style="background: #eee; padding: 10px; font-weight:bold;">Billing Summary</td></tr>
                <tr><td><br /><br />
                Subtotal: $'.$subtotal.'  <br />
                Discount: $'.$discount.'  <br />
                Shipping: $'.$shipping.'  <br />
                Tax: $'.$tax.'     <br />
                Method: '.$pay_type.'    <br /><br />

                Total: $'.$total.'       <br /><br /><br />

        </td></tr>';

        $rsubject = "Thanks! Your order number is " . $order_id;

        $rmsg=$rmsgH.$rmsg.$rmsgF;
         @mail($ADMIN_EMAIL, $rsubject, $rmsg, $rhds);
         @mail($email, $rsubject, $rmsg, $rhds);
    }
      
?>

