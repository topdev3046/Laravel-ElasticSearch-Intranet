{{-- Invetarliste index --}}

@extends('master')

@section('page-title') {{ trans('navigation.inventoryList') }} @stop

@section('content')

{{--<!-- add row-->
<div class="row">
    <div class="col-sm-12 ">
        <div class="box-wrapper">
            <h2 class="title"> @lang('inventoryList.newInventory')</h2>
            <div class="box  box-white">
                <div class="row">
                    {!! Form::open(['route' => 'inventarliste.store', 'method'=>'POST']) !!}
                            <div class="col-md-4 col-lg-3">
                                {!! ViewHelper::setInput('name', '',old('name'), 
                                trans('inventoryList.name'), trans('inventoryList.name'), true) !!}
                            </div>
                            <div class="col-md-4 col-lg-3">
                                {!! ViewHelper::setSelect($categories,'inventory_category_id',$data,old('inventory_category_id'),
                                    trans('inventoryList.category'), trans('inventoryList.category'),true ) !!}
                            </div>
                            <div class="col-md-4 col-lg-3">
                                {!! ViewHelper::setSelect($sizes,'inventory_size_id',$data,old('inventory_size_id'),
                                    trans('inventoryList.size'), trans('inventoryList.size'),true ) !!}
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label class="control-label">
                                   @lang('inventoryList.number')* 
                                </label> 
                               <input type="number" min="0" name="value" class="form-control" required />
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <span class="custom-input-group-btn">
                                    <button type="submit" class="btn btn-primary no-margin-bottom">
                                        {{ trans('inventoryList.add') }} 
                                    </button>
                                </span>
                            </div>
                    {!! Form::close() !!}
                </div>
            </div><!-- end box -->
        </div><!-- end box wrapper-->
    </div>
</div><!-- end add row --> --}}

<!--search row-->
<div class="row">
    <div class="col-sm-12 ">
        <div class="box-wrapper">
            <h2 class="title"> @lang('inventoryList.searchInventoryList')</h2>
            <div class="box  box-white">
                <div class="row">
                    {!! Form::open(['action' => 'InventoryController@search', 'method'=>'POST']) !!}
                        <div class="input-group">
                            <div class="col-md-12 col-lg-12">
                                @if( isset($searchInput) ) 
                                    {!! ViewHelper::setInput('search', '',$searchInput, 
                                    trans('inventoryList.name'), trans('inventoryList.name'), true) !!}
                                @else
                                    {!! ViewHelper::setInput('search', '',old('search'), trans('inventoryList.name'),
                                    trans('inventoryList.name'), true) !!}
                                @endif
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <span class="custom-input-group-btn">
                                    <button type="submit" class="btn btn-primary no-margin-bottom">
                                        {{ trans('navigation.search') }} 
                                    </button>
                                </span>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div><!-- end box -->
        </div><!-- end box wrapper-->
    </div>
</div><!-- end search row -->
    @if( $searchCategories || $searchInventory )
        <!-- search results categories categorie box-->
        <h2 class="title">{{ trans('inventoryList.categorySearchResults') }}</h2>
        
            @if( count($searchCategories) )
                @foreach( $searchCategories as $category)
                    <div class="panel-group">
                        <div class="panel panel-primary" id="panelInventory{{$category->id}}">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                        <a data-toggle="collapse" data-target="#collapseInventory{{$category->id}}" class="collapsed transform-normal" 
                                           href="#collapseInventory{{$category->id}}">
                                          {{$category->name}} ({{ $category->items->count() }})
                                        </a>
                                </h4>
                            </div><!--end .panel-heading -->    
                        </div><!--end .panel.panel-primary -->
                    
                        <div id="collapseInventory{{$category->id}}" class="panel-collapse collapse">
                            <div class="panel-body box-white">
                                <table class="table data-table box-white">
                                <thead>
                                    <th  class="text-center valign">@lang('inventoryList.name')</th>
                                    <th  class="text-center valign">@lang('inventoryList.number')</th>
                                    <th class="text-center valign">@lang('inventoryList.size')</th>
                                    <th class="text-center valign">@lang('inventoryList.changes')</th>
                                    <th class="text-center valign no-sort">@lang('inventoryList.edit')</th>
                                    @if( ViewHelper::universalHasPermission( array(7) ) )
                                        <th class="text-center valign no-sort">@lang('inventoryList.view')</th>
                                    @endif
                                    <th class="text-center valign no-sort">@lang('inventoryList.history')</th>
                                </thead>
                                <tbody>
                                    @if(count($category->items->count()) )
                                        @foreach($category->items as $k => $item)
                                            <tr>
                                                <td class="text-center valign">
                                                    {{ $item->name }}
                                                </td>
                                                <td class="text-center valign ">
                                                    <a href="#" data-toggle="modal" data-target="#item-taken-{{$item->id}}">
                                                        {{ $item->value }}
                                                    </a>
                                                    {!! ViewHelper::generateInventoryTakenModal($item) !!}  
                                                </td>
                                                <td class="text-center valign ">
                                                    {{ $item->size->name }}
                                                </td>
                                                <td class="text-center valign ">
                                                    {{ $item->updated_at }}
                                                </td>
                                                <td class="text-center valign"> 
                                                    <a href="{{route('inventarliste.edit', ['id'=> $item->id])}}">
                                                        @lang('inventoryList.edit')
                                                    </a>   
                                                </td>
                                                @if( ViewHelper::universalHasPermission( array(7) ) )
                                                    <td class="text-center valign"> 
                                                        <a href="#" data-toggle="modal" data-target="#item-view-{{$item->id}}">
                                                            @lang('inventoryList.view')
                                                        </a>
                                                        {!! ViewHelper::generateInventoryViewModal($item) !!}  
                                                    </td>
                                                @endif
                                                <td class="text-center valign"> 
                                                    <a href="{{url('inventarliste/historie/'.$item->id)}}">
                                                        @lang('inventoryList.history')
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class"valign"></td>
                                            <td class"valign"></td>
                                            <td class"valign"></td>
                                            <td class"valign">Keine Daten vorhanden</td>
                                            <td class"valign"></td>
                                            <td class"valign"></td>
                                        </tr>
                                    @endif
                                
                                </tbody>
                            </table>    
                            </div><!-- end .panel-body -->
                        </div><!-- end .panel-collapse -->
                    
                    </div><!--end .panel-group-->
                
                @endforeach
            @else
                <div class="box box-white">
                    <table class="table data-table box-white">
                        <thead>
                            <th  class="text-center valign">@lang('inventoryList.name')</th>
                            <th  class="text-center valign">@lang('inventoryList.number')</th>
                            <th class="text-center valign">@lang('inventoryList.size')</th>
                            <th class="text-center valign">@lang('inventoryList.changes')</th>
                            <th class="text-center valign no-sort">@lang('inventoryList.edit')</th>
                            @if( ViewHelper::universalHasPermission( array(7) ) )
                                <th class="text-center valign no-sort">@lang('inventoryList.view')</th>
                            @endif
                            <th class="text-center valign no-sort">@lang('inventoryList.history')</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class"valign"></td>
                                <td class"valign"></td>
                                <td class"valign"></td>
                                <td class"valign">Keine Daten vorhanden</td>
                                <td class"valign"></td>
                                <th class="text-center valign no-sort">@lang('inventoryList.edit')</th>
                                @if( ViewHelper::universalHasPermission( array(7) ) )
                                    <td class="text-center valign no-sort"></td>
                                @endif
                                <td class"valign"></td>
                            </tr>
                        </tbody>
                    </table>
                    </div><!-- end box -->
            @endif
        
        <!-- search results categories categorie box-->
        <div class="col-xs-12 box-wrapper">
            <h2 class="title">{{ trans('inventoryList.inventorySearchResults') }}</h2>
                <div class="box box-white">
                    <table class="table data-table box-white">
                        <thead>
                            <th  class="text-center valign">@lang('inventoryList.name')</th>
                            <th  class="text-center valign">@lang('inventoryList.number')</th>
                            <th class="text-center valign">@lang('inventoryList.size')</th>
                            <th class="text-center valign">@lang('inventoryList.changes')</th>
                            <th class="text-center valign no-sort">@lang('inventoryList.edit')</th>
                            @if( ViewHelper::universalHasPermission( array(7) ) )
                                <th class="text-center valign no-sort">@lang('inventoryList.view')</th>
                            @endif
                            <th class="text-center valign no-sort">@lang('inventoryList.history')</th>
                        </thead>
                        <tbody>
                            @if(count( $searchInventory ) > 0)
                                @foreach($searchInventory as $k => $item)
                                    <tr>
                                    <td class="text-center valign">
                                            {{ $item->name }}
                                        </td>
                                        <td class="text-center valign ">
                                            <a href="#" data-toggle="modal" data-target="#item-taken-{{$item->id}}">
                                                {{ $item->value }}
                                            </a>
                                            {!! ViewHelper::generateInventoryTakenModal($item) !!}  
                                        </td>
                                        <td class="text-center valign ">
                                            {{ $item->size->name }}
                                        </td>
                                        <td class="text-center valign ">
                                            {{ $item->updated_at }}
                                        </td>
                                        <td class="text-center valign"> 
                                            <a href="{{route('inventarliste.edit', ['id'=> $item->id])}}">
                                                @lang('inventoryList.edit')
                                            </a>   
                                        </td>
                                        @if( ViewHelper::universalHasPermission( array(7) ) )
                                            <td class="text-center valign"> 
                                                <a href="#" data-toggle="modal" data-target="#item-view-{{$item->id}}">
                                                    @lang('inventoryList.view')
                                                </a>
                                                {!! ViewHelper::generateInventoryViewModal($item) !!}  
                                            </td>
                                        @endif
                                        <td class="text-center valign"> 
                                            <a href="{{url('inventarliste/historie/'.$item->id)}}">
                                                @lang('inventoryList.history')
                                            </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class"valign"></td>
                                    <td class"valign"></td>
                                    <td class"valign"></td>
                                    <td class"valign">Keine Daten vorhanden</td>
                                    <td class"valign"></td>
                                    <td class="text-center valign no-sort">@lang('inventoryList.edit')</td>
                                    @if( ViewHelper::universalHasPermission( array(7) ) )
                                        <td class="text-center valign no-sort"></tdh>
                                    @endif
                                    <td class"valign"></td>
                                </tr>
                            @endif
                        
                        </tbody>
                    </table>
                </div><!-- end box -->
                <div class="clearfix"></div>
                <br/>
        </div><!--end  regular categorie box wrapper-->
    @else
        <!-- regular categorie box-->
        @if($categories)
            @foreach( $categories as $category)
                <div class="panel-group">
                    <div class="panel panel-primary" id="panelInventory{{$category->id}}">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                    <a data-toggle="collapse" data-target="#collapseInventory{{$category->id}}" class="collapsed transform-normal" 
                                       href="#collapseInventory{{$category->id}}">
                                      {{$category->name}} ({{ $category->items->count() }})
                                    </a>
                            </h4>
                        </div><!--end .panel-heading -->    
                    </div><!--end .panel.panel-primary -->
                
                    <div id="collapseInventory{{$category->id}}" class="panel-collapse collapse">
                        <div class="panel-body box-white">
                            <table class="table data-table box-white">
                            <thead>
                                <th  class="text-center valign">@lang('inventoryList.name')</th>
                                <th  class="text-center valign">@lang('inventoryList.number')</th>
                                <th class="text-center valign">@lang('inventoryList.size')</th>
                                <th class="text-center valign">@lang('inventoryList.changes')</th>
                                <th class="text-center valign no-sort">@lang('inventoryList.edit')</th>
                                @if( ViewHelper::universalHasPermission( array(7) ) )
                                    <th class="text-center valign no-sort">@lang('inventoryList.view')</th>
                                @endif
                                <th class="text-center valign no-sort">@lang('inventoryList.history')</th>
                            </thead>
                            <tbody>
                                @if(count($category->items->count()) )
                                    @foreach($category->items as $k => $item)
                                        <tr>
                                        <td class="text-center valign">
                                            {{ $item->name }}
                                        </td>
                                        <td class="text-center valign ">
                                            <a href="#" data-toggle="modal" data-target="#item-taken-{{$item->id}}">
                                                {{ $item->value }}
                                            </a>
                                            {!! ViewHelper::generateInventoryTakenModal($item) !!}  
                                        </td>
                                        <td class="text-center valign ">
                                            {{ $item->size->name }}
                                        </td>
                                        <td class="text-center valign ">
                                            {{ $item->updated_at }}
                                        </td>
                                        <td class="text-center valign"> 
                                            <a href="{{route('inventarliste.edit', ['id'=> $item->id])}}">
                                                @lang('inventoryList.edit')
                                            </a>   
                                        </td>
                                        @if( ViewHelper::universalHasPermission( array(7) ) )
                                            <td class="text-center valign"> 
                                                <a href="#" data-toggle="modal" data-target="#item-view-{{$item->id}}">
                                                    @lang('inventoryList.view')
                                                </a>
                                                {!! ViewHelper::generateInventoryViewModal($item) !!}  
                                            </td>
                                        @endif
                                        <td class="text-center valign"> 
                                            <a href="{{url('inventarliste/historie/'.$item->id)}}">
                                                @lang('inventoryList.history')
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class"valign"></td>
                                        <td class"valign"></td>
                                        <td class"valign"></td>
                                        <td class"valign">Keine Daten vorhanden</td>
                                        <td class"valign"></td>
                                        <td class"valign"></td>
                                    </tr>
                                @endif
                            
                            </tbody>
                        </table>    
                        </div><!-- end .panel-body -->
                    </div><!-- end .panel-collapse -->
                
                </div><!--end .panel-group-->  
            @endforeach
        @endif
       
    @endif

@stop
