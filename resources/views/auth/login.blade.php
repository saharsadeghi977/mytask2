<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

 
  <link rel="stylesheet" href="{{ url('assets/css/bootstrap-rtl.css') }}">
</head>
<body>
    <div class="container ">
        <a href="#" class="list-group-item">
            <h4 style="margin-top :50px  ;" >صفحه اصلی </h4>
            
          </a>
    </div>
    @include('messages')
    <div class="container " style="margin-top:170x"  id="sidebar" >

        <div class="panel panel-primary">
            <div class="panel-heading">حساب کاربری</div>

            
            <div class="panel-body">
                
                <form action="{{route('login')}}" method="POST">
                   @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">ایمیل خود  را وارد کنید </label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email"  placeholder="ایمیل" value="{{old('email')}}">
                      @error('email')
                     <div class="alert alert-danger">{{$message}}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">کلمه عبور</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror"  name="password" placeholder="کلمه عبور">
                      @error('password')
                   <div class="alert alert-danger">{{$message}}</div>
                     @enderror
                    </div>
                  
                    <div class="checkbox">
                      <label>
                      
                        <input type="checkbox"  class="form-check-input" name="remember"> مرا به خاطر بسپار </label>
                        
                      
                    
                    </div>
                    <div class="">
                        <label>
                        
                          <a href="#">فراموشی کلمه عبور</a> 
                          
                        </label>
                      
                      </div>
                    <button type="submit" class="btn btn-success btn-block">ورود به سایت</button>
                  </form>
            </div>
          </div>
</body>


</html>