@extends('layouts.app-shell')

@section('content_wrapper')
    <div class="d-flex flex-column shadow content">
        <div class="content-inner d-flex flex-column gap-2.5">
            @yield('content')
        </div>
    </div>
@endsection
