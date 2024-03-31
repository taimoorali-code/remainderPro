@extends('layouts.admin')

@section('content')
    <style>
        .btn-custom {
            color: black;
            font-weight: bold;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h4>Update Categories</h4>
        </div>
        <div class="card-body">
            <div class="row justify-content-end mb-1">
                <div class="col-auto">
                    <button type="button" class="btn btn-danger">Export</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-warning">Filter</button>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-6 text-right">
                        <h6 style="margin-bottom: 10px;">Date: {{ $category->created_at->format('Y-m-d') }}</h6>
                        <h6 style="margin-bottom: 10px;">Name: {{ $category->name }}</h6>
                        <h6 style="margin-bottom: 10px;">Email: {{ $category->email }}</h6>
                    </div>
                    <div class="col-6 text-left">
                        <h6 style="margin-bottom: 10px;">Country: {{ $category->country }}</h6>
                        <h6 style="margin-bottom: 10px;">Mobile: {{ $category->dial_code }} {{ $category->phone }}</h6>
                    </div>
                </div>
            </div>

            <div class="container mt-3">
                <div class="row justify-content-center mb-1">
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" id="dashboardBtn">Dashboard</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-warning" id="doneDeleteBtn">Done/Delete</button>
                    </div>
                </div>
            </div>


            <div class="container mt-3">
                <!-- Display category data -->
                {{-- <h6 style="margin-bottom: 10px;">Date: {{ $category->created_at->format('Y-m-d') }}</h6> --}}

                <!-- Cards to be shown/hidden -->
                <div class="row justify-content-center">
                    <div class="col-md-7" id="dashboardCard" style="display: none;">
                        @foreach ($user_followups as $followup)
                            <div class="card shadow-sm rounded mt-2">
                                <div class="card-body">
                                    <h6 class="card-title">FollowUp Date: {{ $followup['follow_date'] }}</h6>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>Name: {{ $followup['name'] }}</p>
                                            <p>Phone: {{ $followup['dial_code'] }}{{ $followup['phone'] }}</p>
                                            <p>Status: Pending</p>
                                            <p style="color: black;
                                            font-weight: bold;">Create Date: {{ $followup['created_at'] }}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <p>Address: {{ $followup['address'] }}</p>
                                            {{-- <p>Phone: {{ $followup['phone'] }}</p> --}}
                                        </div>
                                    </div>

                                    <!-- Add other attributes you want to display -->
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-7" id="doneDeleteCard" style="display: none;">
                        @foreach ($done_followups as $followup)
                            <div class="card shadow-sm rounded mt-2">
                                <div class="card-body">
                                    <h6 class="card-title">FollowUp Date: {{ $followup['follow_date'] }}</h6>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>Name: {{ $followup['name'] }}</p>
                                            <p>Phone: {{ $followup['dial_code'] }}{{ $followup['phone'] }}</p>
                                            <p>Status: Completed</p>
                                            <p style="color: black;
                                            font-weight: bold;">Create Date: {{ $followup['created_at'] }}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <p>Address: {{ $followup['address'] }}</p>
                                            {{-- <p>Phone: {{ $followup['phone'] }}</p> --}}
                                        </div>
                                    </div>

                                    <!-- Add other attributes you want to display -->
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>


            <script>
                document.getElementById('dashboardBtn').addEventListener('click', function() {
                    document.getElementById('dashboardCard').style.display = 'block';
                    document.getElementById('doneDeleteCard').style.display = 'none';
                });

                document.getElementById('doneDeleteBtn').addEventListener('click', function() {
                    document.getElementById('dashboardCard').style.display = 'none';
                    document.getElementById('doneDeleteCard').style.display = 'block';
                });
            </script>
        @endsection
