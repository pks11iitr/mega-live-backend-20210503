@extends('layouts.admin')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer Add</li>
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
                <h3 class="card-title">Customer Add</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data" action="{{route('customer.store')}}">
                 @csrf
                <div class="card-body">
                    <div class="row">
                   <div class="col-md-6">
					<div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name" required>
                  </div>
					<div class="form-group">
                   <label for="exampleInputEmail1">Mobile</label><br>
                        <input type="number" minlength="10" maxlength="10" name="mobile" class="form-control" id="exampleInputEmail1" placeholder="Enter mobile" required>
                  </div>
                   </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender" required>
                                    <option value="">Please Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">DOB</label>
                                <input type="date" name="dob" class="form-control" id="exampleInputEmail1" placeholder="Enter DOB">
                            </div>
                            <div class="form-group">
                                <label>Height</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    @foreach($height as $h)
                                    <option value="{{$h->id}}">{{$h->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>About Me</label>
                                <textarea class="form-control" id="w3review" name="about_me" rows="1" cols="120"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Profile picture</label>

                                <input type="file" class="form-control" name="image" id="exampleInputFile" accept="image/*"  required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Religion</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    @foreach($religion as $re)
                                        <option value="{{$re->id}}">{{$re->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                   <div class="form-group">
                        <label>Is Active</label>
                        <select class="form-control" name="isactive" required>
                           <option value="1">Yes</option>
                           <option value="0">No</option>
                        </select>
                    </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ethnicity</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    @foreach($ethnicity as $et)
                                        <option value="{{$et->id}}">{{$et->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Occupation</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    @foreach($occupation as $ocp)
                                        <option value="{{$ocp->id}}">{{$ocp->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employment</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    @foreach($employment as $emp)
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Education</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    @foreach($education as $edu)
                                        <option value="{{$edu->id}}">{{$edu->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Drinking</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Smoking</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marijuana</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Is Age Show</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>

                                </select>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Drugs</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Is Distance Show</label>
                                <select class="form-control" name="height" required>
                                    <option value="">Please Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>

                                </select>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter password">
                            </div>

                        </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
@endsection

