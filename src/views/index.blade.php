<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

.flex-container {
    display: flex;
  justify-content: center;
  align-items: center;
  height:100%;
 
  
}
.item{
    display: flex;
  justify-content: center;
  align-items: center;
  width:400px;
  height:200px;
    border: 1px solid #ccc; 
    border-radius:6px;
      padding: 50px;
  margin: 20px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
 
}
    </style>
</head>
<body>
<div class="flex-container">
  

   <div class="item">
  
   <form  action="/ImportExcelFile" method="post" enctype="multipart/form-data">
    @csrf
             <h3>Select CSV File to upload:</h3>
           <input type="file" name="fileToUpload">
            <input type="submit" value="Upload File" name="submit" id="myBtn"><br><br>
            @if($errors->has('fileToUpload'))
            @foreach ($errors->all() as $error)
            <span style="color:#F00; text-align:center;" >
                {{ $error }}
            </span>
            @endforeach
            @endif
            @if(Session::has('message'))
            <p style="color:green; text-align:center;">{{ Session::get('message') }}</p>
            @endif
            @if(Session::has('Alert'))
            <p style="color:#F00; text-align:center;">{{ Session::get('Alert') }}</p>
            @endif
               
           
         
     
 

</form>

</div>
</div>
</body>
</html>