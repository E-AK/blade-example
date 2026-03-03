@extends('layouts.app-shell')

@section('content_wrapper')
    <div class="d-flex flex-column shadow content content--fill">
        <div class="content-inner content-two-column">
            <aside class="content-two-column__sidebar">
                @yield('content_sidebar')
            </aside>
            <div class="content-two-column__main">
                @yield('content_main')
            </div>
        </div>
    </div>
@endsection
