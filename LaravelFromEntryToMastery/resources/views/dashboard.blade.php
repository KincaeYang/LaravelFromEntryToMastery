@extends('layouts.master');

@section('title','后台管理');

@section('content','环境访问 Laravel 学院后台！');

@section('footerScripts');
    @parent
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection