                                            <input type="hidden" id="next_page_url" value="{{$next_page_url??''}}">

                                            <a href="javascript:void(0)" onclick="loadPrevious()" id="next_page_element">Load Older Chats</a>
                                            @foreach($chats as $chat)
                                                {{--                                                                                            @if($chat->type=='user')--}}
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
                                                        @if($chat['image'])
                                                            <img  src="{{$chat['image']}}" alt="message user image">
                                                    @endif
                                                    <!-- /.direct-chat-text -->
                                                    </div>
                                                @endif
                                                {{--                                            @endif--}}
                                            @endforeach
                                        <!-- /.direct-chat-msg -->
