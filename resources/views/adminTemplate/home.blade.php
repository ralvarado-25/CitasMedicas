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
        {{-- <h1>Dashboard</h1> --}}
        {{--  OPCIONES EXTRA CALENDARIO --}}
        <div class="row">
            <div id="actualizar">

                <div class="mb-3">
                    {{-- TIPO DE VISTA DE CALENDARIO --}}
                    <span class="nav-item dropdown pull-right">
                        <button id="dropdownMenu-calendarType" class="btn btn-default btn-darkcmms btn-pill dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;filter: invert(100%) sepia(100%) saturate(14%) hue-rotate(212deg) brightness(104%) contrast(104%) !important;"></i>
                            <span id="calendarTypeName" class="font-weight-bold">Mes</span>&nbsp;
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropCalendar dropdown-menu-arrow border border-secondary" style="width:250px; left:-100 !important" role="menu" aria-labelledby="dropdownMenu-calendarType">
                            <a class="dropdown-item" role="menuitem" data-action="toggle-monthly">
                                <svg class="icon" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="5" cy="5" r="1" />
                                    <circle cx="12" cy="5" r="1" />
                                    <circle cx="19" cy="5" r="1" />
                                    <circle cx="5" cy="12" r="1" />
                                    <circle cx="12" cy="12" r="1" />
                                    <circle cx="19" cy="12" r="1" />
                                    <circle cx="5" cy="19" r="1" />
                                    <circle cx="12" cy="19" r="1" />
                                    <circle cx="19" cy="19" r="1" />
                                </svg> &nbsp;
                                Mes
                            </a>
                            <a class="dropdown-item" role="menuitem" data-action="toggle-weekly">
                                <svg class="icon" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="6" x2="9.5" y2="6" />
                                    <line x1="4" y1="10" x2="9.5" y2="10" />
                                    <line x1="4" y1="14" x2="9.5" y2="14" />
                                    <line x1="4" y1="18" x2="9.5" y2="18" />
                                    <line x1="14.5" y1="6" x2="20" y2="6" />
                                    <line x1="14.5" y1="10" x2="20" y2="10" />
                                    <line x1="14.5" y1="14" x2="20" y2="14" />
                                    <line x1="14.5" y1="18" x2="20" y2="18" />
                                </svg> &nbsp;
                                Semana
                            </a>
                            <a class="dropdown-item" role="menuitem" data-action="toggle-weeks2">
                                <svg class="icon" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="6" x2="9.5" y2="6" />
                                    <line x1="4" y1="10" x2="9.5" y2="10" />
                                    <line x1="4" y1="14" x2="9.5" y2="14" />
                                    <line x1="4" y1="18" x2="9.5" y2="18" />
                                    <line x1="14.5" y1="6" x2="20" y2="6" />
                                    <line x1="14.5" y1="10" x2="20" y2="10" />
                                    <line x1="14.5" y1="14" x2="20" y2="14" />
                                    <line x1="14.5" y1="18" x2="20" y2="18" />
                                </svg> &nbsp;2 semanas
                            </a>
                            <a class="dropdown-item" role="menuitem" data-action="toggle-weeks3">
                                <svg class="icon" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="4" y1="6" x2="9.5" y2="6" />
                                    <line x1="4" y1="10" x2="9.5" y2="10" />
                                    <line x1="4" y1="14" x2="9.5" y2="14" />
                                    <line x1="4" y1="18" x2="9.5" y2="18" />
                                    <line x1="14.5" y1="6" x2="20" y2="6" />
                                    <line x1="14.5" y1="10" x2="20" y2="10" />
                                    <line x1="14.5" y1="14" x2="20" y2="14" />
                                    <line x1="14.5" y1="18" x2="20" y2="18" />
                                </svg> &nbsp;3 semanas
                            </a>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" role="menuitem" data-action="toggle-workweek">
                                <input class="form-check-input" id="toggle-workweek" type="checkbox" checked> &ensp;Mostrar fines de semana
                            </a>
                            <a class="dropdown-item" role="menuitem" data-action="toggle-start-day-1">
                                <input class="form-check-input" id="toggle-start-day-1" type="checkbox"> &ensp;Iniciar semana en lunes
                            </a>
                            <a class="dropdown-item" role="menuitem" data-action="toggle-narrow-weekend">
                                <input class="form-check-input" id="toggle-narrow-weekend" type="checkbox" checked> &ensp;Fines de semana estrechos
                            </a>
                        </div>
                    </span>

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

@endsection
