var ListPlant = {};

$(document).ready(function() {
    ListPlant.getPlantList();
});

ListPlant.getPlantList = function(){
    Header.showPopup('Please Wait...');
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        }
    });
    $.ajax({
        type: "post",
        url: BASE_URL + "/api/Plant/userGetPlantList",
        success: function (response) {
            if(response.status.code == 200){
                Header.closePopup();
                let plant_list = response.data;
                let html_content = ``;
                plant_list.forEach(function(plant){
                    html_content += `<tr>`;
                    html_content += `<td>${plant.id}</td>`;
                    html_content += `<td><img src="${BASE_URL}/storage/plant_img/${plant.img}" width="250px"></td>`;
                    html_content += `<td>${plant.plant_name}</td>`;
                    html_content += `<td>${plant.price}</td>`;
                    html_content += `<td>${plant.received_date}</td>`;
                    html_content += `<td>${plant.note}</td>`;
                    html_content += `</tr>`;
                });

                $(`#tbody_plant_list`).html(html_content);
            }else{
                Header.closePopup();
                Header.showWarningWithRedirect(response.status.description);
            }
        }
    });

}

