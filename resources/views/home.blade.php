@extends('layouts.app')
@section('content')
   <link rel="stylesheet" type="text/css" href="{{ asset('chat/bootstrap.min.css') }}">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="app">
   <input type="hidden" id="sessionId" value="{{ auth::user()->id }}">
   <input type="hidden" id="sessionName" value="{{ auth::user()->name }}">
   <chat-component/>
</div>
@endsection