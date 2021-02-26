@if($page==1 || empty($page))
@extends('layouts.caller-admin')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
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

                                        <h3 class="card-title">Chat with {{$receiver->name}}</h3>

                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages" id="chat-box-div">

                                                                            <!-- Message. Default to the left -->
  @endif
                                            <input type="hidden" id="next_page_url" value="{{$next_page_url??''}}">

                                            <a href="javascript:void(0)" onclick="loadprevious()" id="next_page_element">Load Older Chats</a>
                                            @foreach($chats as $chat)
{{--                                                                                              @if($chat->type=='user')--}}
                                            @if($chat['direction']==1)
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-left">{{$chat['name']}}</span>
                                                    <span class="direct-chat-timestamp float-right">{{$chat['created_at']}}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="{{$chat['user_image']}}" alt="message user image">
                                                <!-- /.direct-chat-img -->


                                                <div id="direct" class="direct-chat-text">
                                                    @if($chat['type']=='image'||$chat['type']=='gift')
                                                        <img  src="{{$chat['image']}}" alt="message user image" height="100" width="100">
                                                    @else
                                                        {{$chat['message']}}
                                                    @endif
                                                </div><br>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                                @else
                                            {{--                                                @endif--}}
                                        <!-- /.direct-chat-msg -->

                                            <!-- Message to the right -->
                                            {{--                                                @if($chat->type=='admin')--}}
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-right">{{$chat['name']}}</span>
                                                    <span class="direct-chat-timestamp float-left">{{$chat['created_at']}}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <img class="direct-chat-img" src="{{$chat['user_image']}}" alt="message user image" height="100" width="100">
                                                <!-- /.direct-chat-img -->
                                                <div id="direct" class="direct-chat-text">
                                                    @if($chat['type']=='image'||$chat['type']=='gift')
                                                        <img  src="{{$chat['image']}}" alt="message user image">
                                                    @else
                                                        {{$chat['message']}}
                                                    @endif
                                                </div>
                                                <br>

                                                <!-- /.direct-chat-text -->
                                            </div>
                                            @endif
                                        {{--                                            @endif--}}
                                                                                @endforeach
                                            <input type="hidden" id="recent_chat_ts" value="{{$recent_ts}}">
{{--                                            <a href="javascript:void(0)" onclick="loadrecent()">New Chats</a>--}}
                                        <!-- /.direct-chat-msg -->
@if($page==1 || empty($page))
                                        </div>

                                        <!--/.direct-chat-messages-->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-6">
{{--                                        <form  role="form"  enctype="multipart/form-data" method="post" action="" >--}}
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" id="message" name="message" placeholder="Type message ..." class="form-control">

                                                <span class="input-group-append">

                      <button id="button" class="btn btn-primary" >Send</button>
                    </span>

                                            </div>
                                            <input type="hidden" id="compid" name="compid" placeholder="Type Message ..." class="form-control" value="{{$receiver->id}}">
{{--                                        </form>--}}
                                            </div>
                                            <div class="col-6">
                                        <form  role="form"  enctype="multipart/form-data" method="post" action="" >
                                            @csrf
                                            <div class="input-group">

                                                <input type="file" id="image" name="image"  id="exampleInputFile" class="form-control" accept="image/*" onchange="readURL(this);">
                                                <span class="input-group-append">

                      <button type="submit" id="buttonimage" class="btn btn-primary" >Send</button>
                    </span>

                                            </div>
                                            <input type="hidden" id="compid" name="compid" placeholder="Type Message ..." class="form-control" value="{{$receiver->id}}"><br>


                                            {{--                                            <img id="blah" src="#" height="100" width="100"><br>--}}

                                        </form>
                                            </div>
                                        </div>
                                    </div>

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

            $('#message').keypress(function(event){

                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){

                    event.preventDefault();

                    var des = $("#message").val();

                    if(des=='')
                        return


                    var url = '{{route('caller.send.chat', ['id'=>$receiver->id])}}';
                    formdata = new FormData();
                    formdata.append('message',des);
                    formdata.append('type','text');
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
                }
            });

            $("#button").click(function(e){

                e.preventDefault();

                var des = $("#message").val();

                if(des=='')
                    return

                //var compid = $("#compid").val();

                var url = '{{route('caller.send.chat', ['id'=>$receiver->id])}}';
                formdata = new FormData();
                formdata.append('message',des);
                formdata.append('type','text');
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

            $("#buttonimage").click(function(e){

                e.preventDefault();

                var compid = $("#compid").val();
                var url = '{{route('caller.send.chat', ['id'=>$receiver->id])}}';
                formdata = new FormData();
                var files = $("#image")[0].files[0];
                formdata.append('image',files);
                formdata.append('type','image');
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

            function loadprevious(){

                //alert($("#next_page_url").val())


                if($("#next_page_url").val()==''){
                    $("#next_page_url").remove()
                    $("#next_page_element").remove()
                    return
                }

                $.ajax({
                    url:$("#next_page_url").val(),
                    method:'get',
                    success:function(data){
                        $("#next_page_url").remove()
                        $("#next_page_element").remove()
                        $("#chat-box-div").prepend(data)

                    }
                })

            }

            setInterval(function loadrecent(){

                $.ajax({
                    url:'{{route('caller.customer.recent-chat', ['id'=>$receiver->id])}}'+'?recent_ts='+$("#recent_chat_ts").val(),
                    method:'get',
                    success:function(data){
                        $("#recent_chat_ts").remove()
                        $("#chat-box-div").append(data)
                        $('#chat-box-div').scrollTop($('#chat-box-div')[0].scrollHeight);
                    }
                })

            }, 10000);


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);

                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(document).ready(function(){

                $('#chat-box-div').scrollTop($('#chat-box-div')[0].scrollHeight);

            })

        </script>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
@endsection

@endif
