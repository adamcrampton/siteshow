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
});