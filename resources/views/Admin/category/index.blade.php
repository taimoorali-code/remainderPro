@extends('layouts.admin')



@section('content')
<style>
    .row.justify-content-end > .col-auto {
        margin-right: 30px;
    }

    @media (max-width: 768px) {
        .row.justify-content-end > .col-auto {
            margin-right: 0; /* Reset margin for small screens */
            margin-bottom: 10px; /* Add margin-bottom for spacing */
        }
    }
</style>

   <div class="card">
    <div class="card-header">
        <h4 class="row justify-content-center">User</h4>
    </div>
    <div class="row justify-content-end mb-3">
        <div class="col-auto">
            <button type="button" class="btn btn-success">Add User</button>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger">Export</button>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-warning">Filter</button>
        </div>
    </div>
    
    <div class="card-body table-responsive">
        <table class="table table-striped table-fixed table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th >Name</th>
                    <th >Email</th>
                    <th>Country</th>
                    <th>Mobile</th>
                    {{-- <th>Status</th> --}}
                    <th>Edit</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($category as $item)    
                <tr>
                    <td >{{$item->created_at}}</td>
                    <td >{{$item->name}}</td>
                    <td >{{$item->email}}</td>
                    <td >{{$item->country}}</td>
                    <td >{{$item->phone}}</td>
                    {{-- <td >{{$item->phone}}</td> --}}


                    {{-- <td class="col-md-3 ">
                        <img src="{{asset('upload/category/'.$item->image)}}" class="w-50 "  style="height: 100px !important" alt="Image Not Found">
                    </td> --}}
                    <td>
                        <a class="btn btn-primary" href="{{url('edit-category/'.$item->id)}}">Edit</a>
                        {{-- <a  class="btn btn-danger" href="{{url('delete-category/'.$item->id)}}">Delete</a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   </div>
@endsection