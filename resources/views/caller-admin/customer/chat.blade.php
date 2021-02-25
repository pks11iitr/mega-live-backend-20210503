@extends('layouts.caller-admin')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Chats</h1>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="card direct-chat direct-chat-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Direct Chat</h3>

                                        <div class="card-tools">
                                            <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                                                    data-widget="chat-pane-toggle">
                                                <i class="fas fa-comments"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages">
                                            <!-- Message. Default to the left -->
                                                                                        @foreach($chats as $chat)
{{--                                                                                            @if($chat->type=='user')--}}
                                            @if($chat->direction==1)
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-left">user</span>
                                                    <span class="direct-chat-timestamp float-right">{{$chat->created_at}}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="{{asset('admin-theme/img/user1-128x128.jpg')}}" alt="message user image">
                                                <!-- /.direct-chat-img -->


                                                <div id="direct" class="direct-chat-text">
                                                    {{$chat->message}}
                                                </div><br>
                                                @if($chat->image)
                                                    <img  src="{{$chat->image}}" alt="message user image">
@endif
                                                <!-- /.direct-chat-text -->
                                            </div>
                                                @else
                                            {{--                                                @endif--}}
                                        <!-- /.direct-chat-msg -->

                                            <!-- Message to the right -->
                                            {{--                                                @if($chat->type=='admin')--}}
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-right">matchon</span>
                                                    <span class="direct-chat-timestamp float-left">{{$chat->created_at}}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="{{asset('admin-theme/img/user1-128x128.jpg')}}" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div id="direct" class="direct-chat-text">
                                                    {{$chat->message}}
                                                </div>
                                                <br>
                                                     @if($chat->image)
                                                <img  src="{{$chat->image}}" alt="message user image">
                                            @endif
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            @endif
                                        {{--                                            @endif--}}
                                                                                @endforeach
                                        <!-- /.direct-chat-msg -->

                                        </div>
                                        <!--/.direct-chat-messages-->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <form  role="form"  enctype="multipart/form-data" method="post" action="" >
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" id="message" name="message" placeholder="Type message ..." class="form-control">
                                                <input type="file" id="image" name="image"  id="exampleInputFile" class="form-control" accept="image/*" onchange="readURL(this);">
                                                <span class="input-group-append">

                      <button type="submit" id="button" class="btn btn-primary" >Send</button>
                    </span>

                                            </div>
                                            <input type="hidden" id="compid" name="compid" placeholder="Type Message ..." class="form-control" value="{{$id}}"><br>


                                            <img id="blah" src="#" height="100" width="100"><br>
                                            <b>Image Size (500px * 500px)</b>
                                        </form>
                                    </div>
                                    <!-- /.card-footer-->
                                </div>
                                <!--/.direct-chat -->
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

        <script type="text/javascript">


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $("#button").click(function(e){

                e.preventDefault();

                var des = $("#message").val();
                var compid = $("#compid").val();

                var url = '{{route('caller.send.chat')}}';
                formdata = new FormData();
                var files = $("#image")[0].files[0];
                formdata.append('image',files);
                formdata.append('message',des);
                formdata.append('compid',compid);
                formdata.append('_token',"{{ csrf_token() }}");

                $.ajax({
                    url:url,
                    method:'POST',
                    data:formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(response){
                        location.reload();
                        if(response.success){

                            //   alert(response.message) //Message come from controller
                        }else{
                         //   alert("Error")
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            });
        </script>
        <script type="text/javascript">
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>


    {{-- </script>
     <script type="text/javascript">


         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         $("#button").click(function(e){

             e.preventDefault();

             var des = $("#message").val();
             alert(des)
             var url = '{{route('caller.send.chat')}}';

             $.ajax({
                 url:url,
                 method:'POST',
                 data:{
                     message:des,
                 },
                 success:function(response){
                     if(response.success){
                         alert(response.message) //Message come from controller
                     }else{
                         alert("Error")
                     }
                 },
                 error:function(error){
                     console.log(error)
                 }
             });
         });

         function verifySubmit(){

                 var compid = 2;

                 var des = $("#message").val();

                 $.post('{{route('caller.send.chat')}}', {compid:compid, _token:'{{csrf_token()}}', message:des}, function(data){
                     alert('Message has been sent successfully')
                 })

                 window.location.reload();
                 // console.log(data);
             }
         </script>--}}

    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
@endsection

