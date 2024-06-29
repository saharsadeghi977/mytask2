<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    <div style="display: flex">
      <div
        style="
          height: 100vh;
          width: 300px;
          background-color: #428bca;
          color: white;
        "
      >

        @include('back.message')
        <div class="container" style="margin-top: 170x" id="sidebar">
          <div class="panel panel-primary">

            <div class="panel-heading">ویرایش محصول</div>


            <div class="panel-body">
              <form action="{{route('admin.products.update')->$product->id}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="title">عنوان محصول </label>
                  <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title"  name="title"  value="{{$product->title}}" />
                </div>
                <div class="form-group">
                  <label for="price">قیمت</label>
                  <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"  name="price"  value="{{$product->price}}"  />
                </div>
                <div class="form-group">
                    <label for="title">انتخاب دسته بندی</label>
                    <div id="output"></div>
                    <select class="chosen-select" name="categories[]" multiple style="width:400px">
                        @foreach ($categories as $cat_id => $cat_name)
                        <option value="{{$cat_id}}" <?php
                        if (
                            in_array($cat_id,$product->categories->pluck('id')->toArray()) )echo 'selected'
                        ?>>{{$cat_name}}</option>
                        @endforeach

                    </select>
                </div>
              <div class="input-group">
                <span class="input-group-btn">
                    <a href="#" id="lfm" data-input="image" data-preview="holder"
                        class="btn btn-primary">
                        <i class="fa fa-picture-o"></i> انتخاب
                    </a>
                </span>
                <input id="image" class="form-control" type="text" name="image" vlue="{{$product->image}}">
            </div>
            <img id="holder" style="margin-top:15px;max-height:100px;" src="{{$product->image}}">
            <hr>
                <div class="form-group">
                  <label for="description">توضیحات</label>
                  <textarea
                  id="editor" type="text"
                  class="form-control @error('description') is-invalid @enderror"
                  name="description">{{$article->description}}
                  ></textarea>
                  @error('description')
                  <div class="alert alert-danger">{{$message}}</div>
                  @enderror
                </div>
                <div class="form-group">

                  <button type="submit" class="btn btn-success">ذخیره</button>
                  <a href="{{route('admin.products')}}" class="btn btn-warning"> انصراف </a>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="../../assets/scripts/jquery-1.10.2.min.js"></script>
    <script src="../../assets/scripts/bootstrap-rtl.js"></script>
  </body>
</html>
