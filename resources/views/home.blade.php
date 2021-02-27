@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Show all posts</div>

                <div class="card-body">
                    @if (auth()->user()->hasRole('admin'))
                    <a href="">Edit posts</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection