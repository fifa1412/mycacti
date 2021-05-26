var AddPlant = {};

AddPlant.readImage = function(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview_img')
                .attr('src', e.target.result)
                .width(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

AddPlant.doSubmit = function(){
    let plant_name = $(`#plant_name`).val();
    if(plant_name == ''){
        Header.showWarningPopup(`Please Enter Plant Name`);
    }else{
        Header.showPopup('Please Wait...');
        var formData = new FormData();
        formData.append('img', $('#plant_img')[0].files[0]);
        formData.append('price', $(`#price`).val());
        formData.append('received_date', $(`#received_date`).val());
        formData.append('plant_name', plant_name);
        formData.append('note', $(`#note`).val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            }
        });
        $.ajax({
            type: "post",
            url: BASE_URL + "/api/Plant/userAddPlant",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status.code == 200){
                    Header.closePopup();
                    Header.showSuccessPopup('Add Plant Successfully');
                }else{
                    Header.closePopup();
                    Header.showWarningWithRedirect(response.status.description);
                }
            }
        });
    }

}

