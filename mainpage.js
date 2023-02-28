let newPostDiv = document.querySelector(".newPostDiv");
let previewNewPostImage = document.getElementById("previewNewPostImage");

function newPostDivToggle() {
  newPostDiv.style.display = "flex";
}

function closeDiv() {
  newPostDiv.style.display = "none";
  previewNewPostImage.src = "";
  document.querySelectorAll("#images")[0].value = "";
}

function showNewPostImage() {
  let imageFile = document.getElementById("images");
  let selectedFile = imageFile.files[0];
  if (selectedFile) {
    let fileReader = new FileReader();
    fileReader.addEventListener("load", function () {
      previewNewPostImage.setAttribute("src", this.result);
    });
    fileReader.readAsDataURL(selectedFile);
  }
}

function getPostData(id) {
  let text = document.getElementById("text_" + id).getAttribute("value");
  let title = document.getElementById("title_" + id).getAttribute("value");
  let image = document.getElementById("image_" + id);
  if (image !== null) {
    image = image.getAttribute("value");
  }
  let postId = id;
  storeToModal(postId, text, title, image);
}

function storeToModal(postId, text, title, image) {
  let modal = document.getElementById("modalBody");
  modal.innerHTML =
  `<form action="./editPost.php" method="POST" enctype="multipart/form-data">
  <div class='titleDiv'>
  <input name='postId' type='hidden' value=${postId}>
  <label for='title' class="form-label" style="font-size:20px">Title</label>
  <input type="text" value=${title} class='form-control' name="title" id='title' required>
  </div>
  <textarea class='form-control' name="text" id="text" cols="30" rows="10" placeholder="Add description"
  onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}">${text}</textarea>
  <label for="imagesModal" class="uploadImage btn btn-outline-secondary">Add Image</label>
  <p class='btn btn-outline-danger' id='removeImageBtn' onclick="removeEditImage()">Remove image</p>
  <input type='text' name='previousImage' id='previousImage' value=${image} style='display:none'>
  <input name="image" value=${image} type="file" accept="image/*" onchange='showEditPreviewImage()' style='display:none' id="imagesModal">
  <div class='autoHeight' id='editImageDiv'>
  ` +
  (image !== null
    ? `<img class='previewImage autoHeight' src=${image} id='previewEditPostImage'/>`
    : `<img class='previewImage autoHeight'id='previewEditPostImage'>`) +
    `
    </div>
    <hr>
    <button type="submit" class="btn btn-outline-success">Save changes</button>
    </form>
    `;
    if(image==null){
        let previewEditImageDiv= document.getElementById('editImageDiv')
        previewEditImageDiv.style.height='0'
      }else{
        previewEditImageDiv.style.height='auto'
      }
  }
  
  function showEditPreviewImage() {
    let previewEditImage = document.getElementById("previewEditPostImage");
    let imageFile = document.getElementById("imagesModal");
    let selectedFile = imageFile.files[0];
    if (selectedFile) {
      let fileReader = new FileReader();
      fileReader.addEventListener("load", function () {
        previewEditImage.setAttribute("src", this.result);
        document.getElementById('editImageDiv').style.height="auto"
      });
      fileReader.readAsDataURL(selectedFile);
    }
  }

  function removeEditImage(){
    document.getElementById("previewEditPostImage").removeAttribute('src');
    document.querySelectorAll('#imagesModal')[0].value=''
    document.querySelectorAll('#previousImage')[0].value='null'
    document.getElementById('editImageDiv').style.height="0px"
  }
  
  let theme='light'
  function changeTheme(){
    if(theme=='light'){
      document.getElementById('background').style.backgroundColor='rgb(71, 71, 71)'
      document.querySelector('.menu').style.backgroundColor='rgb(110, 102, 92)'
      document.querySelector('.newPostButton').classList.replace('btn-outline-secondary', 'btn-dark')
      document.querySelectorAll('.darkmodeBtn').forEach(function(item){item.classList.replace('btn-light', 'btn-dark');})
      theme='dark'
    }else{
      document.getElementById('background').style.backgroundColor= 'rgb(241, 233, 224)'
      document.querySelector('.menu').style.backgroundColor='rgb(202, 191, 178)'
      document.querySelector('.newPostButton').classList.replace('btn-dark', 'btn-outline-secondary')
      document.querySelectorAll('.darkmodeBtn').forEach(function(item){item.classList.replace('btn-dark', 'btn-light');})
      theme='light'
    }
  }
  