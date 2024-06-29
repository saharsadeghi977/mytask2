<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

      <link rel="stylesheet" href="{{ url('assets/css/bootstrap-rtl.css') }}">
  </head>
  <body>
    {{-- @include('back.sidebar') --}}

       @include('messages')
       @if(Auth::user())
       <a  href="{{route('posts.create')}}" class="btn btn-primary">ایجاد پست</a>
       @endif
    <div class="container" style="margin-top: 170x" id="sidebar">
        <div class="panel panel-primary">
            <div class="panel-heading">پست ها</div>
            <div class="panel-body">
                <table style="width:100%;">
                    <thead>
                    <tr style="padding-block: 10px;border-bottom: 1px solid black;">
                        <td style="padding-block: 10px;text-align: center;">نام</td>

                        <td style="padding-block: 10px;text-align: center;">نوع</td>
                        <td style="padding-block: 10px;text-align: center;">تصویر</td>
                        <td style="padding-block: 10px;text-align: center;">توضیحات</td>

                    </tr>
                    </thead>
                    <tbody>
                      
                    @foreach ($posts as $post)

                        <tr style="padding-block: 10px;border-bottom: 1px solid rgb(196, 196, 196);">

                            <td style="padding-block: 10px;text-align: center;">{{$post->name}}</td>
                            <td style="padding-block: 10px;text-align: center;">{{$post->type}}</td>
                            <td style="padding-block: 10px;text-align: center;">
                                @foreach($post->files as $file)
                                    <img src="{{asset('storage/'.$file->path)}}">
                                @endforeach
                            </td>
                           
                            <td style="padding-block: 10px;text-align: center;">{{$post->description}}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
