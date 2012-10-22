jQuery.noConflict();
(function($) {
   $(function() { 
   
       var pitems = $("#contactForm .one, #contactForm .two, #contactForm .three, #contactForm .four"),
	       nextgrade = {'Grade n': 'Grade R', 'Grade R': 'Grade 1', 'Grade 1': 'Grade 2', 'Grade 2': 'Grade 3', 'Grade 3': 'Grade 4', 'Grade 4': 'Grade 5', 'Grade 5':'Grade 6', 'Grade 6': 'Grade 7', 'Grade 7': 'Grade 8', 'Grade 8': 'Grade 9'},
		   grades = {'Grade R': 2800, 'Grade 1': 4000, 'Grade 2': 4100, 'Grade 3': 4450, 'Grade 4': 5150, 'Grade 5': 5200, 'Grade 6': 5250, 'Grade 7': 5750, 'Grade 8': 6250, 'Grade 9': 6300 }, total, money = CART.total, repeat;
		   
       //Step two date of birth field
       $("#dob").datepicker({
           changeMonth: true,
	       changeYear: true,
		   dateFormat: 'dd-mm-yy',
		   defaultDate: new Date(1991,0,01),
		   yearRange: '1991:2011'
       });
	   
	   
	   //Step two reload selected grade field
	   if ($("#grade").val()) {
	       change($("#grade").val());
	   }
	   
	   $("#gradepassed").change(function() {
	        var gradeval = $("#grade").val();
			
	        if (gradeval) {
			   $("#gradepassed option:first").select();   
			}
			
            return true;
	   });	
	   
	   $("#grade").change(function() {
	        var $this = this, val = $($this).val(), currentgrade = $("#gradepassed").val();
			

	        if (!currentgrade) {
			   alert("Plase select Current Grade first");
			   $this.options[0].selected = true;
			   pitems.hide('slow');
			   return false;
			}
			
	        if (val) {
			
			    if (val !== nextgrade[currentgrade] && val !== currentgrade) {
				    alert("You can only order 1 grade higher than current grade.");
					$this.options[0].selected = true;
					pitems.hide('slow');
					return false;
				}
				
			    if (val === currentgrade) {
				    repeat = confirm("You are about to re-order a "+ val+" curriculum, is this correct?");
					
					if (!repeat) {
					    $this.options[0].selected = true;
						pitems.hide('slow');
						return false;
					}
					else {
				        total = grades[val] + money;
				        $("#amount").html(total);
				        setTimeout(function(){change(val);}, 200);					
					}
				}
				
				if (val === nextgrade[currentgrade]) {
				    $("#afrikaans, #subject, #maths").each(function(){
				        this.options[0].selected = true;
				    });
			    
				    total = grades[val] + money;
				    $("#amount").html(total);
				    setTimeout(function(){change(val);}, 200);
				}
				else
				    return false;
		    }
			else {
			  return false;
			}
	   });
	  
	   function change(val) {
				if (val === "Grade R" || val === "Grade 1" || val === "Grade 2" || val === "Grade 3") {
				    pitems.hide('slow');
				    $("#contactForm .one").show('slow');
				}
				
				if (val === "Grade 4" || val === "Grade 5" || val === "Grade 6") {
				    pitems.hide('slow');
				    $("#contactForm .two").show('slow');
				}
				
				if (val === "Grade 7") {
				    pitems.hide('slow');
				    $("#contactForm .three").show('slow');
				}
				
				if (val === "Grade 8" || val === "Grade 9") {
				    pitems.hide('slow');
				    $("#contactForm .four").show('slow');
				}
      }
	  
	  $('.ui-datepicker-title select.ui-datepicker-year').attr('size', 10);
    });
})(jQuery);