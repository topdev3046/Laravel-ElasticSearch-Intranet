@extends('master')

@section('page-title-class') home @stop

@section('page-title')
    Guten Tag {{ auth()->user()->title ." ". auth()->user()->first_name ." ". auth()->user()->last_name }}
    <br> Herzlich Willkommen im NEPTUN Intranet
@stop

@section('bodyClass') home-page @stop

@section('content')
<div class="row">
    
    <div class="col-xs-12 col-md-6 ">
        <div class="col-xs-12 box-wrapper box-white home">
            <h1 class="title">Neue Dokumente/Rundschreiben</h1>
            
            @if(count($documentsNew))
                <div class="box home">
                    <div class="tree-view" data-selector="documentsNew">
                        <div class="documentsNew hide">
                            {{ $documentsNewTree }} 
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    {!! $documentsNew->render() !!}
                </div>
            @else
                <div class="box">
                    <span class="text">Keine Dokumente gefunden.</span>
                </div>
            @endif
            
        </div>
    </div>
    
    @if( ViewHelper::universalHasPermission( array(11,13) ) == true && count( $rundschreibenMy) ) <!--  array(10,11,12,13)  NEPTUN-276, count is 275-->
        <div class="col-xs-12 col-md-6 ">
            <div class="col-xs-12 box-wrapper box-white home">
                <h1 class="title">Meine Dokumente/Rundschreiben</h1>
                
                @if(count($rundschreibenMy))
                    <div class="box home">
                        <div class="tree-view" data-selector="rundschreibenMy">
                            <div class="rundschreibenMy hide">
                                {{ $rundschreibenMyTree }}
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        {!! $rundschreibenMy->render() !!}
                    </div>
                @else
                    <div class="box">
                        <span class="text">Keine Dokumente gefunden.</span>
                    </div>
                @endif
                
            </div>
        </div>
        <div class="clearfix"></div><br>
    @endif



   
    {{-- Only show Wiki Box if logged user has Wiki Leser or Wiki Redakteur role, OR if users mandant has Wiki rights  --}}
    @if( ViewHelper::universalHasPermission(array(15,16)) 
        || ViewHelper::getMandantWikiPermission() ) 
        <div class="col-xs-12 col-md-6 ">
            <div class="col-xs-12 box-wrapper box-white home">
                <h1 class="title">Neue Wiki-Einträge</h1>
                <div class="box home">
                    <div class="tree-view hide-icons" data-selector="wikiEntries">
                        <div class="wikiEntries hide">
                            {{ $wikiEntries }}
                        </div>
                    </div>
                </div>
                <div class="buttons wiki">
                    <br>
                    <a href="{{url('/wiki')}}" class="btn btn-primary pull-right">Wiki aufrufen</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @endif
    
    @if( ViewHelper::universalHasPermission( array(10,11,12,13) ) == false  ) 
        <!--<div class="clearfix"></div>-->
    @endif
    <!--<div class="clearfix"></div><br>-->
    
    {{-- <div class="col-xs-12 col-md-6 ">
        <div class="col-xs-12 box-wrapper box-white home">
            <h1 class="title">Meine Dokumente</h1>
            <div class="box home">
                <div class="tree-view" data-selector="documentsMy">
                    <div class="documentsMy hide">
                        {{ $documentsMyTree }}
                    </div>
                </div>
            </div>
              <div class="text-center">
                {!! $documentsMy->render() !!}
            </div>
        </div>
    </div> --}}
    
    @if( ViewHelper::universalHasPermission( array(10) ) == true || count($freigabeEntries) > 0 ) 
    <div class="col-xs-12 col-md-6 ">
        <div class="col-xs-12 box-wrapper box-white home">
            <h1 class="title">Dokumente im Freigabeprozess</h1>
            
            @if(count($freigabeEntries))
                <div class="box home">
                    <div class="tree-view" data-selector="freigabeEntries">
                        <div class="freigabeEntries hide">
                            {{ $freigabeEntriesTree }}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    {!! $freigabeEntries->render() !!}
                </div>
            @else
                <div class="box">
                    <span class="text">Keine Dokumente gefunden.</span>
                </div>
            @endif
        </div>
    </div>
    @endif
     
    <div class="clearfix"></div><br>
    
        @if(count($commentsMy))
            {!! ViewHelper::generateCommentBoxes($commentsMy, 'Meine letzten Kommentare' ) !!}
        @endif
        
    
    <div class="clearfix"></div><br>
    
    @if( $commentVisibility == true) 
        @if( count($commentsNew) )
        {!! ViewHelper::generateCommentBoxes($commentsNew, 'Neue Kommentare' ) !!}
        @endif
    @endif
    <div class="clearfix"></div><br>

</div>

@stop
   