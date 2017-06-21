$(document).ready(function () {
	
	// delete by id with ajax
	$('.deleteBtn').click(function (e)
	{
		// prevent page loading on link clicking
		e.preventDefault();
		// assign this button [link] to a varible and get its id
		var deleteBtn = $(this);
		// request url
		var item_url = deleteBtn.data('url');
		// item id to delete
		var item_id = deleteBtn.attr('id');
		// second id for item 
		if (typeof deleteBtn.data('id2') !== "undefined")
			item_id2 = deleteBtn.data('id2');

		// sent data 
		var item_column = deleteBtn.attr('data-column');
		// send second column if existed
		if (typeof deleteBtn.data('column2') !== "undefined")
			item_column2 = deleteBtn.data('column2');

		// data object to be sent with request
		var dataObj = {};
		dataObj[item_column] = item_id;
		// adding second column data to dataObjext if existed
		if (typeof item_id2 !== "undefined" && typeof item_column2 !== "undefined")
			dataObj[item_column2] = item_id2;

		// check if admin confirmed deleting
		if (confirm('Are you sure?'))
		{
			// ajax function
			$.ajax({
				url: item_url,
				type: 'POST',
				data: dataObj,
				dataType: 'json'
			})
			.done(function(data) {
				// remove data row from DOM
				deleteBtn.parent().parent().fadeOut('300', function() {
					$(this).remove();
				});
			})
		}
	});

});

