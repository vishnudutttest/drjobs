// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementsByClassName("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

function showmodal(id)
{
    axios.get('/admin/getuser/'+id)
    .then(function (response) {
        console.log(response.data);
        var data = response.data;
        $("#userupdateform input[name='name']").val(data.name)
        $("#userupdateform input[name='id']").val(data.id)
        $("#userupdateform input[name='email']").val(data.email)
    })
    .catch(function (error) {
        // handle error
        console.log(error);
    })
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 