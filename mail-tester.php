 

 
<?php
 
 
 

 $SITE_NAME = 'Coat and Tails';
  $SALES_EMAIL = 'jimhooper86@gmail.com'; 
  $order_id = '123456';
  $first_name = 'jim';
  $last_name = 'hooper';
$pay_type = "credit card";
          $address_1 = "5717 china berry road";
          $address_2 = "address 2";
          $email = 'jimhooper86@gmail.com';
          $city = 'austin';
          $state = 'texas';
           $zip_code = '78744';
           $country = 'usa';
           $phone = '842-1082';
           $billing_same_as_shipping = 1;
           $pick_up = 0;
           $company = 'coat and tails';
           $order_id = '1245626';
          $total = '125.25';
        $comment = 'comment here';
        $subtotal = '4.50';
            $tax = '1.52';
            $shipping = '4.50';
         $discount = '3.25';
$items = array
  (
  array( 'id' => 5, 'price' => '$22.50', 'amount' => '2', 'total' => ' $520.00', 'type' => 'merch', 'itemName' => 'mrch', 'description'=>'this shirt', 'size'=> 'm'),
  array( 'id' => 7, 'price' => '$18.50', 'amount' => '3', 'total' => ' $500.00', 'type' => 'frame', 'itemName' => 'merch', 'description'=>'this shirt'),
  array( 'id' => 8, 'price' => '$22.20', 'amount' => '1', 'total' => ' $450.00', 'itemName' => 'merh', 'description'=>'this shirt', 'size'=> 's'),
  array( 'id' => 10, 'price' => '$12.50', 'amount' => '5', 'total' => ' $350.90', 'itemName' => 'merch', 'description'=>'this shirt')
  );

  $BASE_URL =   "www.coatandtails.com/";
        
  
        $rhds = "From: $SITE_NAME <$SALES_EMAIL>\nX-Mailer: PHP/".phpversion()
          . "\nReply-To: $SALES_EMAIL\nX-Priority: 3\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\n";

        $rmsgH = '<html><head><title>' . $SITE_NAME . '</title></head><body>
        <table width="100%" border="0" cellpadding=0 cellspacing=0 style="font-family:Arial; font-size: 16px;">
        <tr height="40">
          <td colspan=2 style="text-align:center;"><img src="https://s3.amazonaws.com/coatandtails/img/logo.png" alt="Coat and Tails"></td>
        </tr>
        <tr>
          <td>Hello <span style="text-transform: capitalize;">'.$first_name.'!</span> <br /><br />
        Thanks for the order! Just wanted to let you know that I recieved it, and that I\'ll be in touch soon with a status. Turnaround time for portraits is about a month.<br /><br />
         For now, below is your receipt and a description of your order.<br /><br />
         Thanks again! I look forward to working with you.<br /><br />
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

                Good information to know about your order:<br /><br />
                Shipment Date<br />
                If your order is queued for shipment after standard shipping times (6PM PT) or on a weekend, then it will
                not be picked up by the courier until the following business day. UPS and the US Postal Service all consider
                business days to be Monday through Friday, not including holidays or scheduled service interruptions.<br /><br />
                Multiple Packages<br />
                Many products are manufactured and shipped from different facilities. To ensure you get your products as 
                quickly as possible, your order will be shipped in multiple packages if needed.<br /><br />
                The Zazzle Promise<br />
                If you don\'t love it, we\'ll take it back. You can return purchases for a replacement or refund within 30 days
                of receipt. Some restrictions apply. Review our full return policy <a href="http://www.coatandtails.com/faq.php">here</a>.


        </td></tr>';

 

        $rsubject = "Thanks! Your order number is " . $order_id;

        $rmsg=$rmsgH.$rmsg.$rmsgF;
         // @mail($ADMIN_EMAIL, $rsubject, $rmsg, $rhds);
         @mail($email, $rsubject, $rmsg, $rhds);
       
        

?>

