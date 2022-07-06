@extends('layouts.app')

@section('content')
<div class="container" id="container">
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">title</th>
            <th scope="col">content</th>
            <!--<th scope="col">user</th>-->
            <th scope="col">category</th>
            <th scope="col">status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="tbody1">
    <?php foreach($posts as $post) { ?>
       
           
              <tr>
                <th scope="row"><?php echo $post->id ?></th>
                <td><?php echo $post->title ?></td>
                <td><?php echo str_limit($post->content,20)  ?></td>
                <!--<td>
                    <?php  echo $post->user_id ?>
                </td>-->
                <td>
                    <?php  //echo $post->post_category ?><?php  echo $post->category->title ?>
                </td>
                <td>
                    <?php  echo $post->status ?>
                </td>
                <td><!--<a class='edit myBtn' data-id="<?php echo $post->id ?>">edit </a> |--> <a data-id="<?php echo $post->id ?>" class='delete'> Delete</a></td>
              </tr>
           
    <?php } ?>
        </tbody>
        </table>
        <div id="paginate">{{ $posts->links() }}</div>
</div>
 <!-- Trigger/Open The Modal
 <button class="myBtn">Open Modal</button> -->

 
 
 </div> 
<script>
    $(document).ready(function(){
        console.log("Ready");
        
       
        $(document.body).on('click','.delete',function(e){
            e.preventDefault();
            var id = $(this).attr('data-id')
            console.log(id)

            axios.get('/user/deletepost/'+id)
            .then(function (response) {
                console.log(response.data)
                alert(response.data.message)
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
            console.log(page)
            axios.get('/user/dashboard?page='+page)
            .then(function (response) {
                
               $("#container").html($(response.data).find("#container").html())
                
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