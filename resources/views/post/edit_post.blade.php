<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./assets/img/favicons/favicon.ico">
    <link href="./dist/fonts/fonts.css" rel="stylesheet">

    <title>إضافة منشور جديد</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/css/album.css') }}" rel="stylesheet">
  </head>
  <body>
    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="card mb-8 box-shadow">             
              <img class="card-img-top" src="{{asset('/images/'.$post->image_path)}}" alt="Card image cap">
              <div class="card-body" style="direction: rtl;">
                <form method="POST" action="{{action('PostController@update',$post->id)}}" >
                @csrf
                @method('PATCH')
                  <input type="hidden" name="image_path" value="">
                  <textarea class="form-control" id="post_body" placeholder="" name="body" required>
                    {{$post->body}}
                  </textarea>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group" style="margin-top: 5px;">
                      <button type="submit" class="btn btn-sm btn-outline-secondary">حفظ التعديلات</button>
                    </div>
                    <small class="text-muted"></small>
                  </div>
                  <input name="_method" type="hidden" value="PATCH">
                </form>  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </body>    
</html>    