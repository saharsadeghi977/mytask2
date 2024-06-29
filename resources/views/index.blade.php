
<html lang="en">
<link rel="stylesheet" href="{{ url('assets/css/bootstrap-rtl.css') }}">

<head></head>


<body style="background-color:#edd015; direction:ltr">
    <div style="background-color:#fff">
    <h1>users<h2>
    <ul>
        @foreach($users as $user)
        <li><a href="{{route('users.show',$user->id)}}">{{$user->name}}</a><li>
            @endforeach
</ul>
    </div>
</body>


<html>