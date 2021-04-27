// Docs URL: http://datatables.net/reference/event/processing

// This is your DataTable in the DOM.
$('#example')
  // Listen for the processing event.
  .on('processing.dt', function(e, settings, processing) {
    // The processing variable is a boolean.
    if (processing)
    	showCustomProcessingEffects();
    else
    	unShowCustomProcessingEffects();
  })
  // Don't forget to call this at the end.
  .dataTable();
