

<div class="modal-body">
        <form id="update_form_data"  enctype="multipart/form-data">
                    
                    <div class="row mb-4">
                      <label for="inputNumber" class="col-sm-2 col-form-label">Name:</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" id="update_name" name="name" value="{{$data['name']}}" required>
                      </div> 
                      
                      <label for="inputNumber" class="col-sm-2 col-form-label">Image:</label>
                      <div class="col-sm-12">
                        <input type="file" id="update_file" class="form-control" name="file" >
                        <img src="{{asset('public/users/'.$data['image'])}}" width="50px;">
                      </div>  
    
                      <label for="inputNumber" class="col-sm-2 col-form-label">Address:</label>
                      <div class="col-sm-12">
                      <textarea class="ckeditor form-control" id="update_address"  name="address">{{$data['address']}}</textarea> 
                      <!-- <input type="text" class="form-control" id="address" name="address" placeholder="enter address"> -->
                        </div>  
    
                      <label for="inputNumber" class="col-sm-2 col-form-label">Gender:</label>
                      <div class="col-sm-12">
                        <select class="form-control" name="gender" id="update_gender" required>
                          <option value="Male" @selected($data['gender'] == 'Male')>Male</option>
                          <option value="Female" @selected($data['gender'] == 'Female')>Female</option>
                        </select>                   
                      </div>  
                    </div>
    
                    <div class="col-12">                
                        <button type="button" onclick="update({{$data['id']}})" class="btn btn-primary">Update</button>                                                        
                    </div>                
                                                                    
                  </form>
      </div>

<script>
    function update(value){      
        let _token = $('meta[name="csrf-token"]').attr('content'); 
        var id = value;              
        var update_name = $('#update_name').val();        
        var update_files = $('#update_file')[0].files;        
        var update_address = $('#update_address').val();                       
        var update_gender = $('#update_gender').val();        
        var fd = new FormData();          
        fd.append('_token',_token);
        fd.append('id',id);
        fd.append('file',update_files[0]);
        fd.append('name',update_name);
        fd.append('address',update_address);
        fd.append('gender',update_gender);
        $.ajax({
            type:'POST',
            url:'{{route("update")}}',
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
                    $('#staticBackdropLabel').modal('hide');
                }); 
            }
        });
    }
</script>