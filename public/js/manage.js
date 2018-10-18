/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(5);


/***/ }),

/***/ 5:
/***/ (function(module, exports) {

// Various JS required for the manage pages.
// =========================================
$(document).ready(function () {
	// Get model attached to this page - if it exists.
	var modelName = typeof $('body').attr('data-model-name') !== 'undefined' ? $('body').attr('data-model-name') : null;

	// Initalise Venobox for allowed models.
	var allowedModelsVenobox = ['page'];

	if (modelName && $.inArray(modelName, allowedModelsVenobox) >= 0) {
		initVenobox();
	}

	// Initialise sortable and set up update listener on allowed models.
	var allowedModelsSortable = ['page'];

	if (modelName && $.inArray(modelName, allowedModelsSortable) >= 0) {
		// Set the element to use and initialise.
		var $pageSortTable = $('#update-form tbody');
		initSortable($pageSortTable);
	}

	// Set up listener for pages that have "Load more" button.
	var allowedModelsLoadMore = ['page'];

	if (modelName && $.inArray(modelName, allowedModelsLoadMore) >= 0) {
		loadMoreListener();
	}

	// Set up listener for user first and last name fields, and auto-update the display name field on change.
	var allowedModelsNameFieldUpdater = ['user'];

	if (modelName && $.inArray(modelName, allowedModelsNameFieldUpdater) >= 0) {
		nameFieldListener();
	}
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
	$('#form-cancel').on('click', function (e) {
		$sortTable.sortable('cancel');
	});

	// Whenever an update is made, re-sort all on-page records based on element order.
	$sortTable.sortable({
		update: function update(event, ui) {
			// Build a list without zero value items - these are inactive records with no rank.
			var $rankFields = $('.rank_field').filter(function () {
				return $(this).attr('value') > 0;
			});

			$rankFields.each(function (index, value) {
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
	// New user form.
	$('#first_name, #last_name').on('change', function () {
		$displayName.val($firstName.val() + ' ' + $lastName.val());
	});

	// Update user form.
	$('.first_name_field, .last_name_field').on('change', function () {
		// Find the row this field sits on.
		$row = $(this).closest('tr.ui-sortable-handle');

		// Construct display name value based on which field is updated.
		var displayName = $(this).hasClass('first_name_field') ? $(this).val() + ' ' + $row.find('.last_name_field').val() : $row.find('.first_name_field').val() + ' ' + $(this).val();

		// Update display name field on this row.		
		$row.find('.name_field').val(displayName);
	});
}

function loadMoreListener() {
	$('.load-more').on('click', function (e) {
		// Prevent any default button stuff.
		e.preventDefault();

		// Set iteration value for visiblity toggling.
		var closestContainerValue = $(this).closest('.load-more-container').attr('data-load-more');
		var nextIteration = parseInt(closestContainerValue) + 1;

		// Unhide the correct tbody & button.
		$('tbody[data-iteration=' + nextIteration + ']').removeClass('d-none');
		$('tr[data-load-more=' + nextIteration + ']').removeClass('d-none');

		// Remove the button from the DOM, make the next button visible.
		$(this).remove();
	});
}

/***/ })

/******/ });