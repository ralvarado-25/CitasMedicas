<!-- ======= SECCION REALIZAR CITA ======= -->
<section id="appointment" class="appointment section-bg">
    <div class="container" data-aos="fade-up">

    <div class="section-title">
        <h2>RESERVAR UNA CITA</h2>
    </div>

    {{-- <form action="forms/appointment.php" method="post" role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100"> --}}
    {!! Form::open( array('route' =>'citas.store.web','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCreateCitas','class'=>'php-email-form', 'onsubmit'=>'btnSubmit.disabled = true; return true;'))!!}
        <div class="row">
            <div class="col-md-4 form-group" id="name--label">
                <input type="text" name="name" class="form-control" id="name" placeholder="Nombre completo">
                <span class="text-red" id="name-error"></span>
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0" id="email--label">
                <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                <span class="text-red" id="email-error"></span>
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0" id="phone--label">
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Télefono">
                <span class="text-red" id="phone-error"></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group mt-3" id="date--label">
                <input type="datetime" name="date" class="form-control datepicker" id="date" placeholder="Fecha de cita">
                <span class="text-red" id="date-error"></span>
            </div>
            <div class="col-md-4 form-group mt-3 " id="hour--label">
                <input type="datetime" name="hour" class="form-control timepicker" placeholder="Hora de cita">
                <span class="text-red" id="hour-error"></span>
            </div>
            <div class="col-md-4 form-group mt-3" id="especialidad--label">
                <select name="especialidad" id="especialidad" class="form-select">
                    <option value="" hidden>Seleccionar especialidad</option>
                    @foreach ($especialidades as $esp)
                        <option value="{{$esp->id}}"> {{$esp->nombre}}</option>
                    @endforeach
                </select>
                <span class="text-red" id="especialidad-error"></span>
            </div>
        </div>



        <div class="form-group mt-3" id="name--label">
            <textarea class="form-control" name="message" rows="5" placeholder="Mensaje adicional (Opcional)"></textarea>
            <span class="text-red" id="message-error"></span>
        </div>
        <div class="my-3">
        <div class="sent-message" style="display: none">Su solicitud de cita ha sido enviada con éxito. ¡Gracias!</div>
        </div>
        <div class="text-center"><button type="submit" name="btnSubmit" id="botonCita">Confirmar cita</button></div>
    {{Form::Close()}}

    </div>
</section>

