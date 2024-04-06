@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Followup</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('follow.update', ['id' => $followup->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="">
                                <div class="col-md-6 mb-3">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control border border-dark p-2" value="{{$followup->name}}" name="name">
                                </div>    
                                <div class="col-md-6 mb-3">
                                    <label for="">Phone</label>
                                    <input type="text" class="form-control border border-dark p-2" value="{{$followup->dial_code}}{{$followup->phone}}" name="phone">
                                </div> 
                                   
                                    <div class="btn-group col-md-6 mb-3">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @if ($followup->status == 0)
                                            Pending
                                        @elseif ($followup->status == 1)
                                            Success
                                        @elseif ($followup->status == 2)
                                            No Response
                                        @endif                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                          <button class="dropdown-item" type="button">Pending</button>
                                          <button class="dropdown-item" type="button">Success</button>
                                          <button class="dropdown-item" type="button">No Response</button>
                                        </div>
                                      </div>
                              
                                <div class="col-md-6 mb-3">
                                    <label for="">Follow Date</label>
                                    <input type="text" class="form-control border border-dark p-2" value="{{$followup->follow_date}}" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Follow Address</label>
                                    <input type="text" class="form-control border border-dark p-2" value="{{$followup->address}}" name="phone">
                                </div>
                               
                                <div class="col-md-6 mb-3">
                                   <button type="submit" class="btn btn-primary">Submit</button>
                                </div>       
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endsection
