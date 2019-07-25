@extends('layouts.app')

@section('content')
    <h3 class="page-title">Appointments</h3>
    @can('appointment_create')
        <p>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-success">Add New</a>
        </p>
    @endcan

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
    
    <section class="box">
        <div class="row">
            <div id='calendar'></div>
        </div>
    </section>
@stop

@section('javascript')
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
        minTime: "08:00:00",
        maxTime: "22:00:00",
        buttonText: {
          today: 'today',
          month: 'month',
          week : 'week',
          day  : 'day'
        },
        plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
        selectable: true,
        selectOverlap: false,
        select: function(start, end) {                    
            var cnf = confirm('Create appointment at ' + start.format("YYYY-MM-DD HH:mm:ss") + ' to ' + end.format("YYYY-MM-DD HH:mm:ss"));
            if(cnf == true) {
                date = date;
                start = start_time;
                end = finish_time;
                $.ajax({
                    url: 'admin.appointments.create',
                    type: 'POST',
                    data: {
                        date: date,
                        start: start_time,
                        end: finish_time,
                    },
                })
            }
            else
            {

            }
        },
            
        //Random default events
        events: [
                @foreach($working_hours as $hour)
                {
                    title : '{{ $hour->doctor->name }}',
                    start : '{{ $hour->date . ' ' . $hour->start_time }}',
                    end : '{{ $hour->date . ' ' . $hour->finish_time }}',
                },
                @endforeach
                @foreach($appointments as $appointment)
            {
                title : '{{ $appointment->patient->name }}',
                start : '{{ $appointment->start_time }}',
                @if ($appointment->finish_time)
                    end: '{{ $appointment->finish_time }}',
                @endif
                url : '{{ route('admin.appointments.edit_appt', $appointment->id) }}'
            },
            @endforeach
        ],
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
