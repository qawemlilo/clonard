jQuery.noConflict();
(function($) {
    var Steptwo = {
        views: {
           all: $("#contactForm .one, #contactForm .two, #contactForm .three, #contactForm .four"),
           
           grade: $("#grade"),
           
           group_one: $("#contactForm .one"), 
           
           group_two: $("#contactForm .two"),
           
           group_three: $("#contactForm .three"),
           
           group_four:$("#contactForm .four")
        },
        
        prices: [3260,  4620, 4725, 5520, 6250, 6250, 6400, 6670, 7500, 7560],
        
        total: 0,
        
        init: function () {
            $('.ui-datepicker-title select.ui-datepicker-year').attr('size', 10);
            
            $("#dob").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy',
                defaultDate: new Date(1991,0,01),
                yearRange: '1991:2011'
            });
            
            if (Steptwo.views.grade.val()) {
                Steptwo.changeGrade(Steptwo.views.grade.val());
            }
            
            Steptwo.resetGradeOrdered();
            Steptwo.handleGradeChange();
            Steptwo.handleFormSubmit();
        },
        
        changeGrade: function (grade) {
            switch (grade) {
                case "R":
                case "1":
                case "2":
                case "3":
                    Steptwo.views.all.hide('slow');
                    Steptwo.views.group_one.show('slow');
                break;
                
                case "4":
                case "5":
                case "6":
                    Steptwo.views.all.hide('slow', function (){
                        Steptwo.views.group_two.show('slow');
                    });
                break;
                
                
                case "7":
                    Steptwo.views.all.hide('slow', function () {
                        Steptwo.views.group_three.show('slow');
                    });
                break;
                
                
                case "8":
                case "9":
                    Steptwo.views.all.hide('slow', function () {
                        Steptwo.views.group_four.show('slow');
                    });
                break;
                
                default: 
                    return false;                
            }
        },
        
        resetGradeOrdered: function () {
            $("#gradepassed").change(function() {
                $("#grade option:first").select();
            });
        },
        
        handleGradeChange: function () {
            $("#grade").change(function() {
                var $this = this, val = $($this).val(), gradepassed = $("#gradepassed").val(), diff;
			

	            if (!gradepassed) {
                    alert("Plase select Current Grade first");
                    $this.options[0].selected = true;
                    Steptwo.views.all.hide('slow');
                    
                    return false;
                }
			
	            if (val) {
                
                    diff = parseInt(val, 10) - parseInt(val, 10);
                    
                    if (diff > 1) {
				        alert("You can only order 1 grade higher than current grade.");
					    $this.options[0].selected = true;
					    Steptwo.views.all.hide('slow');
					    return false;
				    }
				
			        if (diff === 0) {
				        repeat = confirm("You are about to re-order a " + val + " curriculum, is this correct?");
					
					    if (!repeat) {
					        $this.options[0].selected = true;
						    Steptwo.views.all.hide('slow');
                            
						    return false;
					    }
					    else {
				            Steptwo.total = Steptwo.prices[val] + CART.total;
				            $("#amount").html(Steptwo.total);
				            setTimeout(function(){change(val);}, 200);					
					    }
				    }
				
				    if (diff === 1) {
				        $("#afrikaans, #subject, #maths").each(function () {
				            this.options[0].selected = true;
				        });
			    
				        Steptwo.total = Steptwo.prices[val] + CART.total;
				        $("#amount").html(Steptwo.total);
				        setTimeout(function(){change(val);}, 200);
				    }
				    else {
				        return false;
                    }
		        }
			    else {
			        return false;
			    }
	        });        
        },
        
        handleFormSubmit: () {
            $("#contactForm").submit(function () {
                var afr = $("#afrikaans"), answer;
        
                if (afr) {
                    if (afr.val() === 'no') {
                       answer = confirm('We cannot guarantee you entry in any school if they do not take Afrikaans as a 2nd language. Do want to continue without Afrikaans?');
                
                        return answer;                
                    }
                }   
            });        
        }
    };
    
    
    $(function() {
        Steptwo.init();
    })();
})(jQuery);