function getBlob(e) {
  e.stopPropagation();
  if (e.target.files) {
    {
      let file = e.target.files[0];
      var filename = String(file.name);
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = () => {
        if (file.size > 500 * 1024) {
          alert("size of uploaded file is more than 500 KB ");
          return;
        }
        document.getElementById("blob-content").value = reader.result;
        document.getElementById("blob-filename").value = filename;
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file); //your file(s) reference(s)
        document.getElementById("video-game-blob").files = dataTransfer.files;
        document.getElementById("screenshot#_video-game-blob").src =
          reader.result;
        document.getElementById("blob_filename").innerHTML = filename;
      };
    }
  }
}
