{{-- BENUTZER EDIT --}}

@extends('master')

@section('page-title')
Benutzer bearbeiten
@stop

@section('content')

<fieldset class="form-group">
    
    {!! Form::open(['route' => ['benutzer.update', $user->id], 'method'=>'PATCH', 'enctype' => 'multipart/form-data']) !!}
    <div class="box-wrapper">
        <h4 class="title">{{ trans('benutzerForm.baseInfo') }}</h4>
        <div class="box">
            <div class="row">
        
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('username', $user, old('username'), trans('benutzerForm.username'), trans('benutzerForm.username'), true) !!}
                    </div>   
                </div>
                
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('password', '', '', trans('benutzerForm.password'), trans('benutzerForm.password'), false, 'password') !!}
                    </div>   
                </div>
                
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('password_repeat', '', '', trans('benutzerForm.password_repeat'), trans('benutzerForm.password_repeat'), false, 'password') !!}
                    </div>   
                </div>
                
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                        <div class="checkbox">
                      
                           {!! ViewHelper::setCheckbox('active',$user,old('active'),trans('benutzerForm.active') ) !!}
                          
                        </div>
                    </div>   
                </div>
                
            </div>
            
            <div class="row">
                
                <!-- input box-->
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                        <label class="control-label">{{trans('benutzerForm.title')}}</label>
                        <select name="title" class="form-control select" placeholder="{{trans('benutzerForm.title')}}">
                            <option value="Frau" @if($user->title == "Frau") selected @endif >Frau</option>
                            <option value="Herr" @if($user->title == "Herr") selected @endif >Herr</option>
                        </select>
                    </div>   
                </div><!--End input box-->
        
                <!-- input box-->
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('first_name', $user, old('first_name'), trans('benutzerForm.first_name'), trans('benutzerForm.first_name'), true) !!}
                    </div>   
                </div><!--End input box-->
        
                <!-- input box-->
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('last_name', $user, old('last_name'), trans('benutzerForm.last_name'), trans('benutzerForm.last_name'), true) !!}
                    </div>   
                </div><!--End input box-->
        
                <!-- input box-->
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('birthday', $user, old('birthday'), trans('benutzerForm.birthday'), trans('benutzerForm.birthday'), false, 'text', ['datetimepicker']) !!}
                    </div>   
                </div><!--End input box-->
                
                <div class="clearfix"></div>
                
                <!-- input box-->
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('short_name', $user, old('short_name'), trans('benutzerForm.short_name'), trans('benutzerForm.short_name'), false) !!}
                    </div>   
                </div><!--End input box-->
                
                <!-- input box-->
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('username_sso', $user, old('username_sso'), trans('benutzerForm.username_sso'), trans('benutzerForm.username_sso'), true) !!}
                    </div>   
                </div><!--End input box-->
                
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                        <!-- Telefon -->
                        {!! ViewHelper::setInput('phone', $user, old('phone'), trans('benutzerForm.phone'), trans('benutzerForm.phone'), false) !!}
                    </div>
                </div>
                
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                        <!-- Kurzwahl -->
                        {!! ViewHelper::setInput('phone_short', $user, old('phone_short'), trans('benutzerForm.phone_short'), trans('benutzerForm.phone_short'), false) !!}
                    </div>
                </div>
                
                <!-- input box-->
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                       {!! ViewHelper::setInput('email', $user, old('email'), trans('benutzerForm.email'), trans('benutzerForm.email'), true, 'email') !!}
                    </div>   
                </div><!--End input box-->
                
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                        <div class="checkbox">
                            {!! ViewHelper::setCheckbox('email_reciever',$user,old('email_reciever'),trans('benutzerForm.email_reciever') ) !!}
                         
                        </div>
                    </div>   
                </div>

                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                        {!! ViewHelper::setInput('active_from', $user, old('active_from'), trans('benutzerForm.active_from'), trans('benutzerForm.active_from'), false, 'text', ['datetimepicker']) !!}
                    </div>   
                </div>
                
                <div class="col-md-3 col-lg-3"> 
                    <div class="form-group">
                        {!! ViewHelper::setInput('active_to', $user, old('active_to'), trans('benutzerForm.active_to'), trans('benutzerForm.active_to'), false, 'text', ['datetimepicker']) !!}
                    </div>   
                </div>
                
            </div>
            
            <div class="row">
                <!-- input box-->
                <div class="col-md-2 col-lg-2"> 
                    <div class="form-group">
                        <label>{{ trans('benutzerForm.picture') }}</label>
                        <input type="file" id="image-upload" name="picture" /><br/>
                        
                        @if(isset($user->picture))
                            @if($user->picture)
                            <img id="image-preview" class="img-responsive" src="{{url('/files/pictures/users/'. $user->picture)}}"/>
                            @endif
                        @else
                            <img id="image-preview" class="img-responsive" src="{{url('/img/user-default.png')}}"/>
                        @endif
                    </div>   
                </div><!--End input box-->
        
            </div>
            
            <div class="clearfix"></div> <br>
            
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <button class="btn btn-primary no-margin-bottom" type="submit">{{ trans('benutzerForm.save') }}</button>
                </div>
            </div>
        </div><!--end box-->
    </div>
    {!! Form::close() !!}
    
    <div class="clearfix"></div> <br>
    
</fieldset> 



<fieldset class="form-group">
    
    {!! Form::open(['action' => 'UserController@userRoleTransfer', 'method'=>'POST']) !!}
    <div class="box-wrapper">
        <h4 class="title">{{ trans('benutzerForm.user') }} {{ trans('benutzerForm.roleTransfer') }}</h4>
        <div class="box">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                       {!! ViewHelper::setUserSelect($usersAll, 'user_transfer_id', '', old('user_transfer_id'), trans('benutzerForm.user'), trans('benutzerForm.user'), true) !!}
                    </div>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="col-md-3 col-lg-3">
                    <br><button class="btn btn-primary no-margin-bottom">{{ trans('benutzerForm.roleTransfer') }}</button>
                </div>
                
                <div class="clearfix"></div>
                
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    
</fieldset>
    
<fieldset class="form-group">
    
    {!! Form::open(['action' => 'UserController@userMandantRoleAdd', 'method'=>'POST']) !!}
    
    <!--<h4>{{ trans('benutzerForm.mandant') }}/{{ trans('benutzerForm.roles') }} {{ trans('benutzerForm.assignment') }}</h4>-->
    <div class="box-wrapper">
        <h4 class="title">{{ trans('benutzerForm.roles') }} {{ trans('benutzerForm.assignment') }}</h4>
         <div class="box">
            <div class="row inline">
                <div class="col-md-4">
                    <div class="form-group">
                       {{-- ViewHelper::setSelect($mandantsAll, 'mandant_id', '', old('mandant_id'), trans('benutzerForm.mandant'), trans('benutzerForm.mandant'), true, [], [], []) --}}
                        <label class="control-label">{{trans('benutzerForm.mandant')}}*</label>
                        <select name="mandant_id" class="form-control select" data-placeholder="{{ strtoupper(trans('benutzerForm.mandant')) }}" required>
                            <option></option>
                            @foreach($mandantsAll as $mandant)
                                <option value="{{$mandant->id}}">({{ $mandant->mandant_number }}) {{ $mandant->kurzname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                       {!! ViewHelper::setSelect($rolesAll, 'role_id[]', '', old('role_id'), trans('benutzerForm.role'), trans('benutzerForm.role'), true, [], [], ['multiple']) !!}
                    </div>
                </div>
                
                <div class="col-md-4 vertical-center">
                     <div class="form-group custom-input-group-btn">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <button class="btn btn-primary" type"submit">{{ ucfirst(trans('benutzerForm.add')) }}</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="clearfix"></div>
    
    @if(count($user->mandantUsers))
    
        <div class="box-wrapper">
            <h4 class="title">{{ trans('benutzerForm.roles') }} {{ trans('benutzerForm.overview') }}</h4>
             
             <div class="box">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <table class="table">
                            <tr>
                                <th class="col-xs-4 col-md-5">
                                    {{ trans('benutzerForm.mandants') }}
                                </th>
                                <th class="col-xs-4 col-md-5">
                                    {{ trans('benutzerForm.roles') }}
                                </th>    
                                <th class="col-xs-4 col-md-2">{{ trans('benutzerForm.options') }}</th>    
                            </tr>
                            @foreach($user->mandantUsersDistinct as $mandantUser)
                                @if($mandantUser->deleted_at == null)
                                {!! Form::open(['action' => 'UserController@userMandantRoleEdit', 'method'=>'PATCH']) !!}
                                    <tr id="mandant-role-{{$mandantUser->id}}">
                                        <td>
                                            ({{ $mandantUser->mandant->mandant_number }}) {{ $mandantUser->mandant->kurzname }}
                                            <input type="hidden" name="mandant_user_id" value="{{$mandantUser->id}}">
                                            <input type="hidden" name="user_id" value="{{$mandantUser->user_id}}">
                                            <input type="hidden" name="mandant_id" value="{{$mandantUser->mandant_id}}">
                                        </td>
                                        <td>
                                            <select name="role_id[]" class="form-control select" data-placeholder="{{ trans('benutzerForm.roles') }}" multiple>
                                                @foreach($rolesAll as $role)
                                                    <option value="{{$role->id}}" {!! ViewHelper::setMultipleSelect($mandantUser->mandantUserRoles, $role->id, 'role_id') !!}> {{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="table-options text-right">
                                            <button class="btn btn-danger delete-prompt" name="remove" value="1" type="submit">{{ trans('benutzerForm.remove') }}</button>
                                            <button class="btn btn-primary" name="save" value="1" type="submit">{{ trans('benutzerForm.save') }}</button>
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
    
    @endif
    
</fieldset>

<div id="mandants-roles" class="clearfix"></div> <br>

@stop