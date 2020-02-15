@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Useful links</div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('index') }}" class="btn btn-link">Home page</a> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('user.profile', ['username' => Auth::user()->username]) }}" class="btn btn-link">Profile</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
