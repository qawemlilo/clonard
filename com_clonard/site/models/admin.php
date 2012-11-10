<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class ClonardModelAdmin extends JModel
{
    public $orders;
    public $_total = null;
    public $_pagination = null;
    

    function __construct()
    {
        parent::__construct();
 
        $mainframe = JFactory::getApplication();
 
        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', 10, 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
        
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }
	
	function getOrders()
	{
	    if (!isset($this->orders)) 
		{
			$db =& JFactory::getDBO();
			
			$query = "SELECT *  FROM jos_clonard_orders ORDER BY ts DESC";
            
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
            
            
			//$db->setQuery($query);
			$allorders = $this->_data;
            
			if (is_array($allorders))
			{
			    $orders_arr = array();
				foreach($allorders as $order) {
			        $p_id = $order->parent;
                    $c_id = $order->child;					
					$p_data = $this->getParent($p_id);
					$c_data = $this->getStudent($c_id);
					
					if ($p_data)
				        $order->parent = $p_data;
						
					if ($c_data)
				        $order->chidData = $c_data;
						
					$orders_arr[] = $order;
			    }
				
				$this->orders = $orders_arr;
		     }
			 else {
			   $this->orders = false;
			 }
			 
			 return $this->orders;
		}
    }
	
	function getStudent($id)
	{
	    $db =& JFactory::getDBO();
		$query = "SELECT name, surname, dob, gender, choice, afrikaans, maths  FROM jos_clonard_students WHERE id='$id'";
        $db->setQuery($query);
		$data = $db->loadAssoc();

		return $data;
	}
	
	function getParent($id)
	{
	    $db =& JFactory::getDBO();
		$query = "SELECT title, name, surname, email, phone, cell, address, code  FROM jos_clonard_parents WHERE id='$id'";
        $db->setQuery($query);
		$data = $db->loadAssoc();

		return $data;
	}
    
    function getTotal()
    {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = "SELECT *  FROM jos_clonard_orders";
 	        $this->_total = $this->_getListCount($query);	
 	    }
        return $this->_total;
    }
    
    
    function getPagination()
    {
 	    $total = $this->getTotal();
 	    
        // Load the content if it doesn't already exist
 	    if (empty($this->_pagination)) {
 	        jimport('joomla.html.pagination');
 	        $this->_pagination = new JPagination($total, $this->getState('limitstart'), $this->getState('limit') );
        }
 	
        return $this->_pagination;
    }
}
