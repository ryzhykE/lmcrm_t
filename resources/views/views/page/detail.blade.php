@extends('layouts.master')

@section('content')
<table class="table-striped table-hover" style="width: 100%">
    <tbody>
    <tr>
        <td>icon</td>
        <td>{{ $leadInfo->icon ? $leadInfo->icon : '' }}</td>
    </tr>
    <tr>
        <td>date</td>
        <td>{{ $leadInfo->date->format('d.m.Y') }}</td>
    </tr>
    <tr>
        <td>name</td>
        <td>{{ $leadInfo->name}}</td>
    </tr>
    @foreach($leadInfo->sphereAttributes as $attribute)
        <tr>
            <td>{{ $attribute->label }}</td>
            <td>
            @foreach($attribute->options as $option)
                {{ $option->value}}
            @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@stop