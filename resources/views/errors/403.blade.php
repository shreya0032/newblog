@extends('errors::layout')

@section('title', __('Forbidden'))
@section('code', '403 Forbidden')
@section('message', __($exception->getMessage() ?: 'Forbidden'))






    