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
                        <h1>Payment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Payment</li>
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
{{--                                                <div class="col-4">--}}
{{--                                                    <input  class="form-control" name="search" placeholder=" search customer name" value="{{request('search')}}"  type="text" />--}}
{{--                                                </div><br><br>--}}
                                                <div class="col-4">
                                                    <input   class="form-control" name="fromdate" placeholder=" search name" value="{{request('fromdate')}}"  type="date" />
                                                </div>
                                                <div class="col-4">
                                                    <input  class="form-control" name="todate" placeholder=" search name" value="{{request('todate')}}"  type="date" />
                                                </div>
                                                <div class="col-4">
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
                                        <th>RefID</th>
                                        <th>Customer Name</th>
                                        <th>Amount</th>
                                        <th>Date & Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{$payment->refid}}</td>
                                            <td>{{$payment->customer->name??''}}</td>
                                            <td>{{$payment->amount}}</td>
                                            <td>{{$payment->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
{{--                        {{$payments->appends(request()->query())->links()}}--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- ./wrapper -->
@endsection


