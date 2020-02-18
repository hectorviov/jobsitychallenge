@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4 ml-4">{{ $entry->title }}</h1>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title"><a href="{{ route('user.profile', ['username' => $entry->user->username ]) }}">By {{ $entry->user->username }}</a></h4>

                    @if(!Auth::guest())
                        @if ($entry->user_id === Auth::user()->id)
                            <h6><a href="{{ route('entries.edit', ['id' => $entry->id]) }}">Edit entry</a></h6>
                        @endif
                    @endif
                <p class="card-text">{!! nl2br(e($entry->content)) !!}</p>
                <p class="card-text"><small class="text-muted">Written on {{ date('m-d-Y', strtotime($entry->created_at)) }}</small></p>
            </div>
        </div>
    </div>
</div>
@endsection
