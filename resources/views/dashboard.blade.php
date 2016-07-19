@extends('master')

@section('page-title-class') home @stop

@section('page-title')
    Guten Tag {{ auth()->user()->title ." ". auth()->user()->first_name ." ". auth()->user()->last_name }}
    <br> Herzlich willkommen im NEPTUN Intranet
@stop

@section('bodyClass') home-page @stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6 ">
            <div class="col-xs-12 box-wrapper home">
                <h1 class="title">Neue Dokumente/Rundschreiben</h1>
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
                <!--<div class="text-center">-->
                <!--    <ul class="pagination">-->
                <!--        <li class="pull-left"><a href="#" aria-label="Prev"><span aria-hidden="true">&lt; zurück</span></a></li>-->
                <!--            <li class="active "><a href="#">1</a></li>-->
                <!--            @for($i=2; $i < 5; $i++)-->
                <!--                <li class=""><a href="#">{{$i}}</a></li>-->
                <!--            @endfor-->
                <!--        <li class="pull-right"><a href="#" aria-label="Next"><span aria-hidden="true">weiter &gt;</span></a></li>-->
                <!--    </ul>-->
                <!--</div>-->
                
            </div>
        </div>
    
        <div class="col-xs-12 col-md-6 ">
            <div class="col-xs-12 box-wrapper home">
                <h1 class="title">Meine Dokumente/Rundschreiben</h1>
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
            </div>
        </div>

    </div>
    
    <br>

    <div class="row">
        
        <div class="col-xs-12 col-md-6 ">
            <div class="col-xs-12 box-wrapper home">
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
                    <a href="#" class="btn btn-primary pull-right">Wiki aufrufen</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    
        <!--<div class="clearfix"></div><br>-->
        
        {{-- <div class="col-xs-12 col-md-6 ">
            <div class="col-xs-12 box-wrapper home">
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
        
        <div class="col-xs-12 col-md-6 ">
            <div class="col-xs-12 box-wrapper home">
                <h1 class="title">Dokumente im Freigabeprozess</h1>
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
            </div>
        </div>
        
    </div>
    
    <div class="clearfix"></div><br>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-12 box-wrapper home">
                <h1 class="title">Meine letzten Kommentare</h1>
                <div class="box home">
                    <div class="commentsMy">
                        @if(count($commentsMy))
                            @foreach($commentsMy as $k => $comment)
                                <div class="comment-{{++$k}}">
                                    <span class="comment-header">
                                        <a href="{{url('/dokumente/'. $comment->document->published->url_unique)}}">
                                            <strong>{{ $comment->document->name }}</strong>
                                        </a>
                                        , {{ $comment->created_at }}
                                    </span> <br>
                                    <span class="comment-body">
                                        {{ str_limit($comment->comment, $limit = 200, $end = ' ...') }}
                                    </span>
                                </div>
                                <div class="clearfix"></div><br>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div><br>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-12 box-wrapper home">
                <h1 class="title">Neue Kommentare</h1>
                <div class="box home">
                    <div class="commentsNew">
                        @if(count($commentsNew))
                            @foreach($commentsNew as $k => $comment)
                                <div class="comment-{{++$k}}">
                                    <span class="comment-header">
                                        <a href="{{url('/dokumente/'. $comment->document->published->url_unique)}}">
                                            <strong>{{ $comment->document->name }}</strong>
                                        </a>
                                        - {{ $comment->user->first_name ." ". $comment->user->last_name }}, {{ $comment->created_at }}
                                    </span> <br>
                                    <span class="comment-body">
                                        {{ str_limit($comment->comment, $limit = 200, $end = ' ...') }}
                                    </span>
                                </div>
                                <div class="clearfix"></div><br>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div><br>

@stop
   