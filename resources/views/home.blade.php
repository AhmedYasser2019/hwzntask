@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">users</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">last name</th>
                                <th scope="col">email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)

                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>

                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
