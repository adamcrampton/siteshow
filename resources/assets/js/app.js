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

  // Whenever an update is made, re-sort all on-page records based on element order.
  $sortTable.sortable({
    update: function(event, ui) {
      // Build a list without zero value items - these are inactive records with no rank.
      var $rankFields = $('.rank_field').filter(function() {
          return $(this).attr('value') > 0;
      });

      $rankFields.each(function(index, value) {
        // Set the value to iteration order - which will be equal to the DOM order.
        // Add 1 because we want the list to start at 1.
        $(this).val(index + 1);
      });
    }
  });
});