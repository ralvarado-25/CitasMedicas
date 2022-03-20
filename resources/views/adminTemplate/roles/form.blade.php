<div class="col-md-12 invoice-col">
    <div class="box">
        <div class="box-header with-border">
            <center>
                <label style="font-size: 20px; font-weight: 600;">{!! $perm->description!!}</label>&nbsp;&nbsp;
                <small>
                    <button type="button" id="todo1{{$perm->id}}" data-pk="{{$perm->id}}" class="buttontodo badge badge-pill btn-sm bg-primary-lt" >
                        <b>MARCAR TODO</b>
                    </button>

                    <button type="button" id="todo1{{$perm->id}}" data-pk="{{$perm->id}}" class="buttontodoquitar badge badge-pill btn-sm" style="background-color:#edeeef; color:#1f1f1f; ">
                        QUITAR TODO
                    </button>
                </small>
            </center>
            {{-- ********************cambios******************* --}}
            <div class="box-tools pull-right">
                <a data-toggle="collapse" data-target="#padre1{{$perm->id}}">
                    <svg class="icon text-muted iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 15l-6 -6l-6 6h12" transform="rotate(180 12 12)" /></svg>
                </a>
            </div>
        </div>
        <div class="collapse show" id="padre1{{$perm->id}}" style="margin-top:20px" >
            <div class="row">
                @php $permiss = getPermisos($perm->id); @endphp
                @foreach ( $permiss as $permission)
                    <div class="col-lg-4 col-sm-6">
                        @if($permission->children->count())
                            {{-- check all nietos --}}
                            <span class="text-cmms-black font-weight-bold" style="font-size: 14px; margin-bottom: 5px;">{!! $permission->description ?: 'sin descripcion' !!} </span>
                            <small>
                                <button type="button" data-pk="{{$permission->id}}" class="buttontodoparent badge badge-pill btn-sm bg-primary-lt">
                                    <b>Marcar todo</b>
                                </button>

                                <button type="button" data-pk="{{$permission->id}}" class="buttontodoparentquitar badge badge-pill btn-sm" style="background-color:#edeeef; color:#1f1f1f; ">
                                    Quitar todo
                                </button>
                            </small>
                            <div class="card-body">
                                @foreach($permission->children as $permission)
                                    <div class="col">
                                        {{-- nietos --}}
                                        @if($permission->children()->count())
                                            <div class="box box-success with-border">
                                                <div class="box-header">
                                                    <em>{!! $permission->description ?: 'sin descripcion' !!}</em>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse" aria-expanded="false">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="box-body with-border">
                                                    @foreach($permission->children as $permission)
                                                    <label class="form-check form-switch">
                                                        @if (Gate::check('users.privilegiosupdate'))
                                                        {!! Form::checkbox('permissions[]', $permission->id,null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'']) !!}
                                                        @else
                                                        {{-- {!! Form::checkbox('permissions[]', $permission->id,null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'','disabled'=>true]) !!} --}}
                                                        {!! Form::checkbox('permissions[]', $permission->id,null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'']) !!}

                                                        @endif
                                                        <span class="small form-check-label cursor-pointer">{!! $permission->description ?: 'sin descripcion' !!}</span>
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <label class="form-check form-switch">
                                                @if (Gate::check('users.privilegiosupdate'))
                                                {!! Form::checkbox('permissions[]', $permission->id, null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'  checkparent'.$permission->parent_id]) !!}
                                                @else
                                                {{-- {!! Form::checkbox('permissions[]', $permission->id, null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'  checkparent'.$permission->parent_id,'disabled'=>true]) !!} --}}
                                                {!! Form::checkbox('permissions[]', $permission->id, null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'  checkparent'.$permission->parent_id]) !!}

                                                @endif
                                                <span class="small form-check-label cursor-pointer">{!! $permission->description ?: 'sin descripcion' !!} </span>
                                            </label>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <label class="form-check form-switch">
                                @if (Gate::check('users.privilegiosupdate'))
                                {!! Form::checkbox('permissions[]', $permission->id, null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'']) !!}
                                @else
                                {{-- {!! Form::checkbox('permissions[]', $permission->id, null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'','disabled'=>true]) !!} --}}
                                {!! Form::checkbox('permissions[]', $permission->id, null,['class' => 'form-check-input cursor-pointer checkb'.$perm->id.'']) !!}

                                @endif
                                <span class="small form-check-label cursor-pointer">{!! $permission->description ?: 'sin descripcion' !!}</span>
                            </label>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
