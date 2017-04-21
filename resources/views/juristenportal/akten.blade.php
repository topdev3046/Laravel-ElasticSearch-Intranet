{{-- Akten index --}}

@extends('master')

@section('page-title') @lang('juristenPortal.aktenArt') @stop

@section('content')
<!-- add row-->
<div class="row">
    <div class="col-sm-12 ">
        <div class="box-wrapper">
            <h2 class="title"> @lang('juristenPortal.metaFieldsAddTitle')</h2>
            <div class="box  box-white">
                <div class="row">
                    {!! Form::open([ 'action' => 'JuristenPortalController@storeAkten','method'=>'POST']) !!} 
                      
                            <div class="col-md-4 col-lg-4">
                                {!! ViewHelper::setInput('name', '',old('name'), 
                                trans('inventoryList.name'), trans('inventoryList.name'), true) !!}
                            </div>
                            
                            <div class="col-md-4 col-lg-4">
                                <label>Benutzer</label>
                                <select name="users[]" class="form-control select" multiple data-placeholder="Benutzer">
                                <option></option>
                                    @foreach($users as $user){
                                       <option value="{{$user->id}}"  >
                                        {{ $user->first_name }} {{ $user->last_name }}
                                       </option>
                                    @endforeach
                                </select> 
                            </div>
                        <div class="clearfix"></div><br/>
                        
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary">{{ strtolower(trans('isoKategorienForm.add') ) }}</button>
                        </div> 
                          
                    {!! Form::close() !!}
                </div>
            </div><!-- end box -->
        </div><!-- end box wrapper-->
    </div>
</div><!-- end dd-->
    
    @if(isset($juristFileTypes) && count($juristFileTypes))
    <fieldset class="form-group">
    
    <!--<h4 class="title">{{ trans('adressatenForm.adressats') }} {{ trans('adressatenForm.overview') }}</h4> <br>-->
     <div class="box-wrapper">    
        <div class="row">
            <div class="col-md-12">
                <h4 class="title">{{ trans('juristenPortal.overview') }}</h4>
                <div class="box box-white">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="col-xs-5 vertical-center">
                                    {{ trans('juristenPortal.categories') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($juristFileTypes as $fileType)
                        
                        {!! Form::open(['url' => ['beratungsportal/akten/update/'.$fileType->id] , 'method' => 'patch']) !!}
                        <tr>
                            <td class="col-xs-5 vertical-center">
                                 <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $fileType->name }}" required/>
                            </td>
                            <td class="col-xs-4 vertical-center">
                                <select name="users[]" class="form-control select" multiple data-placeholder="Benutzer">
                                <option></option>
                                    @foreach($users as $user){
                                       <option
                                       {!! ViewHelper::setMultipleSelect($fileType->juristFileTypeUsers, $user->id,'user_id') !!}
                                       value="{{$user->id}}" multiple>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                       </option>
                                    @endforeach
                                </select> 
                            </td>
                            
                            <td class=" text-right table-options">
        
                                @if($fileType->active)
                                    <button class="btn btn-success" type="submit" name="active" value="0">{{ trans('adressatenForm.active') }}</button>
                                @else
                                    <button class="btn btn-danger" type="submit" name="active" value="1">{{ trans('adressatenForm.inactive') }}</button>
                                @endif
                                
                                <button class="btn btn-primary" type="submit">{{ trans('adressatenForm.save') }}</button>
                             
                            </td>
                            
                        </tr>
                          {!! Form::close() !!} 
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </fieldset>
    @endif

@stop
