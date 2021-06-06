@extends('layouts.dashboard')

@section('content')

    <div class="block-header">
        <h2>@lang('core.dashboard.module')</h2>
    </div>

    <div class="row">
        @widget('App\Widgets\CountWidget',['title' =>
        trans('core.dashboard.widgets.upcomingjobs'),'bg_color'=>'bg-red','icon'=>'work_outline','counter' => $upcomingjobs->count()])
        @widget('App\Widgets\CountWidget',['title' =>
        trans('core.dashboard.widgets.completedjobs'),'bg_color'=>'bg-orange','icon'=>'work','counter' => $completedjobs->count()])
        @widget('App\Widgets\CountWidget',['title' =>
        trans('core.dashboard.widgets.upcomingtasks'),'bg_color'=>'bg-teal','icon'=>'add_task','counter' => $upcomingtasks->count()])
        @widget('App\Widgets\CountWidget',['title' =>
        trans('core.dashboard.widgets.completedtasks'),'bg_color'=>'bg-green','icon'=>'task_alt','counter' => $completedtasks->count()])
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form id="customfilter" class="pull-right" action="{{route('filter')}}" method="POST">@csrf
            <input type="hidden" name="filter" value="Custom">
            <input type="hidden" id="fromDate" name="fromDate" value="">
            <input type="hidden" id="toDate" name="toDate" value="">
            <input type="submit" value="Custom"></form>
         <input id="buttonTo" type="submit" value="">
         <input id="buttonFrom" type="submit" value="">
         <form class="pull-right" action="{{route('filter')}}" method="POST">@csrf
            <input type="submit" value="Month">
            <input type="hidden" name="filter" value="Month"></form> 
        <form class="pull-right" action="{{route('filter')}}" method="POST">@csrf
            <input type="hidden" name="filter" value="Week">
            <input type="submit" value="Week"></form> 
        <form class="pull-right" action="{{route('filter')}}" method="POST">@csrf
            <input type="hidden" name="filter" value="Day">
            <input type="submit" value="Day"></form>
        <form class="pull-right" action="{{route('filter')}}" method="POST">@csrf
            <input type="hidden" name="filter" value="All">
            <input type="submit" value="All"></form>

        </div>
    </div>
    <div class="row dashboard-row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">

                    <h2>@lang('core.dashboard.widgets.upcomingjobs')</h2>
                </div>
                <div class="body">
                    <div class="table-responsive col-lg-12 col-md-12 col-sm-12">
                    @include('core::datatable',['datatable' => $tableupcomingjobs])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>@lang('core.dashboard.widgets.completedjobs')</h2>
                </div>
                <div class="body">
                    <div class="table-responsive col-lg-12 col-md-12 col-sm-12">
                        @include('core::datatable',['datatable' => $tablecompletedjobs])
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row dashboard-row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>@lang('core.dashboard.widgets.upcomingtasks')</h2>
                </div>
                <div class="body">
                    <div class="table-responsive col-lg-12 col-md-12 col-sm-12">
                        @include('core::datatable',['datatable' => $tableupcomingtasks])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>@lang('core.dashboard.widgets.calendar')</h2>
                </div>
                <div class="body">
                    {!! $calendar->calendar() !!}
                </div>
            </div>
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
    textbox1.setAttribute("class", "pull-right");
    textbox1.setAttribute("type", "text");
    textbox1.setAttribute("style", "width : 100px");
    textbox1.setAttribute('placeholder',"Date from");
    $('#buttonFrom').replaceWith(textbox1);
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
    textbox2.setAttribute("class", "pull-right");
    textbox2.setAttribute("type", "text");
    textbox2.setAttribute("style", "width : 100px");
    textbox2.setAttribute('placeholder',"Date to");
    $('#buttonTo').replaceWith(textbox2);
    $('#custom_date_to').datetimepicker({
                locale: window.APPLICATION_USER_LANGUAGE,
                calendarWeeks: true,
                showClear: true,
                showTodayButton: true,
                showClose: true,
                format: window.APPLICATION_USER_DATE_FORMAT
    });
    $("#customfilter").submit(function(e){
        //e.preventDefault();
      if($('#custom_date_from').val() == ''||$('#custom_date_to').val() == ''){
        alert("Select date From and date To");
        return false;
      }
      $('#fromDate').val($('#custom_date_from').data('date'));
      $('#toDate').val($('#custom_date_to').data('date'));
      $(this).submit();

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
