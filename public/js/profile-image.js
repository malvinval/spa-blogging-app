function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#my-image').attr('src', e.target.result);
        var resize = new Croppie($('#my-image')[0], {
          viewport: { 
            width: 200, 
            height: 200,
            type: 'circle'
          },
          boundary: { 
            width: 300, 
            height: 300 
          },
          enableOrientation: true
        });
        $('#use').fadeIn();
        $('#use').on('click', function() {
          resize.result('base64').then(function(dataImg) {
            var data = [{ image: dataImg }, { name: 'profile-image.jpg' }];
            // use ajax to send data to php
            $('#result').attr('src', dataImg);    
              axios.post('/update-profile-image', {
                  params: {
                      image: dataImg
                  }
              }).then((response) => {
                  console.log(response.data.success);
              })
          })
        })
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  $("#imgInp").change(function() {
    readURL(this);
  });