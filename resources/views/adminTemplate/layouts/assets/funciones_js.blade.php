<script src="{{asset('/templates/tabler/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/templates/tabler/dist/libs/jquery/dist/jquery.slim.min.js')}}"></script>
<script src="{{asset('/templates/tabler/dist/js/tabler.min.js')}}"></script>
<script src="{{asset('/templates/tabler/dist/libs/introjs/intro.js')}}"></script>
<script src="{{asset('/templates/tabler/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/plugins/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/plugins/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/jquery.mark.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net-bs/js/datatables.mark.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@toastr_js
@toastr_render

    <script>
        window.onload = function () {
            var contenedor = document.getElementById('contenedor_carga');
            contenedor.style.visibility = 'hidden';
            contenedor.style.opacity = '0';
        }
    </script>
    <script>
        $(document).ready(function () {
            // Darle estilos a los select2 segun el template usado
            $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
            $(".select2-selection--single").addClass('form-selectcont');


            $("#startab").delay(1000).fadeIn();

            $('.datepicker').datepicker({
                autoclose: true,
                width: '100%',
                format: 'dd/mm/yyyy',
                ignoreReadonly: true,
                todayHighlight: true
            });

            // popover
            $(function () {
                $('[data-toggle="popover"]').popover({
                    html: true,
                    "trigger": "hover",
                    "placement": "top",
                    "container": "body"
                })
                $('[data-toggle="tooltip"]').tooltip({
                    html: true
                })
            });
        });

    </script>

    {{-- ===========================================================================================
                                                VALIDACION
    =========================================================================================== --}}
    <script>
        function ValidateAjax(idform,fields,buttonname,routeform,methodform,urlback){
            $("#"+idform+"").on('submit', function(e) {
                e.preventDefault();
                $("#"+idform+" .divWaitingMessage").slideDown();
                var registerForm = $("#"+idform+"");
                var formData = new FormData($("#"+idform+"")[0]);
                // var formData = registerForm.serialize();
                $.each(fields, function( indice, valor ) {
                    $("#"+valor+"-error").html( "" );
                    var inputtype = $("[name="+valor+"]").attr("type");
                    if(inputtype != 'radio')    $("[name="+valor+"]").removeClass('is-invalid').addClass('is-valid');
                    $("select[name="+valor+"]").removeClass('is-invalid-select').addClass('is-valid-select').removeClass('select2-selection');
                    $("#"+idform+" #"+valor+"-sel2 .select2-selection").removeClass('is-invalid-select').addClass('is-valid-select');
                    $("#"+idform+" #"+valor+"-sel2 .select2-selection").css('border','1px solid #5eba00');
                });
                $.ajax({
                    url: routeform,
                    type: methodform,
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data:formData,
                    contentType: false,
                    processData: false,

                    success:function(data) {
                        $("#"+idform+" .divWaitingMessage").hide();
                        if(data.alerta) {
                            toastr.error(data.mensaje);
                            $("[name="+buttonname+"]").attr('disabled',false)
                        }else if(data.success) {
                            if (urlback === undefined || urlback === null)    location.reload(true);
                            else window.location.href = urlback;
                            $("[name="+buttonname+"]").attr('disabled',true)
                        } else if(typeof(data.status) == "undefined"){
                            // window.location.href = '/login';
                        }

                    },
                    error: function(data){
                        $("#"+idform+" .divWaitingMessage").hide();
                        if(data.responseJSON.errors) {
                            var msjmail = ""; var sw_mail = 0;
                            $.each(data.responseJSON.errors, function( index, value ) {
                                $('#'+index+'-error' ).html( '&nbsp;<i class="fa fa-ban"></i> '+value );
                                $('#'+index+'').addClass('has-error');
                                var inputtype = $("[name="+index+"]").attr("type");
                                if(inputtype != 'radio')    $("[name="+index+"]").removeClass('is-valid').addClass('is-invalid');
                                $("select[name="+index+"]").removeClass('is-valid-select').addClass('is-invalid-select').removeClass('select2-selection');
                                $("#"+idform+" #"+index+"-sel2 .select2-selection").removeClass('is-valid-select').addClass('is-invalid-select');
                                $("#"+idform+" #"+index+"-sel2 .select2-selection").css('border','1px solid #cd201f');
                            });
                            var indexaux = []; var camposaux =[]; var i=0;
                            $.each(fields, function( indice, valor ) {
                                if(data.responseJSON.errors[valor]){
                                    indexaux[i] = indice;  i++;
                                }
                                var j = indice;
                                camposaux[j] = valor;
                            });
                            var menor = Math.min.apply(null, indexaux);
                            $('#'+camposaux[menor]+'--label')[0].scrollIntoView({behavior: 'smooth'});
                        }
                        setTimeout(function(){
                            $("[name="+buttonname+"]").attr('disabled',false);
                        }, 500)
                        if(typeof(data.status) != "undefined" && data.status != null && data.status == '401'){
                            // window.location.href = '/login';
                        }
                    }
                });
            });
        }
    </script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
        };
        @if(Session::has('messageCreate'))
            toastr.success("{{ Session::get('messageCreate') }}");
        @endif
        @if(Session::has('messageUpdate'))
            toastr.info("{{ Session::get('messageUpdate') }}");
        @endif
        @if(Session::has('messageDelete'))
            toastr.error("{{ Session::get('messageDelete') }}");
        @endif
        @if(Session::has('messageWarning'))
            toastr.warning("{{ Session::get('messageWarning') }}");
        @endif


        @if(count($errors)>0)
            @foreach($errors->all() as $er)
                toastr.error("{{$er}}");
            @endforeach
        @endif
    </script>
