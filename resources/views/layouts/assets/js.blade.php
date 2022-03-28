<script src="{{asset('/components/medicio/assets/vendor/purecounter/purecounter.js')}}"></script>
<script src="{{asset('/components/medicio/assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('/components/medicio/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/components/medicio/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('/components/medicio/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('/components/medicio/assets/vendor/php-email-form/validate.js')}}"></script>

<script src="{{asset('/components/medicio/assets/js/main.js')}}"></script>
<script src="{{asset('/dist/js/jquery.min.js')}}"></script>
<script src="{{asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
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
                data:formData,
                contentType: false,
                processData: false,

                success:function(data) {
                    $(".sent-message").show();
                    $("[name="+buttonname+"]").hide();
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


    $('.datepicker').datepicker({
        autoclose: true,
        width: '100%',
        format: 'dd/mm/yyyy',
        ignoreReadonly: true,
        todayHighlight: true
    });

    $('.timepicker').timepicker({
        showInputs: false,
        minuteStep: 60,
        showMeridian: false,
        defaultTime: null
    });
</script>

<script>
    var campos = ['name','email','phone','date','hour','especialidad','message'];
    ValidateAjax("formCreateCitas",campos,"btnSubmit","{{route('citas.store.web')}}","POST","/citas");
</script>