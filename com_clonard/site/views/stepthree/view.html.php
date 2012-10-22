<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class Library {
   public $one = array("Parents Guide Gr 1 - 7"=>30, "Read - Write & Spell 1 / CD"=>45, "Clonard Reading Book 1"=>20, "Clonard Reading Book 2"=>20, "10 Clonard Phonetic Readers"=>150, "8 Little Green Readers"=>20, "7 Big Green Readers"=>30, "8 Little Red Readers"=>20, "6 Big Red Readers"=>25, "Counters"=>15, "Bean Bag"=>10);
	
    public $two = array("Parents Guide Gr 1 - 7"=>30,"Read - Write and Spell Book 2/CD"=>50, "Clonard Reading Book 1"=>25, "Clonard Reading Book 2"=>25, "Clonard Reading Book 3"=>30, "10 Clonard Phonetic Readers"=>150, "4 Big Blue Readers"=>35, "1 Big Yellow Reader"=>20, "8 Little Blue Readers"=>20, "8 Little Yellow Readers"=>20, "Afrikaans Woordeskat"=>20, "Counters"=>15, "Bean Bag"=>10);
	
    public $three = array("Parents Guide Gr 1 - 7"=>30, "Read - Write and Spell Book 2 / CD"=>50, "10 Clonard Phonetic Readers"=>180, "1 Big Orange Reader"=>20, "8 Little Brown Readers"=>20, "8 Little Orange Readers"=>20, "Comprehensive English Practice"=>80, "Classroom Mathematics"=>45, "Classroom Mathematics 1 Answer Guide"=>15, "Modern Basic Mathematics"=>30, "Modern Basic Mathematics Answer Guide"=>15, "Afrikaans Woordeskat"=>20);
	
    public $four = array("Parents Guide Gr 1 - 7"=>30,"Comprehensive English Practice"=>70, "Afrikaans Supplementary Gr 4 - 7"=>15, "Nuwe Afrikaans Sonder Grense"=>60, "Antwoorde vir Nuwe Afrikaans Sonder Grense"=>15, "Classroom Mathematics 2"=>120, "Working through Classroom Mathematics"=>25, "Instamaths"=>40,"Shuters Natural Sciences"=>50, "Natural Sciences Work Schedule & Supplementary Notes"=>15, "Geography Manual"=>25, "Answer Guide to Geography Manual"=>15);
	
    public $five = array("Parents Guide Gr 1 - 7"=>30, "English Grammar Gr 4 - 9"=>35, "English Language Gr 4 - 9"=>35, "Comprehensive English Practice"=>8, "Afrikaans Taalleer Gr 4 - 9"=>35, "Afrikaans Woordeskat Gr 4 - 7"=>20, "Afrikaans Supplementary Gr 4 - 7"=>15, "Nuwe Afrikaans Sonder Grense"=>60, "Antwoorde vir Nuwe Afrikaans Sonder Grense"=>15, "Classroom Mathematics 4"=>40, "Working through Classroom Mathematics"=>30, "Instamaths"=>45, "Shuters Natural Sciences"=>50, "Natural Sciences Work Schedule & Supplementary Notes"=>25, "Geography Manual"=>25, "Answer Guide to Geography Manual"=>15, "Geography Map work"=>15);
	
    public $six = array("Parents Guide Gr 1 - 7"=>30, "English Grammar Gr 4 - 9"=>35, "English Language Gr 4 - 9"=>35,  "Comprehensive English Practice"=>90, "Afrikaans Taalleer Gr 4 - 9"=>35, "Afrikaans Woordeskat Gr 4 - 7"=>20, "Afrikaans Supplementary Gr 4 - 7"=>15, "Nuwe Afrikaans Sonder Grense"=>65, "Antwoorde vir Nuwe Afrikaans Sonder Grense"=>15, "Classroom Mathematics 4"=>50, "Working through Classroom Mathematics Part 1"=>25, "Working through Classroom Mathematics Part 2"=>25, "Instamaths"=>45, "Shuters Natural Sciences"=>50, "Natural Sciences Work Schedule & Supplementary Notes"=>25, "Geography Manual"=>25, "Answer Guide to Geography Manual"=>15);
	
    public $seven = array("Parents Guide Gr 1 - 7"=>30, "English Grammar Gr 4 - 9"=>35, "English Language Gr 4 - 9"=>35,  "English in Context"=>80, "The Runaways"=>80,"Afrikaans Taalleer Gr 4 - 9"=>35, "Afrikaans Woordeskat Gr 4 - 7"=>20, "Afrikaans Supplementary Gr 4 - 7"=>15, "Nuwe Afrikaans Sonder Grense"=>70, "Antwoorde vir Nuwe Afrikaans Sonder Grense"=>15, "Modern Basic Maths"=>50, "Working through Modern Basic Mathematics part 1"=>25, "Working through Modern Basic Mathematics part 2"=>25,  "Modern Basic Mathematics  Answers"=>15, "Instamaths"=>45, "General Science in Action 5"=>40, "Answer Guide to General Science in Action & Physical Science"=>15, "Answer Guide to General Science in Action & Biology"=>15, "Geography Manual"=>30, "Answer Guide to Geography Manual"=>15);
	
    public $eight = array("English Grammar Gr 4 - 9"=>35, "English Language Gr 4 - 9"=>35, "English in Context"=>90, "English in Context Answer Book"=>15, "English for the Secondary School"=>40, "The Runaways"=>80, "Afrikaans Taalleer 4 - 9"=>35, "Afrikaans Woordeskat Gr 8 - 9"=>20, "Afrikaans Supplementary Gr 8 - 9"=>15, "Nuwe Afrikaans Sonder Grense"=>100, "Antwoorde vir Nuwe Afrikaans Sonder Grense"=>15, "Letterkunde"=>15, "Spot-On Mathematics"=>80, "Spot-On Mathematics Answer Guide"=>20, "Instamaths"=>45, "Natural Sciences"=>25,  "Natural Sciences Teachers Handbook"=>20, "Economic & Mangement Sciences"=>45, "EMS Teachers Guide"=>25, "Physical Science"=>25, "Physical Science Supplementary Book"=>15, "Learning Station Social Sciences Learners Book"=>95, "History Teachers Guide"=>20, "Learning Station Social Sciences Learners Book"=>95, "Geography Supplementary Book for Learning Station Social Science"=>20, "Mapwork Made Easy Learners Guide"=>100, "Mapwork Made Easy Teachers Guide"=>100, "Agricultural Science in Action"=>30, "Accounting Textbook - A Logical Approach"=>30, "Accounting Key - A Logical Approach"=>30, "Home Economics Book"=>20, "Technology Workbook"=>15, "Social Science Assessment Workbook"=>15, "Touch Typing for Beginners"=>15);
	
    public $nine = array("English Grammar Gr 4 - 9"=>35, "English Language Gr 4 - 9"=>35, "English in Context"=>90, "English in Context Answer Book"=>20, "Working through Poetry"=>20, "Afrikaans Taalleer 4 - 9"=>35, "Afrikaans Woordeskat Gr 8 - 9"=>20, "Afrikaans Supplementary Gr 8 - 9"=>15, "Nuwe Afrikaans Sonder Grense"=>90, "Antwoorde vir Nuwe Afrikaans Sonder Grense"=>15, "Letterkunde"=>15, "Spot-On Mathematics"=>95, "Spot-On Mathematics Answer Guide"=>35, "Oxford Natural Sciences"=>75, "Oxford Successful Natural Sciences & Supplementary Book"=>20, "Economic & Mangement Sciences"=>45, "EMS Teachers Guide"=>25, "Physical Science"=>20, "Physical Science Supplementary Book"=>20, "Learning Station Social Sciences Learners Book"=>95, "History Teachers Guide"=>25, "Learning Station Social Sciences Learners Book"=>95, "Geography Supplementary Book for Learning Station Social Science"=>25, "Mapwork Made Easy Learners Guide"=>100, 
	"Mapwork Made Easy Teachers Guide"=>100, "Agricultural Science in Action"=>25, "Accounting Textbook - A Logical Approach"=>45, "Accounting Key - A Logical Approach"=>45, "Home Economics Book"=>20, "Technology Workbook"=>20, "Social Science Assessment Workbook"=>20, "Touch Typing for Beginners"=>15);

	public $grade;
	
    function __construct($item)
	{
	    $grades = array(
		    'Grade R' => 'zero', 
			'Grade 1'=> 'one', 
			'Grade 2'=> 'two', 
			'Grade 3'=> 'three', 
			'Grade 4'=>  'four', 
			'Grade 5'=> 'five', 
			'Grade 6'=> 'six', 
			'Grade 7'=> 'seven', 
			'Grade 8'=> 'eight', 
			'Grade 9'=> 'nine'
		);
		
	    $this->grade = $grades[$item]; 
	}
	
	
    function getCredit($selected)
	{
	    $credit = 0;
        $grade = $this->grade;		
        $books = $this->{$grade};
	    
		if(!empty($selected)) 
		{
	        foreach($selected as $title) 
		    {
			    $price = $books[$title];
				
			    $credit += $price; 
		    }
		}
		
        return $credit;		
	}
	
	
	function getBooks($selected)
	{
	    $selectedbooks = array();
        $grade = $this->grade;		
        $books = $this->{$grade};
		
		if(!empty($selected)) 
		{		
	        foreach($selected as $title) 
		    {
			    $selectedbooks[$title] = $books[$title];
			}
		}
		
		return $selectedbooks;
	}
	
	function booksCSV($selected)
	{
	    $books = '';

		if(!empty($selected)) 
		{		
	        $books = implode(",", $selected);
		}
		
		return $books;
	}
}


class ApplicationForm
{
    public $session;
	public $grade;
	public $csv;
	
    function __construct()
	{
	    $this->session = JFactory::getSession();
	}

    function processForm()
    {	
	    $grades = array(
		    'Grade R' => 0, 
			'Grade 1'=> 1, 
			'Grade 2'=> 2, 
			'Grade 3'=> 3, 
			'Grade 4'=> 4, 
			'Grade 5'=> 5, 
			'Grade 6'=> 6, 
			'Grade 7'=> 7, 
			'Grade 8'=> 8, 
			'Grade 9'=> 9
		);
		
		$unrequired_books = $_POST['books']; 
	
        $unique_id = $this->session->get('current');
		
		$cart = $this->session->get('cart');
        $grade = $cart[$unique_id]['grade'];
		$fees = $cart[$unique_id]['fees'];

		$this->grade = $grades[$grade];
		
        $library =& new Library($grade);
        $books = $library->getBooks($unrequired_books);	
        $credit = $library->getCredit($unrequired_books);	
		
		$this->csv = $library->booksCSV($unrequired_books);
		
	    $cart[$unique_id]['books'] = $books;
		$cart[$unique_id]['credit'] = $credit;

		$this->session->set('cart', $cart);
        $this->session->set('stepthree', 'complete');
        
		$this->getTotal();
		
		return true;
	}
	
    function getTotal()
	{
		$cart = $this->session->get('cart');
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
		
		$total = ($fees - $credit);
		$this->session->set('total', $total);
		
		return $total;
	}
}

class ClonardViewStepthree extends JView
{
	function display($tpl = null)
	{
	    $model = &$this->getModel();		
		$comms = false;
		$currentUser =& JFactory::getUser();
		$session =& JFactory::getSession();
        $step_completed = JRequest::getVar('step_completed', '', 'post', 'string');
		
		if ($session->has('comments'))
		    $comms = $session->get('comments'); 

		if ($currentUser->get('guest')) 
		{
		    header("Location: index.php?option=com_clonard&view=steptwo");
			exit();
		}		

		if (isset($_POST['import'])  && $step_completed == 'three')
		{
		    $form = new ApplicationForm();
			$success = $form->processForm();
			
			if ($success) 
			{
			    $grade = $form->grade;
				$books = $form->csv;
				$proceed = $model->createOrder($grade, $books, $comms);
				
			    if ($proceed)
				    header("Location: index.php?option=com_clonard&view=final");
			}
		}
		
	    else {
		    $form = new ApplicationForm();
		    parent::display($tpl);
		}
	}
}