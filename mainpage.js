let div = document.querySelector(".newPostDiv");

function newPostDivToggle() {
  div.style.display = "flex";
}

function closeDiv() {
  div.style.display = "none";
}

function getPostData(id){
  let text=document.getElementById('text_'+ id).getAttribute("value");
  let title=document.getElementById('title_'+ id).innerHTML;
  let image=document.getElementById('image_'+ id).innerHTML;
  let postId= id;
  storeToModal(postId, text, title, image)
}

function storeToModal(postId, text, title, image){
  let modal= document.getElementById("modalBody")
  modal.innerHTML=
  `<form action="./editPost.php" method="POST" enctype="multipart/form-data">
  <div class='titleDiv'>
    <input name='postId' type='hidden' value=${postId}</input>
      <label for='title' class="form-label" style="font-size:20px">Title</label>
      <input type="text" value=${title} class='form-control' name="title" id='title'>
  </div>
  <textarea class='form-control' name="text" id="text" cols="30" rows="10" placeholder="Add description"
      onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}">${text}</textarea>
  <label for="images" class="uploadImage btn btn-outline-secondary">Add Image</label>
  <input name="image" value=${image} type="file" accept="image/*" style="visibility:hidden; display:none" id="images">
  <hr>
  <button type="submit" class="btn btn-outline-success">Post</button>
</form>`

}