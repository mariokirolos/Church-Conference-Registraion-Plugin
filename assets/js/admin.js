jQuery(document).ready(function($){
	getPrices();

	//Set all the variables will be needed
	AdultPrice = 0 ;
	ChildPrice = 0;
	TotalDue = (!$('#paid').val()) ? 0  : parseInt($('#paid').val()) +  parseInt($('#remaining').val());
	TotalPaid = (!$('#paid').val()) ? 0  : $('#paid').val() ;
	TotalRemaining = (!$('#remaining').val()) ? 0  : $('#remaining').val() ;
	TotalAdults = (!$('#no_of_adults').val()) ? 0  : $('#no_of_adults').val() ;
	TotalChilds = (!$('#no_of_childs').val()) ? 0  : $('#no_of_childs').val() ;

    TotalPayableChilds = 0;         //Childs between 5 and 11
    TotalPayableYouth = 0;         //Number of youth who will pay in full.

console.log(TotalDue);
   $.ajaxSetup({cache:false});

   if($('#no_of_childs').val() > 0 ){$('[data-dependont="no_of_childs"]').show();}
   
   
   $(document).on('focus' , '.datepicker' , function(){
   	$(this).datepicker();
   })

   //Get the Conference data once clicked
    $(document).on('change' , '#conferenceschecklist' , function(){
    	 
    	$ConfID = $('input[name="tax_input[conferences][]"]:checked').val();


	    $roomValue = $('#roomtype').val();
	    $roomContainer = $('#room_type');


    	if($ConfID > 0 ){
	        $.ajax({
	            url: ajaxurl,
	            dataType: "json",
	            type: 'POST',
	            data: {
	                action:'TermInfo',
	                term: $ConfID
	            },
	            success: function(datareturn) {

	            	AdultPrice = parseInt(datareturn.adult_price);
	            	ChildPrice = parseInt(datareturn.child_price);
	            	RoomTypes = datareturn.available_room_types;

	            	CalculateTotalPrice();

	            	//Get Available Room Types
	            	$.each(RoomTypes , function(index , value){
	            			$selected = '';
	            		if(value == $roomValue){
	            			$selected = ' selected ';
	            		}

	            		$roomContainer.append('<option value="' + value + '" ' + $selected + ' >' + value + '</option>');
	            	});

	            },
	            failure: function(datareturn){
	                console.log('Error');
	            }
	        });



    	}
    	 
    });


    $(document).on('change' , '#no_of_childs' , function(){
    	if($(this).val() > 0){
			$('[data-dependont="no_of_childs"]').slideDown();
    	}else{
    		$('[data-dependont="no_of_childs"] input , [data-dependont="no_of_childs"] select').val('');
    		$('[data-dependont="no_of_childs"]').slideUp();
    	}

    	//Update the pricing
    });

    $(document).on('change' , '.payment_method' , function(){
    	$this = $(this);
    	if($(this).val() == 'Check'){
			$this.closest('tr').find('.checknumbers').show();
    	}else{
    		$this.closest('tr').find('.checknumbers').hide().val('');
    	}
    });
    

    $(document).on('click' , '#AddPaymentRow' , function(){
    	$('#paymentTableBody').append('<tr><td><select name="payment_method[]" class="payment_method"><option value="Check">Check</option><option value="Cash">Cash</option></select></td><td><input type="text" class="paid_amount" name="payment_amount[]" /></td><td><input type="text" name="check_numbers[]" class="checknumbers" value="" /></td><td><input type="text" class="datepicker" name="payment_date[]" /></td><td><button type="button" class="removeRowBTN">Remove</button></td></tr>');
    });

    $(document).on('click' , '.removeRowBTN' , function(){
    	$this = $(this);
    	if(window.confirm('Are you sure you want to delete this payment row, this can not be undone?')){
    		$(this).closest('tr').slideUp('fast' , function(){ $(this).remove(); });
    	}
    });


//Start Here
    $(document).on('keyup' , '.paid_amount' , function(){
		CalculateTotalPrice();
    });



    //Update the prices on change of number of adults
    $(document).on('change' , '#no_of_adults'  , function(){
    	TotalAdults = parseInt($('#no_of_adults').val());
    	CalculateTotalPrice();
    });

    //Update the prices on change of number of childs
    $(document).on('change' , '#age_between_5_and_11'  , function(){
        TotalPayableChilds = parseInt($('#age_between_5_and_11').val());
        CalculateTotalPrice();
    });



    $(document).on('change' , '#Young_youth'  , function(){
        TotalPayableYouth = parseInt($('#Young_youth').val());
        CalculateTotalPrice();
    });




    function CalculateTotalPrice(){
    	TotalAdultsPrice = parseInt(AdultPrice) * ( parseInt(TotalAdults) + parseInt(TotalPayableYouth) ) ;
    	TotalChildPrice =  parseInt(ChildPrice) * parseInt(TotalPayableChilds);

    	TotalDue = TotalAdultsPrice + TotalChildPrice;
		TotalPaid = 0;
		

		$('.paid_amount').each(function(){
			TotalPaid += parseInt($(this).val());
		});


		TotalRemaining = TotalDue - TotalPaid;

		$('#paid').val(TotalPaid);
    	$('#remaining').val(TotalRemaining);

    	return  TotalDue;
    }


    function getPrices(){
    	//Check if the hotel is selected, 
		$ConfID = $('input[name="tax_input[conferences][]"]:checked').val();
		
		//if yes set  prices
    	if($ConfID > 0 ){
	        $.ajax({
	            url: ajaxurl,
	            dataType: "json",
	            type: 'POST',
	            data: {
	                action:'TermInfo',
	                term: $ConfID
	            },
	            success: function(datareturn) {
	            	AdultPrice = parseInt(datareturn.adult_price);
	            	ChildPrice = parseInt(datareturn.child_price);
	            },
	            failure: function(datareturn){
	                console.log('Error');
	            }
	        });
    	}else{
    		//if no set prices to zeros
    		AdultPrice = 0;
	        ChildPrice = 0;
    	}
    	
    	
    }
});