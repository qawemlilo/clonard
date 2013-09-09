<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

function createTable($orders)
{
    $i = 0;
    if(!is_array($orders)) return '<h2 style="color:red; margin-left:0px;">No orders have been made</h2><br /><br />';
	
    $table = '<div id="accordion">';
    
    foreach($orders as $order)
	{ 	    	    
	    $table .= '<h3><a href="#">Order #' . $order->id  . ' - ' . $order->parent['title'] . ' ' . $order->parent['name'] . ' ' . $order->parent['surname'] . '</a></h3>';
		
		$books_arr = explode(",", $order->books);
		//$feesObj = new Fees();
		//$fees = $feesObj->getTotal($order['grade'], $books_arr);
        
        $table .= '<div>';
        $table .= '<p><i class="icon-calendar"></i> ' .  $order->ts  . '</p>';
        
        $table .= '<div class="row-fluid"><div class="span6">';
        $table .= '<p><strong>CHILD\'S INFO</strong></p>';
        $table .= '<p>';
		if (!empty($order->grade)) {
		    $table .= '<strong>Grade:</strong> Grade ' . $order->grade . '<br>';
        }
	    else {
		    $table .= '<strong>Grade:</strong> Grade R<br>';
        }
			
		if (!empty($order->chidData['name'])) {
		    $table .= "<strong>Name:</strong> " . $order->chidData['name'] ." " . $order->chidData['surname'] . "<br>";
        }
			
		if (!empty($order->chidData['dob'])) {
		    $table .= "<strong>Date of Birth:</strong> " . $order->chidData['dob'] . "<br>";
        }
			
		if (!empty($order->chidData['gender'])) {
		    $table .= '<strong>Gender:</strong> ' . $order->chidData['gender'] . '<br>';
        }

		if (!empty($order->chidData['afrikaans'])) { 
		    $table .= "<strong>Afrikaans:</strong> " . $order->chidData['afrikaans'] . " language<br>";
        }
		else {
		    $table .= "<strong>Afrikaans:</strong> first language<br>";
        }

		if (!empty($order->chidData['maths'])) {
		    $table .= "<strong>Maths:</strong> " . $order->chidData['maths'] . "<br>";
        }
			
		if (!empty($order->chidData['choice'])) {
		    $table .= "<strong>Subject Choice:</strong> " . $order->chidData['choice'];
        }
		$table .= '</p>';
        
        $table .= '<p><strong>Books not required:</strong></p>';		
		if (!empty($order->books))
		{
		    		    
            $b_list = '<ul>';
			
			if (is_array($books_arr))
			{
                foreach ($books_arr as $book_v) 
				{
			        $b_list .= '<li>'.$book_v.'</li>';
                }
            }
            else{
                 $b_list .= '<li>'.$order->books.'</li>';
            }

            $b_list .= '</ul>';	
            $table .= $b_list;
            			
		} else {
		    $table .= '<p>All books required</p>';
		}
        $table .= '</div>';
        
        $table .= '<div class="span6">';
        $table .= '<p><strong>CONTACT DETAILS</strong></p>';
		
	    $table .= '<p><strong>Email Address:</strong> <a href="mailto: ' . $order->parent['email'] . '">'.$order->parent['email'] . '</a><br>';
		$table .= '<strong>Telephone:</strong> 0' . $order->parent['phone'] . '<br>';
		
		if (!empty($order->parent['fax'])) {
		    $table .= '<strong>Fax:</strong> 0' . $order->parent['fax'] . '<br>';
        }
			
		if (!empty($order->parent['cell'])) {
		    $table .= '<strong>Cell:</strong> 0' . $order->parent['cell'] . '<br>';
	    }
        
		if (!empty($order->parent['address'])) {
		    $table .= '<strong>Address:</strong> ' . $order->parent['address'] . ', ' . $order->parent['code'] . '<br>';
        }
			
		if (!empty($order->parent['postaladd'])) {
		    $table .= '<strong>Postal Address:</strong> ' . $order->parent['postaladd'] . ', ' . $order->parent['postalcode'] . '<br>';
        }
        
        $table .= '</p>';
            
        if (!empty($order->parent['comments'])) {
            $table .= '<p><strong>Special Instructions</strong></p>';
            $table .= '<blockquote><p>' . $order->parent['comments'] . '</strong></blockquote>';
        }
            
            
        $table .= '</div></div></div>';
	}
	
	$table .= '</div>';
	
    return $table;
}


class ClonardViewAdmin extends JView
{
	function display($tpl = null)
	{
		$currentUser =& JFactory::getUser();

		if ($currentUser->usertype == "Administrator") 
		{
		    $model = &$this->getModel();
			$orders = $model->getOrders();
            $pagination = $model->getPagination();

			$html = createTable($orders);
			
			$this->assignRef('orders', $html);
            $this->assignRef('pagination', $pagination);
			parent::display($tpl);
		}
		else
		{
		    header("Location: index.php");
			exit();
		}			
	}
}