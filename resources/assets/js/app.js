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

  // Set up interaction with the sorted items.
  $sortTable.sortable({
    update: function(event, ui) {
      // Get the hidden field that contains rank value for moved element. 
      var movedRankField = ui.item.find('input.rank_field');

      // Get moved field's name so we can check for it later.
      var movedRankFieldName = movedRankField.attr('name');

      // Set the new value based on index - add 1 because ranks start at 1.
      movedRankField.val(ui.item.index() + 1);

      // Update rank for every item before the element.
      $('tr.ui-sortable-handle').each(function (key, element) {

        var originalElementValue = $(element).find('input.original_rank_field').val();
        var currentElementValue = $(element).find('input.rank_field').val();

        if (currentElementValue < movedRankField.val() && $(element).attr('name') != movedRankFieldName) {
          $(element).val(currentElementValue--);
        }

        else if (currentElementValue > movedRankField.val() && $(element).attr('name') != movedRankFieldName) {
          $(element).val(currentElementValue++);
        }

        console.log($(element).val());

      });

    }
  });
});