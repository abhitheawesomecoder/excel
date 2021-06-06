@extends('layouts.app')

@section('content')


    <div class="row">

        <div id="calendar-container" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	{!! $calendar->calendar() !!}
        </div>

    </div>
@endsection

@push('css-up')

   <link href="{{ asset('css/fullcalendar.print.css') }}" rel="stylesheet" media="print">
   <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">

@endpush

@push('scripts')

<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/locale-all.js') }}"></script>
{!! $calendar->script() !!}
<script>
jQuery(document).ready(function() {
	//$('.fc-B1-button').click( function() { alert('clicked'); });
	/*$('#calendar-jobCalendar').fullCalendar().setOption('visibleRange', {
  start: '2017-04-01',
  end: '2017-04-05'
});*/

	var textbox1 = document.createElement("INPUT");
	textbox1.setAttribute("id", "custom_date_from");
  	textbox1.setAttribute("type", "text");
  	textbox1.setAttribute("style", "width : 100px");
  	textbox1.setAttribute('placeholder',"date from");
  	$('.fc-B1-button').replaceWith(textbox1);
  	$('#custom_date_from').datetimepicker({
  				locale: window.APPLICATION_USER_LANGUAGE,
                calendarWeeks: true,
                showClear: true,
                showTodayButton: true,
                showClose: true,
                format: window.APPLICATION_USER_DATE_FORMAT
  	});

  	var textbox2 = document.createElement("INPUT");
  	textbox2.setAttribute("id", "custom_date_to");
  	textbox2.setAttribute("type", "text");
  	textbox2.setAttribute("style", "width : 100px");
  	textbox2.setAttribute('placeholder',"date to");
  	$('.fc-B2-button').replaceWith(textbox2);
  	$('#custom_date_to').datetimepicker({
  				locale: window.APPLICATION_USER_LANGUAGE,
                calendarWeeks: true,
                showClear: true,
                showTodayButton: true,
                showClose: true,
                format: window.APPLICATION_USER_DATE_FORMAT
  	});




  	$("#custom_date_from").on("dp.change", function (e) {
        $('#custom_date_to').data("DateTimePicker").minDate(e.date);
        //initialize start date
        
    });
    $("#custom_date_to").on("dp.change", function (e) {
        $('#custom_date_from').data("DateTimePicker").maxDate(e.date);
        //execute start end date
        
    });
});
</script>
@endpush