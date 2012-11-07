jQuery.noConflict();
var CART;
(function($) {
    var Steptwo = {
    
        feilds: {
            gradepassed: 0,
            grade: 0,
            afrikaans: '',
            maths: '',
            choice: ''
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
            
            Steptwo.bindChanges('gradepassed');
            Steptwo.bindChanges('grade');
            Steptwo.handleFormSubmit();
        },
        
        bindChanges: function(view) {
            if (view === 'gradepassed') {
                $("#gradepassed").change(function() {
                    var grade = $(this).val();
                    
                    if (grade === 'R') grade = 0;
                    
                    Steptwo.feilds.gradepassed = Number(grade);
                    
                    if ((Steptwo.feilds.grade - Steptwo.feilds.gradepassed) !== 1) {
                        Steptwo.feilds.grade = 0;
                        
                        Steptwo.reset();                      
                    }
                });
            }
            
            if (view === 'grade') {
                $("#grade").change(function() {
                    var grade = $(this).val();
                    
                    if (grade === 'R') grade = 0;
                    
                    Steptwo.feilds.grade = Number(grade);
                    
                    if ((Steptwo.feilds.grade - Steptwo.feilds.gradepassed) === 1 && Steptwo.feilds.gradepassed !== 0) {
                        Steptwo.total = Steptwo.prices[Steptwo.feilds.grade] + CART.total;
                        $("#amount").html(Steptwo.total);
                        
                        Steptwo.changeView();
                    }
                    else {
                        if ((Steptwo.feilds.grade - Steptwo.feilds.gradepassed) === 0 && Steptwo.feilds.gradepassed !== -1 && Steptwo.feilds.gradepassed !== 0) {
                            var repeat = confirm("You are about to re-order a grade " + Steptwo.feilds.grade + " curriculum, is this correct?");
                            
                            if (repeat) {
                                Steptwo.total = Steptwo.prices[Steptwo.feilds.grade] + CART.total;
                                $("#amount").html(Steptwo.total);
                                
                                Steptwo.changeView();
                            }
                            else {
                                Steptwo.reset();
                            }
                        }
                        else {
                            alert("You can only order 1 grade higher than current grade.");
                            Steptwo.reset();
                        }
                    }
                });
            }
            
            if (view === 'afrikaans') {
                $("#afrikaans").change(function() {
                    Steptwo.feilds.afrikaans = $(this).val();
                });
            }
            
            if (view === 'maths') {
                $("#maths").change(function() {
                    Steptwo.feilds.maths = $(this).val();
                });
            }
            
            if (view === 'choice') {
                $("#subject").change(function() {
                    Steptwo.feilds.choice = $(this).val();
                });
            }
        },
        
        reset: function () {
            Steptwo.feilds.grade = 0;
            Steptwo.feilds.afrikaans = '';
            Steptwo.feilds.maths = '';
            Steptwo.feilds.choice = '';
            Steptwo.feilds.active = false;
            
            document.forms.steptwo.grade.options[0].selected = true; 
            document.forms.steptwo.afrikaans.options[0].selected = true; 
            document.forms.steptwo.choice.options[0].selected = true; 
            document.forms.steptwo.maths.options[0].selected = true; 
            
            $('#contactForm .allopts').hide('slow');
        },
        
        changeView: function () {
            switch (Steptwo.feilds.grade) {
                case 0:
                case 1:
                case 2:
                case 3:
                    $('#contactForm .allopts').hide('slow', function () {
                        $("#contactForm .one").show('slow');
                    });
                break;
                
                case 4:
                case 5:
                case 6:
                    Steptwo.bindChanges('afrikaans');

                    $('#contactForm .allopts').hide('slow', function () {
                        $("#contactForm .two").show('slow');
                    });
                break;
                
                
                case 7:
                    Steptwo.bindChanges('afrikaans');
                    Steptwo.bindChanges('maths');
                    Steptwo.bindChanges('choice');
                    
                    $('#contactForm .allopts').hide('slow', function () {
                        $("#contactForm .three").show('slow');
                    });
                break;
                
                
                case 8:
                case 9:
                    Steptwo.bindChanges('afrikaans');
                    Steptwo.bindChanges('maths');
                    Steptwo.bindChanges('choice');
                    
                    $('#contactForm .allopts').hide('slow', function () {
                        $("#contactForm .four").show('slow');
                    });
                break;
                
                default: 
                    $('#contactForm .allopts').hide('slow');                
            }
        },
        
        handleFormSubmit: function () {
            $("#contactForm").submit(function () {
                if (!Steptwo.feilds.afrikaans && Steptwo.feilds.grade > 4) {
                    return confirm('We cannot guarantee you entry in any school if they do not take Afrikaans as a 2nd language. Do want to continue without Afrikaans?');
                }   
            });        
        }
    };
    
    
    window.onload = function () {
        Steptwo.init();
    };
}(jQuery));