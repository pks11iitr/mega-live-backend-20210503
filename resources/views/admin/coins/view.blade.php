@extends('layouts.admin')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coins </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
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
                       <a href="{{route('coins.create')}}" class="btn btn-primary">Add Coins</a>                    </div>
               </div>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Coins</th>
                   <th>Price</th>
                    <th>Isactive</th>
                   <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				@foreach($coins as $coin)
                  <tr>
					  <td>{{$coin->coin}}</td>
                      <td>{{$coin->price}}</td>
                      <td>
                        @if($coin->isactive==1){{'Yes'}}
                             @else{{'No'}}
                             @endif
                      </td>
                      <td>
                          <a href="{{route('coins.edit',['id'=>$coin->id])}}" class="btn btn-success">Edit</a>
                      </td>
                 </tr>
                 @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                      <th>Coins</th>
                      <th>Price</th>
                      <th>Isactive</th>
                      <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            {{$coins->appends(request()->query())->links()}}
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </section>
</div>
<!-- ./wrapper -->
@endsection

