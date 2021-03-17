@extends('layouts.app')
@section('content')
    

    <div class="album py-5 bg-light">
      <div class="container">

        <div class="row">
        <!-- foreach post -->
        @foreach ($posts as $post)
            
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
            <!-- post image -->
              <img class="card-img-top" src="{{asset('/images/'.$post->image_path)}}" alt="Card image cap" style="height: 250px">
              <div class="card-body" style="height:  116px;">
                <!-- post body -->
                <p class="card-text" style="text-align: right;direction:  rtl;">{{str_limit($post->body,80)}}</p>
                <br>
              </div>
              <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                <!-- post actions -->
                  <form action="{{action('PostController@destroy',$post->id)}}" method="post">
                    <div class="btn-group">
                      <a class="btn btn-sm btn-outline-info" href="{{action('PostController@show',$post->id)}}">عرض</a>
                      <a class="btn btn-sm btn-outline-success" href="{{action('PostController@edit',$post->id)}}">تعديل</a>
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-sm btn-outline-danger" >حذف</button>
                    </div>
                  </form>
                  <!-- post date -->
                  <small class="text-muted">{{$post->created_at}}</small>
                </div>
              </div>
            </div>
          </div>
        @endforeach

          <!-- foreach post end -->
        </div>
        <!-- Paginations -->
      </div>
    </div>
 
@endsection