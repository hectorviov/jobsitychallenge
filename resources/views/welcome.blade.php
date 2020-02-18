@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4">Latest entries</h1>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        @if(count($entries))
            @foreach ($entries as $entry)
            <div class="card mb-4">
                <div class="card-body">
                    <a class="title-link" href="{{ route('entry.view', ['id' => $entry->id]) }}"><h4 class="card-title">{{ $entry->title }}</h4></a>
                    <h6 class="card-subtitle mb-2 text-muted">
                        <a href="{{ route('user.profile', ['username' => $entry->user->username ]) }}">By {{ $entry->user->username }}</a>
                        
                        @if(!Auth::guest())
                            @if ($entry->user_id === Auth::user()->id)
                                <a href="{{ route('entries.edit', ['id' => $entry->id]) }}">Edit entry</a>
                            @endif
                        @endif
                    </h6>
                    <p class="card-text">{!! nl2br(e($entry->content)) !!}</p>
                    <p class="card-text"><small class="text-muted">Written on {{ date('m-d-Y', strtotime($entry->created_at)) }}</small></p>
                </div>
            </div>
            @endforeach
            {{ $entries->onEachSide(1)->links() }}
        @else
        <div class="card mb-4">
            <div class="card-body">
                <h5>Nobody's wrtitten any entry yet.</h5>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
