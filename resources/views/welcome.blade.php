@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Latest entries</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Entry title</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Author link</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <p class="card-text"><small class="text-muted">Written on date</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
