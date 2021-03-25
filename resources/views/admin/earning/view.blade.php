@extends('layouts.admin')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Earning</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Earning</li>
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
                                    <div class="col-12">
                                        <form class="form-validate form-horizontal"  method="get" action="" enctype="multipart/form-data">
                                            <div class="row">
                                                                                                                                        <div class="col-3">
                                                                                                                                            <select name="user_id" class="form-control" >
                                                                                                                                                <option value="" {{ request('user_id')==''?'selected':''}}>Select Customer Name</option>
                                                                                                                                                @foreach($customers as $customer)
                                                                                                                                                    <option value="{{$customer->id}}" {{request('user_id')==$customer->id?'selected':''}}>{{ $customer->name }}</option>
                                                                                                                                                @endforeach
                                                                                                                                            </select>
                                                                                                                                        </div>
                                                <div class="col-3">
                                                    <input   class="form-control" name="fromdate" placeholder=" search name" value="{{request('fromdate')}}"  type="date" />
                                                </div>
                                                <div class="col-3">
                                                    <input  class="form-control" name="todate" placeholder=" search name" value="{{request('todate')}}"  type="date" />
                                                </div>
                                                <div class="col-3">
                                                    <button type="submit" name="save" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Count</th>
                                        <th>Coins</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($earnings as $earning)
                                        <tr>
                                            <td>{{$earning->customer->name??''}}</td>
                                            <td>{{$earning->date}}</td>
                                            <td>{{$earning->type}}</td>
                                            <td>{{$earning->count}}</td>
                                            <td style="color: #FF7F50;">
                                                {{$earning->coins}} coins</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$earnings->appends(request()->query())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- ./wrapper -->
@endsection


