<!DOCTYPE html> 
<html> 
<head> 
 <title>Create PDF Report with DOMPDF Laravel</title> 
</head> 
<body> 
 <style type="text/css"> 
 table tr td, 
 table tr th{ 
 font-size: 9pt; 
 } 
 </style> 
 <center> 
 <h5>Articles Report</h4> 
 </center> 
 
 <table class='table table-bordered'> 
 <thead> 
 <tr> 
 <th>Title</th> 
 <th>Content</th> 
 <th>Featured Image</th> 
 </tr> 
 </thead> 
 <tbody> 
 @foreach($articles as $a) 
 <tr> 
 <td>{{$a->title}}</td> 
 <td>{{$a->content}}</td> 
 <td>{{img width="100px" src="{{ storage_path('app/public/'.$a->featured_image}}"</td> 
 </tr> 
 @endforeach 
 </tbody> 
 </table> 
 
</body> 
</html> 