@extends('layouts.app')

@section('content')
    <h3 class="page-title">Appointments</h3>
    @can('appointment_create')
        <p>
            <a href="{{ route('admin.appointments.create') }}"
               class="btn btn-success">Add New</a>
        </p>
    @endcan

    @if (session('alert'))
    	<div class="alert alert-success success-alert">
        	{{ session('alert') }}
    	</div>
	@endif
    
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <style>
        .fc-month-view span.fc-title{
              white-space: normal;
        }
    </style>
    
    <section class="box">
        <div class="row">
            <div id='calendar'></div>
        </div>

        <br/>

        <section class="box">
            <div class="box-header">
                <h3 class="box-title">Appointments List</h3>
            </div>

            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Patient Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Doctor Name</th>
                        <th>Start Time</th>
                        <th>Finish Time</th>
                        <th>Comments</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if (count($appointments) > 0)
                        @foreach ($appointments as $appointment)
                            <tr data-entry-id="{{ $appointment->id }}">
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->patient->name or '' }}</td>
                                <td>{{ isset($appointment->patient) ? $appointment->patient->phone : '' }}</td>
                                <td>{{ isset($appointment->patient) ? $appointment->patient->users->email : '' }}</td>
                                <td>{{ $appointment->doctor->name or '' }}</td>
                                <td>{{ $appointment->start_time }}</td>
                                <td>{{ $appointment->finish_time }}</td>
                                <td>{!! $appointment->comments !!}</td>
                                <td>
                                    @can('appointment_view')
                                        <a href="{{ route('admin.appointments.show',[$appointment->id]) }}"
                                        class="btn btn-xs btn-primary">View</a>
                                    @endcan
                                    @can('appointment_edit')
                                        <a href="{{ route('admin.appointments.edit',[$appointment->id]) }}"
                                        class="btn btn-xs btn-info">Edit</a>
                                    @endcan
                                    @can('appointment_delete')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".trans("Are you sure?")."');",
                                            'route' => ['admin.appointments.destroy', $appointment->id])) !!}
                                        {!! Form::submit(trans('Delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">No entries in table</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </section>
    </section>
@stop

@section('javascript')
    <script>
        $(document).ready(function() {
            $(".success-alert").fadeTo(2000, 500).slideUp(500, function() {
                $(".success-alert").slideUp(500);
            });        
        });
    </script>
    
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../bower_components/fastclick/lib/fastclick.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="../bower_components/moment/moment.js"></script>
    <script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script src="../../plugins/datatables/jquery.dataTables.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap4.js"></script>

    <script>
        $(function () {
          /* initialize the external events
           -----------------------------------------------------------------*/
          function init_events(ele) {
            ele.each(function () {
              // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
              // it doesn't need to have a start or end
              var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
              }
              // store the Event Object in the DOM element so we can get to it later
              $(this).data('eventObject', eventObject)
              // make the event draggable using jQuery UI
              $(this).draggable({
                zIndex        : 1070,
                revert        : true, // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
              })
            })
          }
          init_events($('#external-events div.external-event'))
          /* initialize the calendar
           -----------------------------------------------------------------*/
          //Date for the calendar events (dummy data)
          var date = new Date()
          var d    = date.getDate(),
              m    = date.getMonth(),
              y    = date.getFullYear()
          $('#calendar').fullCalendar({
            header    : {
              left  : 'prev,next today',
              center: 'title',
              right : 'month,agendaWeek,agendaDay'
            },
            windowResize: true,
            //defaultView: 'agendaDay',
            contentHeight: 'auto',
            minTime: "07:00:00",
            maxTime: "22:00:00",
            buttonText: {
              today: 'today',
              month: 'month',
              week : 'week',
              day  : 'day'
            },
            //plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
            //selectable: true,
            //selectOverlap: false,
            // select: function(start, end) {                    
            //     var cnf = confirm('Create appointment at ' + start.format("YYYY-MM-DD HH:mm:ss") + ' to ' + end.format("YYYY-MM-DD HH:mm:ss"));
            //     if(cnf == true) {
            //         date = date;
            //         start = start_time;
            //         end = finish_time;
            //         $.ajax({
            //             url: 'admin.appointments.create',
            //             type: 'POST',
            //             data: {
            //                 date: date,
            //                 start: start_time,
            //                 end: finish_time,
            //             },
            //         })
            //     }
            //     else
            //     {
            //     }
            // },
                
            //Random default events
            events    : [
                @foreach($appointments as $appointment)
                {
                    title : '{{ $appointment->patient->name }}',
                    start : '{{ $appointment->start_time }}',
                    description: 'Medical Checkup',
                    @if ($appointment->finish_time)
                            end: '{{ $appointment->finish_time }}',
                    @endif
                    url : '{{ route('admin.appointments.edit', $appointment->id) }}'
                },
                @endforeach
            ],
            eventRender: function(event, element) {
                element.find('.fc-title').append("<br/>" + event.description);
            },
            timeFormat: 'h(:mm)a',
            displayEventEnd: true,
            editable  : false,
            droppable : false, // this allows things to be dropped onto the calendar !!!
            drop      : function (date, allDay) { // this function is called when something is dropped
              // retrieve the dropped element's stored Event Object
              var originalEventObject = $(this).data('eventObject')
              // we need to copy it, so that multiple events don't have a reference to the same object
              var copiedEventObject = $.extend({}, originalEventObject)
              // assign it the date that was reported
              copiedEventObject.start           = date
              copiedEventObject.allDay          = allDay
              copiedEventObject.backgroundColor = $(this).css('background-color')
              copiedEventObject.borderColor     = $(this).css('border-color')
              // render the event on the calendar
              // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
              $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)
              // is the "remove after drop" checkbox checked?
              if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove()
              }
            }
          })
          /* ADDING EVENTS */
          var currColor = '#3c8dbc' //Red by default
          //Color chooser button
          var colorChooser = $('#color-chooser-btn')
          $('#color-chooser > li > a').click(function (e) {
            e.preventDefault()
            //Save color
            currColor = $(this).css('color')
            //Add color effect to button
            $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
          })
          $('#add-new-event').click(function (e) {
            e.preventDefault()
            //Get value and make sure it is not null
            var val = $('#new-event').val()
            if (val.length == 0) {
              return
            }
            //Create events
            var event = $('<div />')
            event.css({
              'background-color': currColor,
              'border-color'    : currColor,
              'color'           : '#fff'
            }).addClass('external-event')
            event.html(val)
            $('#external-events').prepend(event)
            //Add draggable funtionality
            init_events(event)
            //Remove event from text input
            $('#new-event').val('')
          })
        })
    </script>
@endsection