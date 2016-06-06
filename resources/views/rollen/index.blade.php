{{-- ROLLENVERWALTUNG --}}

@extends('master')

@section('content')

<div class="row">
    <div class="col-xs-12 col-md-12 white-bgrnd">
        <div class="fixed-row">
            <div class="fixed-position ">
                <h1 class="page-title">
                    {{ trans('rollenForm.role-management') }}
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<fieldset class="form-group">
    <div class="box-wrapper">
        <h4 class="title">{{ trans('rollenForm.roles') }} {{ trans('rollenForm.add') }}</h4>
        <div class="box">
            <div class="row">
                <!-- input box-->
                    {!! Form::open(['route' => 'rollen.store']) !!}
                        <div class="col-xs-12"><div class="add-border-bottom"><strong>Rolle Anlegen</strong></div></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! ViewHelper::setInput('name', '', old('name'), trans('rollenForm.name'), trans('rollenForm.name'), true) !!} 
                            </div>
                        </div>
                        <div class="col-lg-4"> 
                            <div class="form-group">
                                <!--<label>{{ trans('rollenForm.rights') }}</label>-->
                                <select name="role[]" class="form-control select" data-placeholder="{{ trans('rollenForm.rights') }}" multiple>
                                    <option value="0"></option>
                                    <option value="required">Pflichtfeld</option>
                                    <option value="admin">Redaktion</option>
                                    <option value="mandant">Mandant</option>
                                    <option value="wiki">Wiki</option>
                                    <option value="phone">Telefonliste</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="col-xs-12"><div class="add-border-bottom"><strong>{{ trans('rollenForm.rights') }} {{ trans('rollenForm.copy') }}</strong><br></div></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <!--<label>{{ trans('rollenForm.documents') }}</label>-->
                                <select name="role_copy" class="form-control select" data-placeholder="{{ trans('rollenForm.documents') }}">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4"> 
                            <div class="form-group">
                                <!--<label>{{ trans('rollenForm.wiki') }}</label>-->
                                <select name="wiki_copy" class="form-control select" data-placeholder="{{ trans('rollenForm.wiki') }}">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="col-lg-3">     
                            <br><button class="btn btn-primary">{{ trans('rollenForm.add') }} </button>
                        </div>
                    {!! Form::close() !!}
            </div><!--End input box-->
        </div>  
    </div>
    
</fieldset>


<fieldset class="form-group">
    <div class="box-wrapper">
        <h4 class="title">{{ trans('rollenForm.roles') }} {{ trans('rollenForm.overview') }}</h4>
         <div class="box">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table">
                        <tr>
                            <th class="col-xs-12 col-md-5">
                               {{ trans('rollenForm.system') }} {{ trans('rollenForm.roles') }}
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                            @foreach($roles as $role)
                                @if($role->system_role)
                                {!! Form::open(['route' => ['rollen.update', $role->id], 'method'=>'PATCH']) !!}
                                   <tr>
                                        <td class="col-xs-12 col-md-5">
                                            <div class="form-group">
                                                <!--<label class="control-label">{{ trans('rollenForm.name') }} <i class="fa fa-asterisk text-info"></i></label>-->
                                                <input class="form-control" type="text" name="name" value="{{ $role->name }}" placeholder="{{ trans('rollenForm.name') }}*" required/>
                                            </div>
                                        </td>
                                        <td class="col-xs-12 col-md-2 vertical-center">
                                             <br> <p>{{ trans('rollenForm.editing') }}</p>
                                        </td> 
                                         <td class="col-xs-12 col-md-2 vertical-center">
                                            <div class="checkbox checkbox-inline pull-right">
                                                <input type="checkbox" name="wiki" id="wiki-{{ $role->id }}" @if($role->wiki_role) checked @endif>
                                                <label for="wiki-{{ $role->id }}">{{ trans('rollenForm.wiki') }}</label>
                                            </div>
                                        </td>
                                        <td class="col-xs-12 col-md-3 text-right table-options vertical-center">
                                            <button class="btn btn-primary ">{{ trans('rollenForm.save') }}</button>
                                        </td>
                                   
                                    </tr>
                                 {!! Form::close() !!}
                                @endif
                            @endforeach
                    </table>
                </div>
            </div>
    
             
            <div class="row">
                <div class="col-xs-12">
                    <table class="table">
                        <tr>
                            <th colspan="4">
                                {{ trans('rollenForm.user-defined') }} {{ trans('rollenForm.roles') }}
                            </th>
                        </tr>
                             @foreach($roles as $role)
                                @if(!$role->system_role)
                               
                                {!! Form::open(['route' => ['rollen.update', $role->id], 'method'=>'PATCH']) !!}
                                    <tr>
                                        <td class="col-xs-4">
                                            <div class="form-group">
                                                <!--<label class="control-label">{{ trans('rollenForm.name') }} <i class="fa fa-asterisk text-info"></i></label>-->
                                                <input class="form-control" type="text" name="name" value="{{ $role->name }}" placeholder="{{ trans('rollenForm.name') }}*" required/>
                                            </div>
                                        </td>
                                        <td class="col-xs-4">
                                            <!--<label>{{ trans('rollenForm.rights') }}</label>-->
                                            <select name="role[]" class="form-control select" data-placeholder="{{ trans('rollenForm.rights') }}" multiple>
                                                <option value="0"></option>
                                                <option value="required" @if($role->mandant_required) selected @endif > Pflichtfeld</option>
                                                <option value="admin" @if($role->admin_role) selected @endif > Redaktion</option>
                                                <option value="mandant" @if($role->mandant_role) selected @endif > Mandant</option>
                                                <option value="wiki" @if($role->wiki_role) selected @endif > Wiki</option>
                                                <option value="phone" @if($role->phone_role) selected @endif > Telefonliste</option>
                                            </select>
                                        </td>
                                        <td class="col-xs-12 col-md-2 text-center table-options vertical-center">
                                            @if($role->active)
                                            <button class="btn btn-success" type="submit" name="activate" value="1">{{ trans('rollenForm.active') }}</button>
                                            @else
                                            <button class="btn btn-danger" type="submit" name="activate" value="0">{{ trans('rollenForm.inactive') }}</button>
                                            @endif
                                            <button class="btn btn-primary">{{ trans('rollenForm.save') }}</button>
                                        </td>
                                        <td class="col-xs-12 col-md-2 text-center table-options vertical-center">
                                            <a href="javascript:void();" data-toggle="modal" data-target="#role-{{$role->id}}">{{ trans('rollenForm.active-users') }}: 0</a>
                                        </td>
                                    </tr>
                                {!! Form::close() !!}
                                
                                @endif
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</fieldset>

<div class="clearfix"></div> <br>

@foreach($roles as $role)
    @if(!$role->system_role)
    <div class="modal fade" id="role-{{$role->id}}" tabindex="-1" role="dialog" aria-labelledby="role-{{$role->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-close"></span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('rollenForm.active-users') }} - {{ trans('rollenForm.role') ." ". $role->name }}: 0</h4>
                </div>
                
                <div class="modal-body">
                    
                    <div class="row general">
                        <div class="col-xs-12">
                            
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">
                        {{ trans('rollenForm.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@stop
