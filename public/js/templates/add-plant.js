var AddPlant = {};

AddPlant.doSubmit = function(){
    Header.showPopup('Please Wait...');
    var formData = new FormData();
    formData.append('img', $('#plant_img')[0].files[0]);
    formData.append('price', $(`#price`).val());
    formData.append('received_date', $(`#received_date`).val());
    formData.append('plant_name', $(`#plant_name`).val());
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

