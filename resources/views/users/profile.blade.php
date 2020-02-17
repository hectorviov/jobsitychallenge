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
        <div class="text-center">
            {{ $entries->links() }}
        </div>
    </div>
    <div class="col-md-4">
        <h3 class="ml-4">Tweets</h3>
        {{-- <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Entry title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Author link</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <p class="card-text"><small class="text-muted">Written on date</small></p>
            </div>
        </div> --}}
    </div>
</div>
@endsection