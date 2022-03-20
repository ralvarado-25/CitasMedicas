<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" id="modalState-{{$role->id}}" data-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status @if($role->active==0) bg-info @else bg-red @endif"></div>
            {!! Form::open(['route'=>['roles.changestatus', code($role->id)], 'method'=>'GET', 'onsubmit'=>'btnState.disabled = true; return true;']) !!}
            <div class="modal-body text-center py-4">
                <svg class="icon @if($role->active==0) text-info @else text-red @endif icon-lg" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 6a7.75 7.75 0 1 0 10 0" />
                    <line x1="12" y1="4" x2="12" y2="12" />
                </svg>
                <h3>¿Está seguro?</h3>
                <div class="text-muted">
                    ¿Está seguro de cambiar a estado @if($role->active==0) ACTIVO @else INACTIVO @endif al rol <b>{{$role->name}}</b>?
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a class="btn @if(themeMode() == 'D') btn-secondary @endif w-100" data-dismiss="modal">
                                Cancelar
                            </a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn @if($role->active==0) btn-info @else btn-red @endif w-100" name="btnState">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
