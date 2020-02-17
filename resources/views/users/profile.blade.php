@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4 text-center">{{ str_possessive($user->username) }} profile</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <h3 class="ml-4">Entries</h3>
        @if (count($entries))
            @foreach ($entries as $entry)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $entry->title }}</h5>
                    
                    @if(!Auth::guest())
                        @if(Auth::user()->id === $entry->user_id)
                            <h6 class="card-subtitle mb-2 text-muted">
                                <a href="{{ route('entries.edit', ['id' => $entry->id]) }}">Edit entry</a>
                            </h6>
                        @endif
                    @endif
                    <p class="card-text">{!! nl2br(e($entry->content)) !!}</p>
                    <p class="card-text"><small class="text-muted">Written on {{ date('m-d-Y', strtotime($entry->created_at)) }}</small></p>
                </div>
            </div>
            @endforeach
            {{ $entries->onEachSide(1)->links() }}
        @else
        <div class="card mb-4">
            <div class="card-body">
                <h5>{{ str_possessive($user->username) }} hasn't wrtitten any entry yet.</h5>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-4" id="tweets">
        <div id="loading-tweets">
            <div class="spinner"></div>
        </div>
        <h3 class="ml-4">Tweets</h3>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var currentPage = 1;
    $(document).ready(function() {
        loadMoreTweets(currentPage);
    });

    $('body').on('click', '#loadMore', function() {
        $(this).remove();
        $('#loading-tweets').show();
        currentPage++;
        loadMoreTweets(currentPage);
    });


    $('body').on('click', '.toggle-hide-btn', function(e) {
        e.preventDefault();
        var link = $(this);
        link.tooltip('hide');
        var tweetId = $(this).attr('data-tweet-id');
        $.ajax({
            url: "/users/{{ $user->username }}/tweets/toggle/" + tweetId,
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}"
            }
        }).done(function(data) {
            if(!data.success) {
                alert(data.message);
            } else {
                var ttTitle = '';
                var icon = '';
                if(data.shown) {
                    ttTitle = 'Hide tweet';
                    icon = 'eye';
                    link.closest('.card').removeClass('hidden');
                } else {
                    ttTitle = 'Unhide tweet';
                    icon = 'eye-slash';
                    link.closest('.card').addClass('hidden');
                }
                link.children('i').removeClass().addClass('fa fa-' + icon);
                link.attr("title", ttTitle)
                    .tooltip('_fixTitle')
                    .tooltip('show');
            }
        });
    });

    function loadMoreTweets(page) {
        $.ajax({
            url: "/users/{{ $user->username }}/tweets?page=" + page
        }).done(function(data) {
            var html = '';
            $.each(data, function(i, obj) {
                $.each(obj, function(id, tweet) {
                    var title = '';
                    var icon = '';
                    var styleClass = '';
                    if(tweet.hidden) {
                        icon = 'eye-slash';
                        title = 'Unhide tweet';
                        styleClass = 'hidden';
                    } else {
                        icon = 'eye';
                        title = 'Hide tweet';
                        styleClass = '';
                    }
                    html = '';
                    html += '<div class="card mb-4 ' + styleClass + '">';
                    html += '<div class="card-body">';
                    html += '<p class="card-text">' + tweet.text + '</p>';
                    html += '<p class="card-text"><small class="text-muted">Written on ' + tweet.date + '</small></p>';
                    
                    @if(!Auth::guest())
                        @if(Auth::user()->id === $entry->user_id)
                            html += '<a class="toggle-hide-btn" data-tweet-id="' + id + '" data-toggle="tooltip" data-placement="left" title="' + title + '" href="#"><i class="fa fa-' + icon + '"></i></a>';  
                        @endif
                    @endif
                    html += '</div></div>';
                    $('#tweets').append(html);
                    $('[data-toggle="tooltip"]').tooltip({container: 'body'});
                });
            });
            html = '<div class="text-center"><button type="button" class="btn btn-secondary" id="loadMore">Load more tweets</button></div>';
            $('#tweets').append(html);
        }).always(function() {
            $('#loading-tweets').hide();
        });
    }
</script>
@endsection