@extends('layouts.app')
@section('content_title','Category Data')
@section('content')
<div class="card">
    <div class="p-2 d-flex justify-content-between border">
        <h4 class="card-title m-2">Category Data</h4>
        <x-category.form-category button-label="New User"/>
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger d-flex flex-column">
        @foreach ($errors->all() as $error)
            <small class="text-white my-2">{{ $error }}</small>
        @endforeach
        </div>
        @endif
        <div class="table-responsive">
    <table class="table table-sm table-striped table-bordered" id="table1" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Category</th>
                <th>Description</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $item )
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_category }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    <div class="d-flex align-item-center">
                    <x-category.form-category :id="$item->id"/>
                        <a href="{{ route('master-data.category.destroy', $item->id) }}" data-confirm-delete="true"
                            class="btn btn-danger mx-1">
                        <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
                
            @endforeach
        </tbody>
    </table>
    </div>
    </div>
</div>
@endsection