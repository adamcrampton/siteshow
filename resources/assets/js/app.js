// Helper functions for the public front end.
$(document).ready(function() {
	// Initialize plugins.
  $('.venobox').venobox(); 

  // Sortable stuff for manage pages.
  var $sortTable = $('#update-form tbody');

  // Sortable options.
  $sortTable.sortable({
  	'items': '> tr'
  });

  // Reset rankings if form is reset.
	$('#form-cancel').on('click', function(e) {
		$sortTable.sortable('cancel');
	});

  $sortTable.sortable({
    update: function(event, ui) {





      
    //   // Get the hidden field that contains rank value for moved element. 
    //   var movedRankField = ui.item.find('input.rank_field');

    //   // Get moved field's name so we can check for it later.
    //   var movedRankFieldName = movedRankField.attr('name');

    //   $('tr.ui-sortable-handle').each(function (key, element) {
    //      // Set input rank field element.
    //     var thisRankField = $(this).find('input.rank_field');

    //     // Update rank for moved element.
    //     if (thisRankField.attr('name') == movedRankFieldName) {

    //       // Set the new value
    //       movedRankField.val(ui.item.index() + 1);

    //       console.log($(this).find('input.name_field').val(), thisRankField.val());

    //     } else {


    //       // Adjust ranks up and down.
    //       if (thisRankField.val() < movedRankField.val()) {
    //         $(thisRankField).val(function(i, oldVal) {
    //           return oldVal++;
    //         })

            

    //       } else if (thisRankField.val() > movedRankField.val()) {
    //          $(thisRankField).val(function(i, oldVal) {
    //           return oldVal--;
    //         })

             
    //       }

    //       console.log($(this).find('input.name_field').val(), thisRankField.val());
    //     }
        

    //   });
    // }
  });
});