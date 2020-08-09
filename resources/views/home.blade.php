@extends('layouts.main')

@section('title')
ChipTranz|Home
@endsection
@section('main-content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <div id="main" class="container-scroller">



    </div>


@endsection
