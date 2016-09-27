    <div class="box-wrapper">
        <div class="box">
            <div class="row">
            {{ Form::open(['route' => ['mandant.internal-roles-add', $data->id], 'method'=>'POST', 'class' => 'add-internal-role']) }}
            
                <div class="col-md-6 col-lg-4"> 
                    <div class="form-group">
                        
                        <label>{{ trans('mandantenForm.role-zuordnung') }}</label>
                        <select name="role_id" class="form-control select" data-placeholder="Rolle wählen *" data-target="internal_new" required >
                            <option></option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4"> 
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <select name="user_id" class="form-control select internal_new" data-placeholder="Mitarbeiter auswählen *" required>
                            <option></option>
                            @foreach($mandantUsersNeptun as $mandantUser)
                                <option value="{{ $mandantUser->id }}" >
                                    {{ $mandantUser->user->first_name }} {{ $mandantUser->user->last_name }}
                                    [{{$mandantUser->mandant->mandant_number .' - '. $mandantUser->mandant->kurzname}}]
                                </option>
                            @endforeach
                        </select>
                    </div>   
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group custom-input-group-btn">
                        <button class="btn btn-primary" type="submit" name='role-create' value="1">{{ trans('mandantenForm.add') }}</button>
                    </div>
                </div>
                
            {{ Form::close() }}

@if(count($internalMandantUsers))
    @foreach($internalMandantUsers as $internalUser)
    <div class="clearfix"></div>
    
    {{ Form::open(['route' => ['mandant.internal-roles-edit', $data->id], 'method'=>'POST', 'id' => 'internal-role-'.$internalUser->id, 
    'class' => 'edit-internal-role' ,'data-remote']) }}
        <input type="hidden" value="{{ $internalUser->role_id }}" name="old_role_id" />
        <div class="col-md-6 col-lg-4"> 
            <div class="form-group">
                <!--<label class="control-label">{{ trans('mandantenForm.role') }}*</label>-->
                <select name="role_id" class="form-control select" data-placeholder="Rolle wählen *" data-target="internal_{{$internalUser->id}}" required >
                    <option></option>
                    @foreach($roles as $role)
                        <option @if($internalUser->role_id == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>   
        </div>
        
        <div class="col-md-6 col-lg-4"> 
            <div class="form-group">
                <!--<label class="control-label">{{ trans('mandantenForm.user') }}*</label>-->
                <select name="user_id" class="form-control select internal_{{$internalUser->id}}" data-placeholder="Mitarbeiter auswählen *" required>
                    <option></option>
                    @foreach($mandantUsersNeptun as $mandantUser)
                        <option value="{{ $mandantUser->user->id }}"  @if($internalUser->user_id == $mandantUser->user->id) selected @endif>
                            {{ $mandantUser->user->first_name }} {{ $mandantUser->user->last_name }}
                            [{{$mandantUser->mandant->mandant_number .' - '. $mandantUser->mandant->kurzname}}]
                        </option>
                    @endforeach
                </select>
            </div>   
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <input type="hidden" name="internal_mandant_user_id" value="{{$internalUser->id}}">
                <button class="btn btn-danger delete-prompt" type="submit" name='role-delete' value="1">{{ trans('mandantenForm.remove') }}</button>
                <button class="btn btn-primary" type="submit" name='role-update' value="1">{{ trans('mandantenForm.save') }}</button>
            </div>
        </div>
    {{ Form::close() }}
    
    @endforeach
@endif


<div id="internal-roles" class="clearfix"></div>

</div>
</div>

{{-- JS functionality and AJAX calls --}}
@section('afterScript')
    <script>
        $(function(){
            
            // Define select box
            var selectElement = $('select[name="role_id"]');
            
            // AJAX Request function
            function ajaxInternalRoles(roleId, selectTarget){
                $.ajax({
                    url: '/mandanten/ajax-internal-roles',
                    type: 'POST',
                    data: {
                        _token: '{{csrf_token()}}',
                        role_id: roleId,
                    },
                    dataType: 'html',
                    success: function (data) {
                        selectTarget.html(data);
                        selectTarget.trigger("chosen:updated");
                        // console.log(data);
                    }
                });
            }
            
            // Select trigger
            selectElement.chosen().change(function(){
                var roleId = $(this).val();
                var selectTarget = $('select.'+$(this).data('target'));
                ajaxInternalRoles(roleId, selectTarget);
                // console.log(selectTarget);
                // console.log($(this).data('target'));
            });
            
        });
    </script>
@stop