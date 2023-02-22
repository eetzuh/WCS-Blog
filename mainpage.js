let div = document.querySelector(".newPostDiv");

function newPostDivToggle() {
  div.style.display = "flex";
}

function closeDiv() {
  div.style.display = "none";
}

//working on image preview
function showImage(){
  let previewImage=document.getElementById('previewImage');
  let imageFile=document.getElementById('images');
  let selectedFile= imageFile.files[0]
  if(selectedFile){
    let fileReader= new FileReader();
  }
  console.log("works");
}

function getPostData(id){
  let text=document.getElementById('text_'+ id).getAttribute("value");
  let title=document.getElementById('title_'+ id).getAttribute("value");
  let image=document.getElementById('image_'+ id)
  if(image!==null){
    image=image.getAttribute('value')
  }
  let postId= id;
  storeToModal(postId, text, title, image)
}

function storeToModal(postId, text, title, image){
  let modal= document.getElementById("modalBody")
  modal.innerHTML=
  `<form action="./editPost.php" method="POST" enctype="multipart/form-data">
  <div class='titleDiv'>
    <input name='postId' type='hidden' value=${postId}>
      <label for='title' class="form-label" style="font-size:20px">Title</label>
      <input type="text" value=${title} class='form-control' name="title" id='title' required>
  </div>
  <textarea class='form-control' name="text" id="text" cols="30" rows="10" placeholder="Add description"
      onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}">${text}</textarea>
  <label for="imagesModal" class="uploadImage btn btn-outline-secondary">Add Image</label>
  <input type='text' name='previousImage' id='previousImage' value=${image} style='display:none'>
  <input name="image" value=${image} type="file" accept="image/*" style='display:none' id="imagesModal">
  <hr>
  <button type="submit" class="btn btn-outline-success">Save changes</button>
</form>`

}