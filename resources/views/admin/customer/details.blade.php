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
                                <div class="row">
                                <div class="col-md-6">
                                <table id="example2" class="table table-bordered table-hover">

                                <thead>
                                <th>Key</th>
                                <th>Value</th>
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
                                        <td>@if(!empty($customers->image))<img src="{{$customers->image}}" height="80px" width="80px"/>@endif</td>
                                    </tr>

                                    <tr>
                                        <th>Religion</th>
                                        <td>{{$customers->religion->name??''}}</td>
                                    </tr>


                                    </tbody>

                                </table>
                            </div>
                                <div class="col-md-6">
                                    <table id="example2" class="table table-bordered table-hover">

                                        <thead>
                                        <th>Key</th>
                                        <th>Value</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th>Ethnicity</th>
                                            <td>{{$customers->ethnicity->name??''}}</td>
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
                                            <th>Education</th>
                                            <td>{{$customers->education->name??''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Drinking</th>
                                            <td>@if($customers->drinking==1){{'Yes'}}@else{{'NO'}}@endif</td>
                                        </tr>
                                        <tr>
                                            <th>Smoking</th>
                                            <td>@if($customers->smoking==1){{'Yes'}}@else{{'NO'}}@endif</td>
                                        </tr>
                                        <tr>
                                            <th>Marijuana</th>
                                            <td>@if($customers->marijuana==1){{'Yes'}}@else{{'NO'}}@endif</td>
                                        </tr>
                                        <tr>
                                            <th>Drugs</th>
                                            <td>@if($customers->drugs==1){{'Yes'}}@else{{'NO'}}@endif</td>
                                        </tr>
                                        <tr>
                                            <th>About</th>
                                            <td>{{$customers->about_me}}</td>
                                        </tr>

                                        </tbody>

                                    </table>
                                </div>
                                </div>

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
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Customer Images Add</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{route('customer.images.uploads',['id'=>$customers->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Customer Image</label>
                                        <input type="file" class="form-control" name="images[]" id="exampleInputEmail1" placeholder="Select image" multiple>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary btn-sm">Add</button>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="row">
                                <!-- /.col -->
                                @foreach($customers->gallery as $Image)
                                    <div class="form-group">
                                        <img src="{{$Image->file_path}}" height="100" width="200"> &nbsp; &nbsp; <a href="{{route('customer.image.delete',['id'=>$Image->id])}}">X</a>
                                        &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;          &nbsp; &nbsp; &nbsp; &nbsp;
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.row -->
                    </form>
                </div>
            </div>
        </section>
    </div>
    <!-- ./wrapper -->
@endsection

