<!DOCTYPE html>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>Title of the document</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
  @include('modal.edit')
    <section class="section">
      <div class="row">
        <div class="col-lg-12">


        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add user details</h5>

              <!-- General Form Elements -->
              <form id="store_form_data"  enctype="multipart/form-data">
                    
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Name:</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="name" name="name" placeholder="enter name" required>
                  </div> 
                  
                  <label for="inputNumber" class="col-sm-2 col-form-label">Image:</label>
                  <div class="col-sm-12">
                    <input type="file" id="file" class="form-control" name="name" required>
                  </div>  

                  <label for="inputNumber" class="col-sm-2 col-form-label">Address:</label>
                  <div class="col-sm-12">
                  <textarea class="ckeditor form-control" id="address"  name="address"></textarea> 
                  <!-- <input type="text" class="form-control" id="address" name="address" placeholder="enter address"> -->
                    </div>  

                  <label for="inputNumber" class="col-sm-2 col-form-label">Gender:</label>
                  <div class="col-sm-12">
                    <select class="form-control" name="gender" id="gender" required>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>                   
                  </div>  
                </div>

                <div class="col-12">                
                    <button type="button" onclick="store()" class="btn btn-primary">Add</button>                                                        
                </div>                
                                                                
              </form>
            <!-- End General Form Elements -->

            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User List</h5>
              
              
             
              <table class="table datatable table-striped">
                  <thead>
                    <tr>
                      <th scope="col">Sl. No.</th>
                      <th scope="col">Name</th>
                      <th scope="col">Image</th>
                      <th scope="col">Address</th>
                      <th scope="col">Gender</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody id="user_table">                    
                    <tr>          
                      <td></td>
                      <td></td>                                                                                                        
                      <td></td>                                                                                                        
                      <td></td>                                                                                                        
                      <td></td>                                                                                                        
                      <td>  
                      
                    </td>                                                                      
                    </tr>
                   
                  </tbody>
                </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>


  let baseurl = "{{url('/')}}";
  let img_baseurl = "{{asset('public/users')}}";  
  function store(){      
        let _token = $('meta[name="csrf-token"]').attr('content');              
        var name = $('#name').val();        
        var files = $('#file')[0].files;
        console.log(files);
        var address = $('#address').val();                       
        var gender = $('#gender').val();        
        var fd = new FormData();          
        fd.append('_token',_token);
        fd.append('file',files[0]);
        fd.append('name',name);
        fd.append('address',address);
        fd.append('gender',gender);
        $.ajax({
            type:'POST',
            url:'{{route("store")}}',
            data:  fd,
            contentType: false,
            cache: false,
            processData:false,
            success:function(data){                          
                var user_data = data.data;
                // console.log(json_decode);  
                html = '';              
                user_data.forEach(function(item,keys) {
                    var img = img_baseurl+'/'+item.image;
                    html += '<tr>';        
                    html +=  '<td>'+(keys+1)+'</td>';
                    html +=  '<td>'+item.name+'</td>';                                                                                                       
                    html +=  '<td><img src="'+img+'" width="200px;"></td>';                                                                                                       
                    html +=  '<td>'+item.address+'</td>';                                                                                                        
                    html +=  '<td>'+item.gender+'</td>';                                                                                                        
                    html +=  '<td>'; 
                    html +=  '<span class="badge bg-primary" onclick="user_edit('+item.id+');" style="cursor:pointer;margin-right:5px;">Edit</span>';                    
                    html +=  '<span class="badge bg-danger" onclick="user_delete('+item.id+');" style="cursor:pointer;margin-left:5px;">Delete</span>';
                    html += '</td>';                                                                     
                    html += '</tr>';
                    $('#user_table').html(html); 
                    document.getElementById("store_form_data").reset();             
                }); 
            }
        });
    }
    
</script>

<script>
  function user_delete(value){    
      $.ajax({
        type:'POST',
        url:'{{route("delete")}}',
        data: {
          "_token": "{{ csrf_token() }}",
          "key": value
          },        
          success:function(data) {  
              if(data.data.length > 0){
                var user_data = data.data;
                // console.log(json_decode);  
                html = '';              
                user_data.forEach(function(item,keys) {
                    var img = img_baseurl+'/'+item.image;
                    html += '<tr>';        
                    html +=  '<td>'+(keys+1)+'</td>';
                    html +=  '<td>'+item.name+'</td>';                                                                                                       
                    html +=  '<td><img src="'+img+'" width="200px;"></td>';                                                                                                       
                    html +=  '<td>'+item.address+'</td>';                                                                                                        
                    html +=  '<td>'+item.gender+'</td>';                                                                                                        
                    html +=  '<td>'; 
                    html +=  '<span class="badge bg-primary" onclick="user_edit('+item.id+')" style="cursor:pointer;margin-right:5px;">Edit</span>';                    
                    html +=  '<span class="badge bg-danger" onclick="user_delete('+item.id+')" style="cursor:pointer;margin-left:5px;">Delete</span>';
                    html += '</td>';                                                                     
                    html += '</tr>';
                    $('#user_table').html(html);   
                    
                });     
              }  else {
                    let html = '';
                    html += '<tr>';          
                    html +=  '<td></td>';
                    html +=  '<td></td>';                                                                                                        
                    html +=  '<td></td>';                                                                                                        
                    html +=  '<td></td>';                                                                                                       
                    html +=  '<td></td>';                                                                                                        
                    html +=  '<td>';                      
                    html += '</td>';                                                                     
                    html += '</tr>';
                    $('#user_table').html(html);
              }        
                                   
          }
      });
    }
  </script>

  <script>
    function user_edit(value){
      $.ajax({
          type:'GET',
          url:'{{route("edit")}}',
          data: {
                "_token": "{{ csrf_token() }}",
                "id": value,                
              },          
              success:function(data){                               
                $('#staticBackdropLabel').modal('show');                
                $('#exampleModalLabel').empty().html(data.view);
              }
        });
    }
  </script>

  <script>
    $(document).ready(function () {
      $.ajax({
        type:'GET',
        url:'{{route("get_data")}}',
            
          success:function(data) {            
                 var user_data = data.data;
                // console.log(json_decode);  
                html = '';              
                user_data.forEach(function(item,keys) {
                    var img = img_baseurl+'/'+item.image;
                    html += '<tr>';        
                    html +=  '<td>'+(keys+1)+'</td>';
                    html +=  '<td>'+item.name+'</td>';                                                                                                       
                    html +=  '<td><img src="'+img+'" width="200px;"></td>';                                                                                                       
                    html +=  '<td>'+item.address+'</td>';                                                                                                        
                    html +=  '<td>'+item.gender+'</td>';                                                                                                        
                    html +=  '<td>'; 
                    html +=  '<span class="badge bg-primary" onclick="user_edit('+item.id+')" style="cursor:pointer;margin-right:5px;">Edit</span>';                    
                    html +=  '<span class="badge bg-danger" onclick="user_delete('+item.id+')" style="cursor:pointer;margin-left:5px;">Delete</span>';
                    html += '</td>';                                                                     
                    html += '</tr>';
                    $('#user_table').html(html);                       
                });                        
          }
      });
    });
  </script>


</body>
</html>
