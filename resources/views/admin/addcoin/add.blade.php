@extends('layouts.admin')
@section('content')
<<<<<<< HEAD

<style>
    .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 39px !important;
    user-select: none;
    -webkit-user-select: none;
}
</style>
=======
>>>>>>> 407cc086e51af3b64f372c82c1b72c33b8c686f1
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Coins</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coins</li>
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
                <h3 class="card-title">Coins Add To User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data" action="{{route('Admincoinadd.store')}}">
                 @csrf
                 <input type="hidden" name="sender_id" value="1"/>                 
<<<<<<< HEAD
                 
                 
                 
                 
=======
>>>>>>> 407cc086e51af3b64f372c82c1b72c33b8c686f1
                   <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Customers</label><br>
<<<<<<< HEAD
                                <select name="receiver_id" class="form-control select2">
                                    <option value="">--Select Customers--</option>
                                    @foreach($customers as $user)
                                    <option value="{{$user->id}}">{{$user->name}} - {{$user->regno ?? ''}}</option>
=======
                                <select name="receiver_id" class="form-control">
                                    <option value="">--Select Customers--</option>
                                    @foreach($customers as $user)
                                    <option value="{{$user->id}}">{{$user->name}} - {{$user->id}}</option>
>>>>>>> 407cc086e51af3b64f372c82c1b72c33b8c686f1
                                    @endforeach
                                </select>   
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Coins</label>
                            <input type="text" name="coins" class="form-control" id="exampleInputEmail1" placeholder="Enter Coins">
                            </div>
                         </div>

                       
                        <div class="col-md-6">
                           <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" name="message" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add</button>
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

