@extends('master')

@section('page-title') {{ trans('juristenPortal.createNotes') }} @stop

@section('content')


<div class="col-md-12 box-wrapper"> 
    <div class="box">
        <div class="row">
            
             {!! Form::open(['route' => 'notice.store', 'method' => 'POST', 'class' => 'horizontal-form' ]) !!} 
            
            <!-- row 1-->
            <div class="col-md-4 col-lg-3 "> 
                <div class="form-group">
                    <label class="control-label">{{ trans('juristenPortal.mandant') }}</label>
                    {!! ViewHelper::setUserSelect($mandantUsers,'mandant', $data, old('mandant'),'', trans('juristenPortal.mandant'), false ) !!}
                </div>
            </div>
            
            
            <div class="col-md-4 col-lg-3"> 
                <div class="form-group">
                    <label class="control-label">{{ trans('juristenPortal.mitarbeiter') }}</label>
                    <select name="mitarbeiter_id" id="mitarbeiter_id" class="form-control select empty-select" data-placeholder="Mitarbeiter">
                        <option value="" data-position="" select >&nbsp;</option>
                        @foreach($mitarbeiterUsers as $mitarbeiterUser)
                            <option value="{{$mitarbeiterUser->id}}" data-position="{{$mitarbeiterUser->position}}">
                                {{ $mitarbeiterUser->last_name }} {{ $mitarbeiterUser->first_name }}  
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-4 col-lg-3">
                <div class="form-group">
                    {!! ViewHelper::setInput('mitarbeiter', $data, old('mitarbeiter'), trans('juristenPortal.mitarbeiterName'), trans('juristenPortal.mitarbeiterName'), false, '', array(''), array('id=mitarbeiter')) !!}
                </div>
            </div>
            
            <div class="col-md-4 col-lg-3">
                <div class="form-group">
                   {!! ViewHelper::setInput('date', $data, old('date'), trans('juristenPortal.date'), trans('juristenPortal.date'), false, 'text', ['datetimepicker']) !!}
                </div>
            </div>
            
            
            <!-- row 2-->
            <div class="col-md-4 col-lg-3"> 
                <div class="form-group">
                    <div class="checkbox text-right">
                        {!! ViewHelper::setCheckbox('ruckruf', $data, old('ruckruf'), trans('juristenPortal.recall')) !!}
                    </div>
                </div>   
            </div>

            <div class="col-md-4 col-lg-3"> 
                <div class="form-group ">
                      {!! ViewHelper::setInput('telefon', $data, old('telefon'), trans('juristenPortal.phone'), trans('juristenPortal.phone'), false) !!}
                </div>   
            </div>
            
            <div class="col-md-4 col-lg-3"> 
                <div class="form-group">
                    {!! ViewHelper::setInput('function', $data, old('function'), trans('juristenPortal.function'), trans('juristenPortal.function'), false, '', array(''), array('id=function')) !!}
                </div>   
            </div><!--End input box-->
            
            <div class="col-md-4 col-lg-3">
                <div class="form-group">
                   {!! ViewHelper::setInput('time', $data, old('time'), trans('juristenPortal.time'), trans('juristenPortal.time'), false, 'text', ['timepicker']) !!}
                </div>
            </div>
            
            <!-- row 3-->
          
            <div class="col-md-3 col-lg-3"> 
                <div class="form-group">
                    
                </div>   
            </div>
          
            <div class="col-md-9 col-lg-9"> 
                <div class="form-group">
                    {!! ViewHelper::setInput('nachricht', $data, old('nachricht'), trans('juristenPortal.nachricht'), trans('juristenPortal.nachricht'), false) !!}
                </div>   
            </div>
            
            <!-- text editor-->
            <div class="clearfix"></div>
          
            <div class="col-xs-12"> 
                <div class="form-group">
                    {!! ViewHelper::setInput('betreff', $data, old('betreff'), trans('juristenPortal.betreff'), trans('juristenPortal.betreff'), false) !!}
                </div>   
            </div>
            
            <div class="col-xs-12">
                <div class="variant" data-id='content'>
                    @if( isset($data->content) )
                        {!! $data->content !!}
                    @endif
                </div>
                
            </div>
            
        </div>

    </div>
    
    <br/>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12 form-buttons">
            {{ Form::submit(trans('documentForm.saveContinue'), array('class' => 'btn btn-primary no-margin-bottom')) }}
        </div>
    </div>
    <div class="clearfix"></div> 
@stop

@section('script')
<script>
$('#mitarbeiter_id').change(function(event) {
    var selected = $(this).find('option:selected');
    var name = $.trim(selected.text());
    var position = selected.data('position');
    $('#mitarbeiter').val(name);
    $('#function').val(position);
});
</script>



@stop