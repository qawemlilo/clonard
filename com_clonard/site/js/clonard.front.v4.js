jQuery.noConflict();
var CART;
(function($) {
    "use strict";
    
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
                defaultDate: new Date("1991,0,01"),
                yearRange: '1991:2011'
            });
            
            if (Steptwo.views.grade.val()) {
                var num = Number(Steptwo.views.grade.val());
                
                Steptwo.changeGrade(num);
            }
            
            Steptwo.resetGradeOrdered();
            Steptwo.handleGradeChange();
            Steptwo.handleFormSubmit();
        },
        
        changeGrade: function (grade) {
            switch (grade) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $("#contactForm .two, #contactForm .three, #contactForm .four").hide('slow', function () {
                        $("#contactForm .one").show('slow');
                    });
                break;
                
                case 5:
                case 6:
                case 7:
                    $("#contactForm .one, #contactForm .three, #contactForm .four").hide('slow', function () {
                        $("#contactForm .two").show('slow');
                    });
                break;
                
                
                case 8:
                    $("#contactForm .one, #contactForm .two, #contactForm .four").hide('slow', function () {
                        $("#contactForm .three").show('slow');
                    });
                break;
                
                
                case 9:
                case 10:
                    $("#contactForm .one, #contactForm .two, #contactForm .three").hide('slow', function () {
                        $("#contactForm .four").show('slow');
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
                var $this = this, val = Number($($this).val()), gradepassed = Number($("#gradepassed").val()), diff = 0, repeat;
                 
	            if (!gradepassed) {
                    alert("Plase select Current Grade first");
                    $this.options[0].selected = true;
                    $("#contactForm .one, #contactForm .two, #contactForm .three, #contactForm .four").hide('slow');
                    
                    return false;
                }
			
	            if (val) {
                
                    diff = val - gradepassed;
                    
				    if (diff === 1) {			    
				        Steptwo.total = Steptwo.prices[val] + CART.total;
				        $("#amount").html(Steptwo.total);
				        Steptwo.changeGrade(val);
				    }
				
			        else if (diff === 0) {
				        repeat = confirm("You are about to re-order a grade " + val + " curriculum, is this correct?");
					
					    if (!repeat) {
					        $this.options[0].selected = true;
						   $("#contactForm .one, #contactForm .two, #contactForm .three, #contactForm .four").hide('slow');
                            
						    return false;
					    }
					    else {
				            Steptwo.total = Steptwo.prices[val] + CART.total;
				            $("#amount").html(Steptwo.total);
				            Steptwo.changeGrade(val);				
					    }
				    }
                    else {
                        alert("You can only order 1 grade higher than current grade.");
                        $this.options[0].selected = true;
                        $("#contactForm .one, #contactForm .two, #contactForm .three, #contactForm .four").hide('slow');
                        
                        return false;
                    }
		        }
			    else {
			        return false;
			    }
	        });        
        },
        
        handleFormSubmit: function () {
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
    
    
    window.onload = function () {
        Steptwo.init();
    };
}(jQuery));