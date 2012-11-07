<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class AppSession {

    public $session;
	public $temp = array();
	
    function __construct()
	{
	    $this->session = JFactory::getSession();
			
		$this->session->clear('errors');
		$this->createCart();
	}	
	
    function set($item, $value) 
	{    
	    return $this->session->set($item, $value);
	}
	
    function get($item) 
	{    
	    $this->session->get($item);
	}

    function createRandomPassword($length = 6)
	{
         $conso=array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
         $vocal=array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
         $password="";
         srand ((double)microtime()*1000000);
         $max = $length/2;
         for($i=1; $i<=$max; $i++)
         {
            $password.=$conso[rand(0,19)];
            $password.=$vocal[rand(0,4)];
         }
         return $password;
    }	
	
    function createCart()
	{
	    $new = $this->session->get('new');
		
	    if ($new == 'yes') { 
		    $id = $this->createRandomPassword(8);
			
			$this->session->set('new','no');
			$this->session->set('current', $id);		
		} 
	}

    function calcFees($grade) 
	{
	    $fees = array(
		    'Grade R' =>2800, 
			'Grade 1'=>4000, 
			'Grade 2'=>4100, 
			'Grade 3'=>4450, 
			'Grade 4'=>5150, 
			'Grade 5'=>5200, 
			'Grade 6'=>5250, 
			'Grade 7'=>5750, 
			'Grade 8'=>6250, 
			'Grade 9'=>6300
		);
		
		if (array_key_exists($grade, $fees)) {	
			$this->temp['fees'] = $fees[$grade];
			
			return $fees[$grade];
		}
	}
	
	
    function addChildInfo(array $arr)
	{
		foreach($arr as $label=>$value) {
		    $this->temp[$label] = $value;
		}
		
		return $this->temp; 
	}
	
    function addFees($grade) 
	{
		$fees = $this->calcFees($grade);	
	}
}


class ApplicationForm
{
    public $childData;
	public $cart = array();
	
    function __construct()
	{
	    $this->AppSession = new AppSession();
	}
	
    function processForm() 
	{
       $child = array();
	   $children = array();
	   $errors = array();
	   
	   if ($this->AppSession->session->has('children'))
		   $children = $this->AppSession->session->get('children');
	   
	   $child['name'] = JRequest::getString('name', '', 'POST');
	   $child['surname'] = JRequest::getString('surname', '', 'POST');
	   $child['dob'] = JRequest::getString('dob', '', 'POST');
	   $child['gender'] = JRequest::getWord('gender', '', 'POST');
       $child['grade'] = JRequest::getString('grade', '', 'POST');	
       $child['gradepassed'] = JRequest::getString('gradepassed', '', 'POST');	
       $child['afrikaans'] = JRequest::getString('afrikaans', '', 'POST');
	   $child['maths'] = JRequest::getString('maths', '', 'POST');
	   $child['choice'] = JRequest::getString('choice', '', 'POST');
	   $child['parent'] = JRequest::getInt('id', '', 'GET');
	   
     
	   if(empty($child['name'])) 
	       $errors['name'] = 'Please fill in the name';
	   if(empty($child['surname'])) 
	       $errors['surname'] = 'Please fill in the surname';
	   if (empty($child['dob'])) 
	       $errors['dob'] = 'Please fill in the date of birth';
	   if (empty($child['gender'])) 
	       $errors['gender'] = 'Please fill in gender';
	   if (empty($child['gradepassed']))	   
	       $errors['gradepassed'] = 'Please fill in last grade passed';
	   if (empty($child['grade'])) {  
	       $errors['grade'] = 'Please fill in selected grade';
	   } else {
	       if($child['grade'] == 'Grade 4' || $child['grade'] == 'Grade 5' || $child['grade'] == 'Grade 6' || $child['grade'] == 'Grade 7' || $child['grade'] == 'Grade 8' || $child['grade'] == 'Grade 9') {
               if (empty($child['afrikaans']))
			       $errors['afrikaans'] = 'Please fill in Afrikaans field';
           }	

	       if($child['grade'] == 'Grade 8' || $child['grade'] == 'Grade 9') {
               if (empty($child['maths']))
			       $errors['maths'] = 'Please fill in maths field';
               if (empty($child['choice']))
			       $errors['choice'] = 'Please fill in optional subject';
           }		   
	   }

	   $id = $this->AppSession->session->get('current');
	   
	   $children[$id] = $child;
      
	   $this->AppSession->session->set('children', $children);

       if ($child['grade']) {
	      $this->AppSession->addFees($child['grade']);
        }

       if (count($errors) < 1) 
	   {
	       $this->childData = $child;
		   $cart = $this->AppSession->session->get('cart');
		   
	       $tempy = $this->AppSession->addChildInfo($child);

		   $cart[$id] = $tempy;
		   $this->cart = $cart; 
		   
		   $this->AppSession->session->set('steptwo', 'complete');
	       $this->AppSession->session->set('cart', $cart);
		   
		   $this->getTotal();
		   
           return true;	
	   }	   
	   
       else {
	       $this->AppSession->session->set('errors', $errors);
		   return false;	
	   }			
	} 

    function getTotal()
	{
		$cart = $this->cart;
		$fees = 0;
		$credit = 0;
		$total = 0;
		
		$shipping = !empty($cart['shipping']) ? $cart['shipping'] : 0;
		$total = $total + $shipping; 
		
		foreach($cart as $student) {
		    if (!empty($student['fees'])) {
  		        $fees += $student['fees']; 
			}
		    if (!empty($student['credit'])){
		       $credit += $student['credit'];
		    }
		}
		
		$total = ($fees - $credit) ;
		$this->AppSession->session->set('total', $total);
		
		return $total;
	}	
}


class ClonardViewSteptwo extends JView
{
	function display($tpl = null)
	{
	    $model = &$this->getModel();
        
        $form = new ApplicationForm();
        $cgrades = $model->getGrades(2013);
        
        $this->assignRef('cgrades', $cgrades);
		parent::display($tpl);
	}
}