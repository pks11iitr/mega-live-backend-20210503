@extends('layouts.admin')
@section('content')
  <!-- Content Wrapper. Contains page content -->

{{--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1  /jquery.min.js"></script>--}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
              <li class="breadcrumb-item active">Customers</li>
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
                <h3 class="card-title">Customer Update</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data" action="{{route('customer.update',['id'=>$customers->id])}}">
                 @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" value="{{$customers->name}}">
                      </div>
                    </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Email</label>
                              <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email" value="{{$customers->email}}">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Mobile</label>
                              <input type="number" name="mobile" minlength="10" maxlength="10" class="form-control" id="exampleInputEmail1" placeholder="Enter mobile" value="{{$customers->mobile}}">
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Gender</label>
                              <select class="form-control" name="gender" required>
                                  <option  selected="selected" value="Male" {{$customers->gender=='Male'?'selected':''}}>Male</option>
                                  <option value="Female" {{$customers->gender=='Female'?'selected':''}}>Female</option>

                              </select>
                          </div>
                      </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">DOB</label>
                        <input type="date" name="dob" class="form-control" id="exampleInputEmail1" placeholder="" value="{{date("Y-m-d",strtotime($customers->dob))}}">
                      </div>
                    </div>
                      <div class="col-md-6">

                          <div class="form-group">
                              <label>Height</label>
                              <select class="form-control" name="height_id" required>
                                  <option  selected="selected" value="{{$customers->height_id}}">{{$customers->height->name??''}}</option>
                                  @foreach($height as $h)
                                      <option value="{{$h->id}}">{{$h->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>


                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputFile">Profile picture</label>

{{--                              <input type="file" class="form-control" name="image" id="exampleInputFile" accept="image/*" >--}}
                          </div>
                          <img src="{{$customers->image}}" height="80px" width="80px"/>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Religion</label>
                              <select class="form-control" name="religion_id" required>
                                  <option  selected="selected" value="{{$customers->religion_id}}">{{$customers->religion->name??''}}</option>
                                  @foreach($religion as $re)
                                      <option value="{{$re->id}}">{{$re->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Is Active</label>
                              <select class="form-control" name="isactive" required>
                                  <option  selected="selected" value="1" {{$customers->status==1?'selected':''}}>Active</option>
                                  <option value="0" {{$customers->status==0?'selected':''}}>Inactive</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">About Me</label>
                              <textarea class="form-control" id="w3review" name="about_me" rows="1" cols="120">{{$customers->about_me}} </textarea>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Ethnicity</label>
                              <select class="form-control" name="ethicity_id" required>
                                  <option  selected="selected" value="{{$customers->ethicity_id}}">{{$customers->ethnicity->name??''}}</option>
                                  @foreach($ethnicity as $et)
                                      <option value="{{$et->id}}">{{$et->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                          </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Employment</label>
                              <select class="form-control" name="job_id" required>
                                  <option  selected="selected" value="{{$customers->job_id}}">{{$customers->job->name??''}}</option>
                                  @foreach($employment as $emp)
                                      <option value="{{$emp->id}}">{{$emp->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Occupation</label>
                              <select class="form-control" name="occupation_id" required>
                                  <option  selected="selected" value="{{$customers->occupation_id}}">{{$customers->work->name??''}}</option>
                                  @foreach($occupation as $ocp)
                                      <option value="{{$ocp->id}}">{{$ocp->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Password</label>
                              <input type="text" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter password">
                          </div>

                          <div class="form-group">
                              <label>Education</label>
                              <select class="form-control" name="education_id" required>
                                  <option  selected="selected" value="{{$customers->education_id}}">{{$customers->education->name??''}}</option>
                                  @foreach($education as $edu)
                                      <option value="{{$edu->id}}">{{$edu->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Drinking</label>
                              <select class="form-control" name="drinking" required>
                                  <option  selected="selected" value="1" {{$customers->drinking==1?'selected':''}}>Yes</option>
                                  <option value="0" {{$customers->drinking==0?'selected':''}}>No</option>

                              </select>
                          </div>
                          <div class="form-group">
                              <label>Smoking</label>
                              <select class="form-control" name="smoking" required>
                                  <option  selected="selected" value="1" {{$customers->smoking==1?'selected':''}}>Yes</option>
                                  <option value="0" {{$customers->smoking==0?'selected':''}}>No</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Marijuana</label>
                              <select class="form-control" name="marijuana" required>
                                  <option  selected="selected" value="1" {{$customers->marijuana==1?'selected':''}}>Yes</option>
                                  <option value="0" {{$customers->marijuana==0?'selected':''}}>No</option>

                              </select>
                          </div>

                          <div class="form-group">
                              <label>Drugs</label>
                              <select class="form-control" name="drugs" required>
                                  <option  selected="selected" value="1" {{$customers->drugs==1?'selected':''}}>Yes</option>
                                  <option value="0" {{$customers->drugs==0?'selected':''}}>No</option>

                              </select>
                          </div>

                      </div>

                      <div class="col-md-6">

                          <div class="form-group">
                              <label>Is Distance Show</label>
                              <select class="form-control" name="distance_show" required>
                                  <option  selected="selected" value="1" {{$customers->distance_show==1?'selected':''}}>Yes</option>
                                  <option value="0" {{$customers->distance_show==0?'selected':''}}>No</option>
                              </select>
                          </div>

                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Is Age Show</label>
                              <select class="form-control" name="age_show" required>
                                  <option  selected="selected" value="1" {{$customers->age_show==1?'selected':''}}>Yes</option>
                                  <option value="0" {{$customers->age_show==0?'selected':''}}>No</option>

                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Rate</label>
                              <input type="number" name="rate" class="form-control" id="exampleInputEmail1" placeholder="Enter Rate" value="{{$customers->rate}}">
                          </div>
                          <div class="form-group">
                              <label>Account Type</label>
                              <select class="form-control" name="account_type" required>
                                  <option value="">Please Select</option>
                                  <option value="ADMIN" {{$customers->account_type=='ADMIN'?'selected':''}}>Admin</option>
                                  <option value="USER" {{$customers->account_type=='USER'?'selected':''}}>User</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Country</label>
                              <select class="form-control" name="country" required>
                                  <option  selected="selected" value="{{$customers->country}}">{{$customers->countryName->name??''}}</option>
                                  @foreach($countries as $country)
                                      <option value="{{$country->id}}">{{$country->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Address</label>
                              <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="Enter address" value="{{$customers->address}}">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Plan:-</label> {{$customers->plan->title??''}}
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Membership Expiry:-</label> {{$customers->membership_expiry}}
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Automatic Messages</label> {{$customers->membership_expiry}}
                              <textarea type="text" name="system_messages" class="form-control" id="exampleInputEmail1" placeholder="Enter address" value="{{$customers->system_messages}}">
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
      <!-- /.content -->
      <section class="content">
          <div class="container-fluid">
              <!-- SELECT2 EXAMPLE -->
              <div class="card card-primary">
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
                                      <img src="{{$Image->file_path}}" height="100" width="200"> &nbsp; &nbsp; <a href="{{route('customer.image.delete',['id'=>$Image->id])}}">X</a> &nbsp; &nbsp; &nbsp; &nbsp;

                                      <input type="radio" name="image" value="{{$Image->id}}" {{($Image->file_path==$customers->image)? "checked" : ""}} >
                                      <input type="hidden" id="user_id" value="{{$customers->id}}" >

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
    <!-- /.content -->
      <script>
          $(document).ready(function(){
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              $('input[type="radio"]').click(function(){
                  var id = $(this).val();
                  var user_id = document.getElementById("user_id").value;
                  // alert(id + user_id);
                  $.ajax({
                      "url":"{{  route('customer.image') }}",
                      "method":"POST",
                      "data":{
                          "_token":"{{ csrf_token() }}",
                          "id":id,
                          "user_id":user_id
                      },
                      "success":function(data){
                          location.reload();
                          $('#message').html("<h2>Current image has been updated!</h2>")
                      }
                  });
              });
          });
      </script>
</div>
<!-- ./wrapper -->
@endsection

