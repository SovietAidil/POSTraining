@extends('layouts.app')
@section('content_title', 'Data Users')
@section('content')

<div class="card">
    <!-- Card Header -->
    <div class="p-2 d-flex justify-content-between align-items-center border">
        <h4 class="card-title m-2">Data Users</h4>
        <!-- Add User button -->
        <x-user.form-user button-label="New User"/>
    </div>

    <!-- Card Body -->
    <div class="card-body">
        <x-alert :errors="$errors"/>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered" id="table2" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            <div class="d-flex justify-content-end align-items-center">
                                <!-- Edit Button triggers modal -->
                                <x-user.form-user :id="$user->id" button-label="Edit" class="mx-1"/>
                                
                                <div class="d-flex align-item-center"> 
                                <!-- Delete Button -->
                                <a href="{{ route('users.destroy', $user->id) }}" 
                                   class="btn btn-danger mx-1" 
                                   data-confirm-delete="true">
                                    <i class="fas fa-trash"></i>
                                </a>
                                </div>

                                <!-- Reset Password -->
                                <x-user.reset-password :id="$user->id" class="mx-1"/>
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
