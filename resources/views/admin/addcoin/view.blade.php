@extends('layouts.admin')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

				 <div class="row">
                     <div class="col-3">
                         <a href="{{route('Admincoinadd.create')}}" class="btn btn-primary">Add Coins</a> </div>
                     <div class="col-9">                         
                </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>SenderiD</th>
                    <th>Reciver Name</th>
                    <th>Message</th>
                    <th>Coins</th> 
                   <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				@foreach($addcoins as $addcoin)
                  <tr>
					  <td>{{$addcoin->sender_id}}</td>
					  <td>{{$addcoin->recivecoins->name ?? ''}}</td>
					  <td>{{$addcoin->message}}</td> 
                      <td>{{$addcoin->coins}}</td>
                      <td><a href="{{route('Admincoinadd.edit',['id'=>$addcoin->id])}}" class="btn btn-warning">Edit</a></td> 
                  </tr>
                 @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>SenderiD</th>
                    <th>Reciver Name</th>
                    <th>Message</th>
                    <th>Coins</th> 
                   <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              {{$addcoins->links()}}
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div> 
 
@endsection

