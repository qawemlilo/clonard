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
	    $table .= '<h3><a href="#">Order #' . $order['id'] . ' - ' . $order['parent']['title'] . ' ' . $order['parent']['name'] . ' ' . $order['parent']['surname'] . '</a></h3>';
		
		$books_arr = explode(",", $order['books']);
		//$feesObj = new Fees();
		//$fees = $feesObj->getTotal($order['grade'], $books_arr);
		
	    $table .= '<div><p><strong>Email Address:</strong> <a href="mailto: ' . $order['parent']['email'] . '">'.$order['parent']['email'] . '</a></p>';
		$table .= '<p><strong>Telephone:</strong> 0' . $order['parent']['phone'] . '</p>';
		
		if (!empty($order['parent']['fax'])) 
		    $table .= '<p><strong>Fax:</strong> 0' . $order['parent']['fax'] . '</p>';
			
		if (!empty($order['parent']['cell'])) 
		    $table .= '<p><strong>Cell:</strong> 0' . $order['parent']['cell'] . '</p>';
			
		if (!empty($order['parent']['address'])) 
		    $table .= '<p><strong>Postal Address:</strong> ' . $order['parent']['address'] . '</p>';
			
		if (!empty($order['parent']['code'])) 
		    $table .= '<p><strong>Postal Code:</strong> ' . $order['parent']['code'] . '</p>';
		
    	$table .= "<p><strong>Child's Info:</strong> ";
        $table .= '<ul>';
		
		if (!empty($order['grade'])) 
		    $table .= '<li>Grade: Grade ' . $order['grade'] . '</li>';
	    else
		    $table .= '<li>Grade: Grade R</li>';
			
		if (!empty($order['chidData']['name'])) 
		    $table .= "<li>Name: " . $order['chidData']['name'] ." " . $order['chidData']['surname'] . "</li>";
			
		if (!empty($order['chidData']['dob'])) 
		    $table .= "<li>Date of Birth: " . $order['chidData']['dob'] . "</li>";
			
		if (!empty($order['chidData']['gender'])) 
		    $table .= '<li>Gender: ' . $order['chidData']['gender'] . '</li>';

		if (!empty($order['chidData']['afrikaans'])) 
		    $table .= "<li>Afrikaans: " . $order['chidData']['afrikaans'] . " language</li>";
		else
		    $table .= "<li>Afrikaans: first language</li>";

		if (!empty($order['chidData']['maths'])) 
		    $table .= "<li>Maths: " . $order['chidData']['maths'] . "</li>";
			
		if (!empty($order['chidData']['choice'])) 
		    $table .= "<li>Subject Choice: " . $order['chidData']['choice'] . "</li>";
			
		$table .= '</ul></p>';
		
        $table .= '<p><strong>Books not required:</strong> ';		
		if (!empty($order['books']))
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
                 $b_list .= '<li>'.$order['books'].'</li>';
            }

            $b_list .= '</ul>';	
            $table .= $b_list;
            			
		} else {
		    $table .= 'All books required';
		}
		
		$table .= '</p>';
		$table .= '</div>';
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
            print_r($orders);
            exit();
			$html = createTable($orders);
			
			$this->assignRef('orders', $html);
			parent::display($tpl);
		}
		else
		{
		    header("Location: index.php?option=com_clonard&view=stepone");
			exit();
		}			
	}
}