
function dateRangePicker() {
	(function($) {
		var start = moment().subtract(364, 'days');
		var end = moment();

		function cb(start, end) {
			$('.date-range__input span').html(start.format('MMM D, YY') + ' - ' + end.format('MMM D, YY'));
			$('.dateRange').html(start.format('YYYY-MM-D') + ' - ' + end.format('YYYY-MM-D'));
			$('.dateRangeStart').val(start.format('YYYY-MM-D') + ' 00:00:00');
			$('.dateRangeEnd').val(end.format('YYYY-MM-D') + ' 23:59:59')
		}

		$('.date-range__input').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
				'All Time': [moment().subtract(50, 'years'), moment()],
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				'Last 1 Year': [moment().subtract(364, 'days'), moment()]
			}
		}, cb);

		cb(start, end);
	})( jQuery );
}

exports.dateRangePicker = dateRangePicker
