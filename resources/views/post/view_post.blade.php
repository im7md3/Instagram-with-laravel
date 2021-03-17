@extends('layouts.app')
@section('content')
    
<div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="card mb-8 box-shadow">             
            <div class="card-header" style="background-color:  white;">
               <div class="media text-muted pt-3" style="direction:  rtl;">
                  <img src="{{asset('/images/avatar/'.$post->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-right: -3%; width: 50px;height: 50px;">
                  <div class="media-body pb-3 mb-0" style="text-align: right;direction:  rtl;" >
                    <p class="card-text" style="text-align: right;direction:  rtl;">{{($post->user->name)}}</p>
                  </div>
                </div>
                @if(auth()->id()==$post->user_id)
                <form action="{{action('PostController@destroy',$post->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">حذف</button>
                </form>
                @endif
            </div>  
            <img class="card-img-top" src="{{asset('/images/'.$post->image_path)}}" alt="Card image cap">
            <div class="card-body">
              <p class="card-text" style="text-align: right;direction:  rtl;">{{$post->body}}</p>
              <div class="d-flex justify-content-between align-items-center">

                

                  
                  
                <div class="row">
                    <div class="btn-group" style="margin-top:  4px;">
                      <button class="btn btn-sm btn-outline-secondary" type="button" ><i class="fa fa-heart" style="margin-right:  10%;"></i><label id="count_id">{{$post->likes->count()}}</label></button> 
                      <button class="btn btn-sm btn-outline-danger" id="btn_value_id" onclick="like_action()"> أعجبني </button>
                    </div>
                </div>
              

              

                <small class="text-muted">{{$post->created_at}}</small>
              </div>
            </div>
            <div class="card-footer" style="direction:  rtl;text-align:  right;">
              <div class="media text-muted pt-3">
                <img src="{{asset('/images/avatar/'.auth()->user()->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-top:  1%;margin-right: -3%; width: 50px;height: 75px;">
                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                  <div class="d-flex justify-content-between align-items-center w-100">
                    <strong class="text-gray-dark"></strong>
                  </div>
                  <form action="{{url('comment')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <div class="row">
                      <div class="col-md-10">
                        <input type="text" name="comment" class="form-control" placeholder="أضف تعليقاً" style="width:  100%;">
                      </div>
                      <div class="col-md-2" style="margin-top:  4px;">  
                        <input type="submit" class="btn btn-sm btn-outline-secondary" name="send" value="إضافة التعليق">
                      </div>  
                    </div>
                  </form> 
                </div>
              </div>


              @foreach ($post_comments->comments as $comment)
                <div class="media text-muted pt-3">
                  <img src="{{asset('/images/avatar/'.$comment->user->avatar)}}" alt="" class="col-sm-2 rounded" style="margin-top:  1%;margin-right: -3%; width: 50px;height:75px;">
                  <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" >
                      <div class="d-flex justify-content-between align-items-center w-100">
                          <strong class="text-gray-dark">{{$comment->user->name}}</strong><br>
                          @if (auth()->id()==$comment->user->id)
                              <form action="{{action('CommentController@destroy',$comment->id)}}" method="POST">
                                @csrf
                                @method('Delete')
                                <button class="btn btn-outline-danger">حذف</button>
                              </form>
                          @endif
                      </div>
                      <span class="d-block">{{$comment->comment}}</span>
                  </div>
                </div>
            
              @endforeach


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
  
@section('script')
    
  <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
  <script>
    var like='أعجبني';
    var unlike='إلغاء الإعجاب';
    var token='{{csrf_token()}}';
    var post_id="{{$post->id}}";
    var like_id=0;
    @if($isLiked->count()>0)
      like_id="{{$isLiked[0]->id}}";
      $('#btn_value_id').html(unlike);
    @endif

    function like_action(){
      if(like_id==0){
        $.ajax({
          type:"POST",
          url:'{{url("like")}}',
          data:{post_id:post_id,_token:token},
          success:function(msg){
            $('#count_id').html(msg.count);
            $('#btn_value_id').html(unlike);
            like_id=msg.id;
          }
        })
      }else{
        $.ajax({
          type:"POST",
          url:'{{url("like")}}/'+post_id,
          data:{_method:"DELETE",_token:token},
          success:function(msg){
            $('#count_id').html(msg.count);
            $('#btn_value_id').html(like);
            like_id=0;
          }
        })
      }
    }
  </script>
@endsection
 
