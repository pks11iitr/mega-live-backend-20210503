@extends('layouts.admin')
@section('content')
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
              <form role="form" method="post" enctype="multipart/form-data" action="{{route('Admincoinadd.update',['id'=>$addcoins->id])}}">
                 @csrf

                 <input type="hidden" name="sender_id" value="1"/>







                 
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Customers</label><br>
                                <select name="receiver_id" class="form-control">
                                    <option value="">--Select Customers--</option>
                                    @foreach($customers as $user)                                      
    <option value="{{$user->id}}" {{$user->id==$addcoins->receiver_id ?'selected':''}}>{{$user->name}} - {{$user->id}}</option>
                                    @endforeach
                                </select>   
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Coins</label>
                            <input type="text" name="coins" class="form-control" value="{{$addcoins->coins}}" id="exampleInputEmail1" placeholder="Enter Coins">
                            </div>
                         </div>

                       
                        <div class="col-md-6">
                           <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control"  name="message" rows="5">{{$addcoins->message}}</textarea>
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

