{{-- ISO KATEGORIEN --}}

@extends('master')

@section('page-title') {{ trans('contactForm.verwaltung') }} - {{ trans('wiedervorlagenStatus.wiedervorlagenStatus') }} @stop

@section('content')

<fieldset class="form-group">
    <div class="box-wrapper">
        <h4 class="title">{{ trans('wiedervorlagenStatus.wiedervorlagenStatus') }} {{ trans('wiedervorlagenStatus.add') }} </h4>
        <div class="box box-white">
      
            <!-- input box-->
            
            {!! Form::open(['route' => 'wiedervorlagen-status.store']) !!}
                <div class="row">
                    <div class="col-md-6 col-lg-4"> 
                        <div class="form-group">
                            {!! ViewHelper::setInput('name', '', old('name'), trans('wiedervorlagenStatus.name'), trans('wiedervorlagenStatus.name'), true) !!} 
                         </div> 
                    </div>
                    <div class="col-md-6 col-lg-4"> 
                        <div class="form-group">
                            {!! ViewHelper::setInput('color', '', old('color'), trans('wiedervorlagenStatus.colorcode'), trans('wiedervorlagenStatus.colorcode'), true, '', array('colorpicker') ) !!}
                         </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-2 custom-input-group-btn"> 
                       <button class="btn btn-primary no-margin-bottom">{{ trans('wiedervorlagenStatus.add') }} </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
</fieldset>


<fieldset class="form-group">
    
     
    <div class="box-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h4 class="title">{{ trans('wiedervorlagenStatus.overview') }}</h4>
                <div class="box box-white">
                    <table class="table">
                        <tr>
                            <th colspan="3">
                                {{ trans('wiedervorlagenStatus.name') }}
                            </th>
                        </tr>
                        @foreach($wiedervorlagenStatuss as $wiedervorlagenStatus)
                      
                        {!! Form::open(['route' => ['wiedervorlagen-status.update', 'wiedervorlagen-status' => $wiedervorlagenStatus->id], 'method' => 'PATCH']) !!}
                         <tr>
                            <td class="col-xs-4 vertical-center">
                                 <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $wiedervorlagenStatus->name }}" required/>
                            </td>
                            <td class="col-xs-4 vertical-center position-relative">
                                <input type="text" class="form-control colorpicker" name="color" placeholder="Farbcode" value="{{ $wiedervorlagenStatus->color }}" required/>
                            </td>
                            <td class="col-xs-4 text-right table-options">
        
                                @if($wiedervorlagenStatus->active)
                                <button class="btn btn-success" type="submit" name="activate" value="1">{{ trans('adressatenForm.active') }}</button>
                                @else
                                <button class="btn btn-danger" type="submit" name="activate" value="0">{{ trans('adressatenForm.inactive') }}</button>
                                @endif
                                
                                <button class="btn btn-primary" type="submit">{{ trans('adressatenForm.save') }}</button>
                               {!! Form::close() !!} 
                               
                               @if( count($wiedervorlagenStatus->hasAllDocuments) < 1  )
                                {!! Form::open([
                                   'url' => 'wiedervorlagen-status/'.$wiedervorlagenStatus->id,
                                   'method' => 'DELETE',
                                   'class' => 'horizontal-form',]) !!}
                                        <button  type="submit" href="" class="btn btn-danger delete-prompt"
                                         data-text="{{ trans('wiedervorlagenStatus.question-delete') }}">
                                             {{ trans('adressatenForm.delete') }}
                                         </button> 
                                     </form>
                                @endif     
                            </td>
                            
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</fieldset>

<div class="clearfix"></div> <br>

@stop
