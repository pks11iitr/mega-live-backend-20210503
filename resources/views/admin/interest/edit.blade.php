@extends('layouts.admin')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Interest</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Interest</li>
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
                <h3 class="card-title">Interest Update</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data" action="{{route('interest.update',['id'=>$interest->id])}}">
                 @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name" value="{{$interest->name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" name="image" class="form-control" id="exampleInputFile" value="{{request('image')}}" accept="image/*">
                            </div>
                            <img src="{{$interest->image}}" height="100" width="200">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Is Active</label>
                                <select class="form-control" name="isactive" required>
                                   <option  selected="selected" value="1" {{$interest->isactive==1?'selected':''}}>Yes</option>
                                    <option value="0" {{$interest->isactive==0?'selected':''}}>No</option>
                                </select>
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
      </div>
    </section>
</div>
<!-- ./wrapper -->
@endsection

