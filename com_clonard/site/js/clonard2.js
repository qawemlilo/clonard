jQuery.noConflict();
(function($) {
   $(function() { 
   
       var pitems = $("#contactForm .one, #contactForm .two, #contactForm .three, #contactForm .four"),
	       nextgrade = {'Grade n': 'Grade R', 'Grade R': 'Grade 1', 'Grade 1': 'Grade 2', 'Grade 2': 'Grade 3', 'Grade 3': 'Grade 4', 'Grade 4': 'Grade 5', 'Grade 5':'Grade 6', 'Grade 6': 'Grade 7', 'Grade 7': 'Grade 8', 'Grade 8': 'Grade 9'},
		   grades = [0, 2800, 4000, 4100, 4450, 5150, 5200, 5250, 5750, 6250, 6300], total, money = CART.total, repeat;
		   
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
	   
	    $("#grade").change(function () {
         
	        var $this = this, val = $($this).val(), currentgrade = $("#gradepassed").val(), gradeFormat;
            
            val = parseInt(val, 10);
            currentgrade = parseInt(currentgrade, 10);
			
            
            if (currentgrade) {
				if ((currentgrade - val) === 1) {
				    total = grades[val] + money;
				    $("#amount").html(total);
				    setTimeout(function(){change(val);}, 200);
                    
                    return true;
				}
			    
                if (val === currentgrade) {
                    gradeFormat = (val === 1) ? "R" : val;
				    repeat = confirm("You are about to re-order a Grade " + gradeFormat +" curriculum, is this correct?");
					
			        if (!repeat) {
					    $this.options[0].selected = true;
				        pitems.hide('slow');
					    
                        return false;
				    }
				    else {
				        total = grades[val] + money;
				        $("#amount").html(total);
				        setTimeout(function(){change(val);}, 200);

                        return true;                        
				    }
			    }
			
	            if ((currentgrade - val) !== 1) {
				    alert("You can only order 1 grade higher than current grade.");
			        $this.options[0].selected = true;
			        pitems.hide('slow');
		        }

				return false;
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
		if (val === 0 || val === 1 || val === 2 || val === 3) {
		    pitems.hide('slow');
			$("#contactForm .one").show('slow');
		}
				
		if (val === 4 || val === 5 || val === 6) {
			pitems.hide('slow');
		    $("#contactForm .two").show('slow');
		}
				
		if (val === 7) {
			pitems.hide('slow');
			$("#contactForm .three").show('slow');
		}
				
		if (val === 8 || val === 9) {
			pitems.hide('slow');
			$("#contactForm .four").show('slow');
		}
    }
	  
	$('.ui-datepicker-title select.ui-datepicker-year').attr('size', 10);
      
    $("#contactForm").submit(function () {
        var afr = $("#afrikaans"), answer;
        
        if (afr) {
            if (afr.val() === 'no') {
                answer = confirm('We cannot guarantee you entry in any school if they do not take Afrikaans as a 2nd language. Do want to continue without Afrikaans?');
                
                return answer;                
            }
        }   
    });
})(jQuery);