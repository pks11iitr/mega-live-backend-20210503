@extends('layouts.admin')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Customer Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">

                                <thead>
                                <th>Value</th>
                                <th>Details</th>
                                </thead>
                                    <tbody>
                                    <tr>
                                    <th>Name</th>
                                    <td>{{$customers->name}}</td>
                                   </tr>
                                    <tr>
                                    <th>Mobile</th>
                                    <td>{{$customers->mobile}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{$customers->email}}</td>
                                    </tr>
                                    <tr>
                                    <th>Gender</th>
                                    <td>{{$customers->gender}}</td>
                                    </tr>
                                    <tr>
                                    <th>DOB</th>
                                    <td>{{$customers->dob}}</td>
                                    </tr>
                                    <tr>
                                    <th>Height</th>
                                    <td>{{$customers->height->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Profile Picture</th>
                                        <td><img src="{{$customers->image}}" height="80px" width="80px"/></td>
                                    </tr>
                                    <tr>
                                        <th>Ethnicity</th>
                                        <td>{{$customers->ethnicity->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Kids</th>
                                        <td>{{$customers->kids->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Family</th>
                                        <td>{{$customers->family->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Work</th>
                                        <td>{{$customers->work->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Job</th>
                                        <td>{{$customers->job->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>AttendedLavel</th>
                                        <td>{{$customers->attended_lavel->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Religion</th>
                                        <td>{{$customers->religion->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Politics</th>
                                        <td>{{$customers->politics->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Education</th>
                                        <td>{{$customers->education->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Drinking</th>
                                        <td>{{$customers->drinking??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Smoking</th>
                                        <td>{{$customers->smoking??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Marijuana</th>
                                        <td>{{$customers->marijuana??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Drugs</th>
                                        <td>{{$customers->drugs??''}}</td>
                                    </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <!-- /.content -->

    </div>
    <!-- ./wrapper -->
@endsection

