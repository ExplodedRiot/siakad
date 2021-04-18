@extends('layouts.app') 
@section('content') 
<div class="container"> 
 <form action="/articles/{{$article->id}}" method="post" 
enctype="multipart/form-data"> 
 @csrf 
 <div class="form-group"> 
 <label for="title">Title</label> 
 <input type="text" class="form-control" 
required="required" name="title" value="{{$article->title}}"></br> 
 </div> 
 <div class="form-group"> 
 <label for="content">Content</label> 
 <input type="text" class="form-control" 
required="required" name="content" value="{{$article-
>content}}"></br> 
 </div> 
 <div class="form-group"> 
 <label for="image">Image</label> 
 <input type="file" class="form-control" 
required="required" name="image" value="{{$article-
>featured_image}}"></br> 
 <img width="150px" src="{{asset('storage/'.$article-
>featured_image)}}"> 
 </div> 
 <button type="submit" class="btn btn-primary floatright">Update Data</button> 
 </form> 
</div> 
@endsection 