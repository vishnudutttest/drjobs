@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">approved</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="tbody1">
    <?php foreach($users as $user) { ?>
       
           
              <tr>
                <th scope="row"><?php echo $user->id ?></th>
                <td><?php echo $user->name ?></td>
                <td><?php echo $user->email  ?></td>
                <td>
                    <?php  if($user->approvedByAdmin){ ?> 
                        approved
                    <?php }else{ ?> 
                       <a class='approve' data-id="<?php echo $user->id ?>" >Aprrove</a>
                    <?php } ?>
                </td>
                <td><a class='edit myBtn' data-id="<?php echo $user->id ?>">edit </a> | <a data-id="<?php echo $user->id ?>" class='delete'> Delete</a></td>
              </tr>
           
    <?php } ?>
        </tbody>
        </table>
        <div id="paginate">{{ $users->links() }}</div>
</div>
 <!-- Trigger/Open The Modal
 <button class="myBtn">Open Modal</button> -->

 <!-- The Modal -->
 <div id="myModal" class="modal">
 
   <!-- Modal content -->
   <div class="modal-content">
     <span class="close">&times;</span>
     <form id="userupdateform">
        <table class="modaltr">
            <tr>
                <td>Name :</td>
                <td> <input type="text" name="name" value="" />
                    <input type="hidden" name="id" value="" />
                 </td>
            </tr>
            <tr>
                <td>email :</td>
                <td>  <input type="text" name="email" value="" /> </td>
            </tr>
            <tr>
                <td>Password :</td>
                <td>   <input type="password" name="password" value="" /> </td>
            </tr>
            <tr>
                <td colspan="2"><input type="button" value="Submit" class="btnupdateuser"/></td>
            </tr>
        </table>
     </form>
   </div>
 
 </div> 
<script>
    $(document).ready(function(){
        console.log("Ready");
        $(document.body).on('click','.btnupdateuser',function(e){
            e.preventDefault();
            console.log("submitted the form")
            var form = $("#userupdateform")
            var data = form.serialize();
            axios.post('/admin/updateuser/',data)
            .then(function (response) {
                console.log(response.data);
                alert(response.data.success);
            }).catch(function (error) {
                //if(error != undefined){
                    console.log(error);
                    console.log(error.response.data.errors)
                    if(error.response.data.errors.email!=undefined)
                    alert(error.response.data.errors.email[0]);
                    if(error.response.data.errors.name!=undefined)
                    alert(error.response.data.errors.name[0]);
                //}
                
            });
        });

        $(document.body).on('click','.edit',function(e){
            e.preventDefault();
            var ele = $(this);
            var id = ele.attr("data-id");
            console.log("edit clicked")
            showmodal(id)
        })
        $(document.body).on('click','.delete',function(e){
            e.preventDefault();
            console.log("delete clicked")
            var ele = $(this);
            var id = ele.attr("data-id");
            
            axios.get('/admin/users/delete/'+$(this).attr('data-id'))
            .then(function (response) {
                console.log(response.data.success);
               
                if(response.data.success=='Deleted Successfully'){
                    alert(response.data.success)
                    $(ele).parent().parent().remove();
                }

                if(response.data.error != undefined){
                    alert(response.data.error)
                    //$(ele).parent().parent().remove();
                }
                
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        })
        $(document.body).on('click','.approve',function(e){
            e.preventDefault(); 
            console.log($(this).text())
            var ele = $(this);
            console.log("approve clicked")
            axios.get('users/approve/'+$(this).attr('data-id'))
            .then(function (response) {
                console.log(response.data.success);
               
                if(response.data.success!=''){
                    $(ele).parent().html('Approved')
                }
                
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        })

        $(document.body).on('click','.pagination li',function(e){
            e.preventDefault();

            console.log("pagination clicked")
            if($(this).find('span')){
                var page = $(this).find('span').text();
            }
            if($(this).find('a')){
                var page = $(this).find('a').text();
            }
            axios.get('/admin/users?page='+page)
            .then(function (response) {
                
                // handle success
                var rows = response.data.user.data.map(function(value){
                    action = "<td><a class='edit myBtn' data-id="+value.id+">edit </a> | <a data-id="+value.id+" class='delete'> Delete</a></td>"
                    link = ("<a class='approve' data-id="+value.id+" >Aprrove</a>")
                    if(value.approvedByAdmin){
                        link = "Approved"
                    }
                    tr = $("<tr></tr>");
                    $(`<td >`+value.id+`</td>`).appendTo(tr)
                    $(`<td >`+value.name+`</td>`).appendTo(tr)
                    $(`<td >`+value.email+`</td>`).appendTo(tr)
                    $(`<td >`+link+`</td>`).appendTo(tr)
                    $(action).appendTo(tr)
                    return tr;
                    
                });
                console.log(rows)
                $("#tbody1").html('')
                $("#tbody1").append(rows)
                // pagiation change
                
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            $('#paginate li').attr('class','');
            $(this).attr('class','active')
        })
    })
</script>
@endsection