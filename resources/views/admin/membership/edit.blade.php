@extends('layouts.admin')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>MemberShip Update</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Membership Update</li>
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
                <h3 class="card-title">MemberShip Update</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data" action="{{route('membership.update',['id'=>$membership->id])}}">
                 @csrf
                <div class="card-body">
					<div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="Enter title" value="{{$membership->title}}">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                      <input type="text" name="description" class="form-control" id="exampleInputEmail1" placeholder="Enter description" value="{{$membership->description}}">
                  </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Price</label><br>
                        <input type="number"min="0" name="price" class="form-control" id="exampleInputEmail1"  value="{{$membership->price}}" placeholder="Enter Price">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Validity Days</label><br>
                        <input type="number" min="0" name="validity_days" class="form-control" id="exampleInputEmail1" value="{{$membership->validity_days}}" placeholder="Enter validity Days">
                    </div>
                    <div class="form-group">
                        <label>Is Active</label>
                        <select class="form-control" name="isactive" required>
                           <option  selected="selected" value="1" {{$membership->isactive==1?'selected':''}}>Yes</option>
                            <option value="0" {{$membership->isactive==0?'selected':''}}>No</option>
                        </select>
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

