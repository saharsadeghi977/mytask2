<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="{{ url('assets/css/bootstrap-rtl.css') }}">
</head>
<body>

@include('messages')


    <div class="container ">
        <a href="#" class="list-group-item">
            <h4 style="margin-top :50px  ;" >صفحه اصلی </h4>
            
          </a>
    </div>
    <div class="container " style="margin-top:170x"  id="sidebar" >

        <div class="panel panel-primary">
            <div class="panel-heading">ثبت نام در سایت </div>
            <div class="panel-body">
          
                <form action="{{route('register')}}" method="POST">
                  
                   @csrf
               <div style="display: flex; align-items: center;">
               <div class="form-group" style="flex: 0 0 50%">
                      <label for="exampleInputname">نام و نام خانوادگی</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleInputname"  placeholder="نام و نام خانوادگی  " value="{{old('name')}}">
                      @error('name')
                   <div class="alert alert-danger">{{$message}}</div>
                    
                   @enderror

                    </div>
                    <div class="form-group" style="flex: 0 0 50%" >
                      <label for="exampleInputEmail1">ایمیل</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="ایمیل " value="{{old('email')}}">
                      @error('email')
                   <div class="alert alert-danger">{{$message}}</div>
                    
                   @enderror

                    </div>
               </div>
                    <div class="form-group">
               <label for="exampleInputpassword">رمز عبور را وارد کنید</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputpassword" placeholder="رمز عبور">
                @error('password')
              <div class="alert alert-danger">{{ $message }}</div>
                 @enderror
                    </div>

               <div class="form-group">
              <label for="exampleInputpassword2">تکرار رمز عبور</label>
             <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="exampleInputpassword2" placeholder="تکرار رمز عبور">
              @error('password_confirmation')
              <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  </div>
                    
                  
                    <div class="checkbox">
                      <label>
                      
                        <input type="checkbox" name="low"> شرایط و قوانین را می پذیرم
                        
                      </label>
                    
                    </div>
                    <button type="submit" class="btn btn-success btn-block"> ثبت نام</button>
                    <!-- login must be a url -->
                  </form>
                  <div>
                  <a href="{{route('login')}}"><button type="submit" class="btn btn-success btn-block">ورود به سایت</button></a>
</div>
            </div>
          </div>
</body>


</html>