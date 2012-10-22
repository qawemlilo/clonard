<?php
require_once('inc.php');
/*
REQUIREMENTS:
PHP5 with the following libraries installed and enabled:
1. libcurl v7.9.0 or later. libcurl is an implementation
of CURL, which allows you to send XML over HTTPS using
server-to-server HTTP POST requests. Learn more about
libcurl at http://us2.php.net/curl/.
2. WDDX Functions. In order to use WDDX, you will need
to install the expat library (which comes with
Apache 1.3.7 or higher).
Learn more about WDDX at http://www.openwddx.org/
and http://www.php.net/manual/en/ref.wddx.php
3. SimpleXML
*/


/*
Before reading through this example, make sure that you have
read the MonsterPay Implementation Guide available from
http://www.monsterpay.com/www/downloads/MonsterPay_Implementation_Guide.p
df
This code is given as is and is intended to serve as an example.
The code demonstrates how to post back the tnxid, checksum and parity
values to the MonsterPay HTTP Synchro service.
It also shows how to prepare the information that is returned from
the Synchro service for displaying to the client (very basic).
*/
if (!function_exists('wddx_deserialize')) 
{
// Clone implementation of wddx_deserialize
    function wddx_deserialize($xmlpacket) {
	    if ($xmlpacket instanceof SimpleXMLElement) {
		    if (!empty($xmlpacket->struct)) {
			    $struct = array();
				foreach ($xmlpacket->xpath("struct/var") as $var) 
				{
				    if (!empty($var["name"])) 
					{
					    $key = (string) $var["name"];
						$struct[$key] = wddx_deserialize($var);
					}
				}
				
				return $struct;
			} 
			elseif (!empty($xmlpacket->array)) 
			{
			    $array = array();
				foreach ($xmlpacket->xpath("array/*") as $var) 
				{
				    array_push($array, wddx_deserialize($var));
				}
				return $array;
			} 
			else if (!empty($xmlpacket->string)) 
			{
			    return (string) $xmlpacket->string;
			} 
			else if (!empty($xmlpacket->number)) 
			{
			    return (int) $xmlpacket->number;
			} 
			else {
  			    if (is_numeric((string) $xmlpacket)) 
				{
				    return (int) $xmlpacket;
				} 
				else {
				    return (string) $xmlpacket;
				}
			}
		} 
		else {
		    $sxe = simplexml_load_string($xmlpacket);
			$datanode = $sxe->xpath("/wddxPacket[@version='1.0']/data");
			return wddx_deserialize($datanode[0]);
		}
	}
}


/*
Declare the variables that will hold the information that needs to be
sent to the HTTP Synchro Service.
The first three (tnxid, checksum and parity) are sent from MonsterPay via
URL encoding.
Replace the $merchID, $username and $password values with your own
details when you wish to implement this code. FOR TESTING LEAVE AS IS
*/

$tnxid = $_GET["tnxid"];
$checksum = $_GET["checksum"];
$parity = $_GET["parity"];
$errMsg = "";

if (empty($tnxid)) 
{
    $errMsg .= "tnxid not found<br>";
}
if (empty($checksum)) 
{
    $errMsg .= "checksum not found<br>";
}
if (empty($parity)) 
{
    $errMsg .= "parity not found<br>";
}
if ($errMsg != "") 
{
    die($errMsg);
}

// Web page receives Synchro Auto-Redirect variables from MonsterPay.
// The following details should be used for testing
// Must use your own account details when going live.

$merchID = MERCHID;
$username = USERNAME;
$password = PASSWORD;

/*
    Now we open a communication line to the HTTP Synchro Service.
*/
/*  Creates variable ($monsterpay_string) - Synchro Auto-Redirect
    variables + Identifier & Username & Password.
*/
$monsterpay_string = 'method=' . 'order_synchro' . '&identifier=' . $merchID . '&usrname=' . $username . '&pwd=' . $password . '&tnxid=' . $tnxid . '&checksum=' . $checksum . '&parity=' . $parity;

//send $monsterpay_string to MonsterPay by utilizing CURL
$monsterpay_url = "https://www.monsterpay.com/secure/components/synchro.cfc?wsdl";
// MonsterPay Synchro url

$ch = curl_init(); // initialize curl handle
curl_setopt($ch, CURLOPT_URL, $monsterpay_url); // set $setcom_url to post to MonsterPay
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
curl_setopt($ch, CURLOPT_POST, 1); // set POST method
curl_setopt($ch, CURLOPT_POSTFIELDS, $monsterpay_string); // set Post variable
$monsterpay_result = curl_exec($ch); // Perform the POST and get the data returnedby MonsterPay.
if (curl_errno($ch)) 
{
    $sCurlError = curl_error($ch); // If CURL returns an error, stores it in a variable.
    echo "error" . $sCurlError . "<br>";
} 
else 
  $sCurlError = '';
  
curl_close($ch);

if (empty($sCurlError)) {
/*
    Sample Code for MonsterPay Synchro Filter data returned from the MonsterPay Synchro Service. What we are after is the WDDX Packet so we filter the string to get just the wddx packet and then de-serialize it so that we are left with a string of xml data.
	See the MonsterPay Implementation Guide for the structure of the xml data.
    In displaying the details from the xml we make use of a user defined function to get the correct currency symbol. The GetCurrencySymbol function is very straight forward. It takes the currency code from the xml and returns the correct currency symbol. If it can't find the correct symbol it returns the given country code.
*/
$monsterpay_wddx = trim($monsterpay_result);
$monsterpay_xml = wddx_deserialize($monsterpay_wddx);
$order_synchro = simplexml_load_string($monsterpay_xml);

//tnx details
$tnx_status = $order_synchro->outcome->status;
$tnx_id = $order_synchro->outcome->order->id;
$funds_avail = $order_synchro->outcome->order->funds_available;

//error details
$error_code = $order_synchro->outcome->error_code;
$error_desc = $order_synchro->outcome->error_desc;
$error_solution = $order_synchro->outcome->error_solution;

//seller details
$seller_ref = $order_synchro->seller->reference;
$seller_email = $order_synchro->seller->username;

//buyer details
$buyer_ref = $order_synchro->buyer->reference;
$buyer_uname = $order_synchro->buyer->username;
$buyer_title = $order_synchro->buyer->billing_address->title;
$buyer_fname = $order_synchro->buyer->billing_address->firstname;
$buyer_lname = $order_synchro->buyer->billing_address->lastname;
$buyer_email = $order_synchro->buyer->billing_address->email_address;
$buyer_street1 = $order_synchro->buyer->billing_address->street1;
$buyer_street2 = $order_synchro->buyer->billing_address->street2;
$buyer_city = $order_synchro->buyer->billing_address->city;
$buyer_state = $order_synchro->buyer->billing_address->state;
$buyer_zip = $order_synchro->buyer->billing_address->zip;
$buyer_country = $order_synchro->buyer->billing_address->country;
$buyer_cnumber = $order_synchro->buyer->billing_address->contact_number;

//payment details
$pmt_type = $order_synchro->payment_instrument->type;

//Q's code below
$q_name = $buyer_title . " " . $buyer_title . " " . $buyer_fname . " " . $buyer_lname;


//financial details
$tnx_amount = $order_synchro->financial->amount_total;
$currency = $order_synchro->financial->currency;


//Reformat amount values
function getCurrency($amt, $cur) 
{
    if (strlen($cur) > 0) 
	{
	    switch (strtoupper($cur)) 
		{
		    case 'ZAR' : 
			    $cur_sym = 'R';
			break;
			
			case 'GBP' :
			    $cur_sym = '£';
			break;
			
			case 'USD' :
			    $cur_sym = '$';
			break;
			
			case 'EUR' :
			    $cur_sym = 'E';
			break;
			
			default:
			    $cur_sym = '';
		}
	} 
	else 
	    $cur_sym = '';
		
	if ($amt < 0) 
	{ 
	    $amt=abs($amt);
		$new_amt = '-' . $cur_sym . number_format(($amt / 100),2,'.','');
	} 
	else 
	    $new_amt = $cur_sym . number_format(($amt / 100),2,'.','');
		
    return $new_amt;
}

/*
    validation of transaction outcome in order to display the correct information to the buyer 
*/

if ($tnx_status != 'Complete') //transaction is unsuccessful
{
    //display error information returned by MonsterPay
    echo "<strong>Your order has been Declined.</strong><br><br>";
    echo "Sorry " . $buyer_title . " " . $buyer_fname . " " . $buyer_surname . " your payment to " . $seller_email . " was <strong>unsuccesful</strong>.<br><br>";
    echo "Why was my order declined?<br>";
    echo "Error Code: " . $error_code . "<br>";
    echo "Error Description: " . $error_desc . "<br>";
    echo "Error Solution: " . $error_solution . "<br>";
	
	send_decline_mail($q_name, $buyer_email, $username);
} //end tnx declined
else //transaction is successful
{
    //format tnx amount to include tnx currency
    $tnx_amount = getCurrency($tnx_amount,$currency);
	
    //output on screen for buyer
    echo "Your transaction is <strong>" . $tnx_status . "</strong><br><Br>";
	
    /*validate the transaction type in order to display the correct information to the buyer*/
    if ($pmt_type != "Credit Card") //non credit card funded payment
	{
	    /*loop through all the transaction notifications and display the details to the buyer*/
		foreach ($order_synchro->outcome->order->alerts->alert as $alerts)
		{
		    echo "Transaction Notification: <br><br><fieldset>" . $alerts->text . "<br></fieldset><br>";
		}
    }
	
    echo "<strong>Transaction ID</strong>: " . $tnx_id . "<br>";
    echo "<strong>Transaction Amount</strong>: " . $tnx_amount . "<br>";
	echo "<strong>Funds Available</strong>: " . $funds_avail . "<br>";
	echo "<strong>Reference</strong>: " . $seller_ref . "<br>";
	
	send_mail($q_name, $buyer_email, $username);
} //end tnx successful
} // END - [if (empty($sCurlError))]
?>