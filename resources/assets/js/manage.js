// Various JS required for the manage pages.
// =========================================
$(document).ready(function() {
	// Initalise Venobox.
	initVenobox();

	// Initalise Sortable and set up update listener.
  	var $pageSortTable = $('#update-form tbody');
  	initSortable($pageSortTable);

  	// Set up listener for user first and last name fields, and auto-update the display name field on change.
  	nameFieldListener();
});

function initVenobox() {
	$('.venobox').venobox();	
}

function initSortable($sortTable) {
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
}

function nameFieldListener() {
	// Define fields for insert form.
	$firstName = $('#first_name');
	$lastName = $('#last_name');
	$displayName = $('#name');

	// Set up listener for any changes to first or last name, and rebuild the display name value.
	$('#first_name, #last_name').on('change', function() {
		$displayName.val($firstName.val() + ' ' + $lastName.val());
	});
}
