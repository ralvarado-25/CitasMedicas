@extends ('adminTemplate.layouts.admin', ['title_template' => "Dentalife"])
@section('extracss')

    <link href="{{asset('/plugins/tui.calendar/extra/tui-calendar.css')}}" rel="stylesheet"/>
    <link href="{{asset('/plugins/tui.calendar/css/icons.css')}}" rel="stylesheet"/>
@endsection
@section('contenidoHeader')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="page-pretitle">
                    Bienvenido
                </div>
                <h2 class="page-title">
                    {{ userFullName( auth()->user()->id )}}
                </h2>
            </div>
        </div>
    </div>
@endsection
@section('contenido')
    {{--  OPCIONES EXTRA CALENDARIO --}}
    @if (Gate::check('home.calendar'))
        <div class="row">
            <div id="actualizar">
                <div class="text-center">
                    <h1 class="text-primarydark">
                        Calendario de citas programadas
                    </h1>
                </div>
                <div class="mb-3">
                    {{-- NAVEGACION Y FILTROS --}}
                    <span id="menu-navi">
                        <button type="button" class="btn btn-darkcmms move-day text-center" data-action="move-prev">
                            <svg class="icon text-white" data-action="move-prev" width="44" height="44" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <polyline points="15 6 9 12 15 18" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-darkcmms move-day text-center" data-action="move-next">
                            <svg class="icon text-white" data-action="move-next" width="44" height="44" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <polyline points="9 6 15 12 9 18" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-darkcmms move-today font-weight-bold" data-action="move-today">HOY</button>

                    </span> &ensp;
                    <b id="renderRange" class="render-range  text-center" style="font-size:20px"></b>
                </div>

                <div class="table-responsive">
                    <div id="calendar" style="overflow-y: hidden;min-width:900px"></div>
                    <div id="contenedor_carga_calendar" style="display: none">
                        <div id="carga">
                            <b style="font-size: 1.8em">Cargando...</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Gate::check('home.indicators'))
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mbr-3">
                <div class="card">
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body ">
                        <div class="text-center mb-1">
                            <h1 class="text-primarydark">
                                Cantidad de citas segun especialidades
                            </h1>
                        </div>
                        <div id="infAsignados"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
<script src="{{asset('/plugins/tui.calendar/js/tui-code-snippet.min.js')}}"></script>
<script src="{{asset('/plugins/tui.calendar/js/chance.min.js')}}"></script>
<script src="{{asset('/plugins/tui.calendar/extra/tui-calendar.js')}}"></script>
<script src="{{asset('/plugins/tui.calendar/js/data/calendars.js')}}"></script>
<script src="{{asset('/plugins/tui.calendar/js/data/schedules.js')}}"></script>
<script src="{{asset('/plugins/tui.calendar/js/tui-calendar-functions.js')}}" ></script>
<script src="{{asset('/plugins/moment/moment.js')}}"></script>
<script src="{{asset('/plugins/moment/locale/es.js')}}"></script>
@if (Gate::check('home.calendar'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {

                // parametros de filtro
                var client = $('#selectClient').find(':selected').val();
                var user = $('#selectUser').find(':selected').val();
                var program = $('#selectProgram').find(':selected').val();
                var priority = $('#selectPrioridad').find(':selected').val();
                var type = $('#selectType').find(':selected').val();
                var area = $('#selectArea').find(':selected').val();
                var state = $('#selectStateOt').find(':selected').val();

                var filters = [client, user, program, priority, type, area, state];

                var themeDark = {
                    'common.border': '1px solid #666666',
                    'common.backgroundColor': '#1f1f1f',
                    'common.holiday.color': '#d63417',
                    'common.saturday.color': '#f4f6fa',
                    'common.dayname.color': '#f4f6fa',
                    'common.today.color': '#f4f6fa',
                    'month.holidayExceptThisMonth.color': 'rgba(214, 52, 23, 0.4)',
                    'month.dayExceptThisMonth.color': 'rgba(255, 255, 255, 0.4)',
                    'month.weekend.backgroundColor': 'inherit',
                    'month.day.fontSize': '14px',
                };

            var templates = {
                dayGridTitle: function(viewName) {
                    var title = '';
                    switch(viewName) {
                        case 'allday':
                            title = '<span class="tui-full-calendar-left-content">Todo el día</span>';
                        break;
                    }
                    return title;
                },
                popupDetailLocation: function(schedule) {
                    return '<b>Fecha programada:</b> ' + schedule.location;
                },
            };

            var calendarNew = new tui.Calendar('#calendar', {
                defaultView: 'month',
                taskView: false,
                disableClick: true,
                isReadOnly: true,
                scheduleView: ['allday'],
                disableDblClick: true,
                useDetailPopup: true,
                template: templates,
                month: {
                    daynames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    narrowWeekend: true,
                },
                week: {
                    daynames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                    showTimezoneCollapseButton: true,
                    timezonesCollapsed: false,
                },
            });

            calendarNew.setCalendarColor('1', {
                dragBgColor: '#656d77',
            });

            var start = moment(calendarNew.getDateRangeStart().getTime()).format('YYYY-MM-DD HH:mm Z');
            var end = moment(calendarNew.getDateRangeEnd().getTime()).format('YYYY-MM-DD HH:mm Z');
            var _token = $('input[name="_token"]').val();
            var route = "{{ route('calendario.citas') }}";
            $.ajax({
                url: route,
                method: "POST",
                data: { start: start, end: end, filters: filters, _token: _token},
                beforeSend: function(){
                    $("#contenedor_carga_calendar").show();
                },
                success: function (salida) {
                    calendarNew.createSchedules(salida);
                    $("#contenedor_carga_calendar").hide();
                }
            });

            setRenderRangeText(calendarNew);
            setEventListener(calendarNew, _token, route, filters);

        });
    </script>
@endif

<script src="{{asset('/plugins/highchart/highstock.js')}}"></script>
@if (Gate::check('home.indicators'))
    <script>
        $(window).resize(function(){
            graficasADibujarAlRedimensionar();
        })
        $(document).ready(function () {
            var hT = $(window).height() / 1.5;
            graficasADibujarAlRedimensionar();
        });
        function graficasADibujarAlRedimensionar() {
            Highcharts.chart('infAsignados', {
                colors: ['#3fbbc0','#e928a0','#ffee62','#532e1d'],
                chart: {
                    type: 'bar',
                    height: $(window).height() / 1.5,
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [{!!$espNombre!!}],
                    min: 0,

                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Cantidad'
                    },

                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },
                series: {!!$jsonData2!!}
            });
        }
    </script>
@endif

@endsection
