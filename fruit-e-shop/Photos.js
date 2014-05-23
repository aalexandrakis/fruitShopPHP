// JavaScript Document

       function GetNextImage() {
            var images = new Array();
            var images_str = document.getElementById('images_arr').value;
            images = images_str.split("#");
            var imagecount = document.getElementById('ImageCount').value;
            var currentimage = document.getElementById('currentimage').value;
            var i=0;
            for (i=0;i<imagecount-1;i=i+1){
               if (images[i] == currentimage) {
                  document.getElementById('previous').display='block';
                  document.getElementById('mainphoto').src = images[i+1];
                  document.getElementById('currentimage').value = images[i+1];
                  document.getElementById('previous').style.display='inline';
                  if (images[i+1] == images[imagecount-1]){
                     document.getElementById('next').style.display='none';
                  }
                  return true;
               }
            }
       }
      
    
       function GetPreviousImage() {
            var images = new Array();
            var images_str = document.getElementById('images_arr').value;
            images = images_str.split("#");
            var imagecount = document.getElementById('ImageCount').value;
            var currentimage = document.getElementById('currentimage').value;
            var i=0;
            for (i=1;i<imagecount;i=i+1){
               if (images[i] == currentimage) {
                  document.getElementById('mainphoto').src = images[i-1];
                  document.getElementById('currentimage').value = images[i-1];
                  document.getElementById('next').style.display='inline';
                  if (images[i-1] == images[0]){
                     document.getElementById('previous').style.display='none';
                  }
                  return true;
               }
            }
       }
    
