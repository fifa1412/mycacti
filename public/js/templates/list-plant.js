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
                let plant_list = response.data.plant_list;
                let table_content = ``;
                let thead_content = ``;
                let tbody_content = ``;
                let tbody_desc_content = ``;
                let row_item_count = 0;
                let total_item = 0;
                let is_last_item = false;

                plant_list.forEach(function(plant){
                    // append new item to content
                    total_item++;
                    thead_content += `<th scope="col">${total_item}</th>`;
                    tbody_content += `
                    <td width="${100/max_per_row}">
                        <img style="display:block;" width="150px" src="${plant.thumbnail_img_cloud_path}">
                    </td>`;
                    tbody_desc_content += `<tr>
                    						<td scope="col">${total_item}</td>
                    						<td scope="col">${plant.received_date}</td>
                    						<td scope="col">SET001</td>
                    						<td scope="col">${plant.plant_name}</td>
                    						<td scope="col">${plant.price}</td>
                    						<td scope="col">${plant.note}</td>
                    					</tr>`;
                    row_item_count++;

                    // check is last item
                    if(plant_list.length == total_item){
                        is_last_item = true;
                    }

                    // if last item. just fill row until full
                    if(is_last_item){
                        let total_item_tmp = total_item;
                        while (total_item_tmp%max_per_row != 0) {
                            total_item_tmp++;
                            thead_content += `<th scope="col"></th>`;
                            tbody_content += `
                            <td width="${100/max_per_row}">
                                <img style="display:block;" width="150px" src="${ASSET_IMG_PATH}/blank_img.png">
                            </td>`;
                        }              
                    }

                    // [img_table_content] write table before going to next table
                    if(row_item_count == max_per_row || is_last_item){
                        table_content += `
                            <table class="table table-image table-bordered">
                        		<thead style="background: grey">
                         			<tr style="text-align: center">${thead_content}</tr>
                         		</thead>
                         	    <tbody>${tbody_content}</tbody>
                         	</table>`;

                        table_content += `
                            <table class="table table-image table-bordered">
                                <thead style="background: grey">
                                    <tr style="text-align: center">
                                        <th scope="col">ID</th>
                                        <th scope="col">วันที่ได้รับ</th>
                                        <th scope="col">เซตการซื้อ</th>
                                        <th scope="col">ชื่อต้นไม้</th>
                                        <th scope="col">ราคา</th>
                                        <th scope="col">หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>${tbody_desc_content}</tbody>
                            </table>`;

                        table_content += `<br>`;

                        // reset and going to next row
                        row_item_count = 0;
                        thead_content = ``;
                        tbody_content = ``;
                        tbody_desc_content = ``;
                    }
                });
                $(`#list-plant-row`).html(table_content);
            }else{
                Header.closePopup();
                Header.showWarningWithRedirect(response.status.description);
            }
        }
    });

}



// <table class="table table-image table-bordered">
// 				<thead style="background: grey">
// 					<tr style="text-align: center">
// 						@for ($i = 0; $i < $max_row; $i++)
// 							<th scope="col">{{$i}}</th>
// 						@endfor
// 					</tr>
// 				</thead>
// 				<tbody>
// 					@for ($i = 0; $i < $max_row; $i++)
// 					<td width="{{100/$max_row}}%"><img style="display:block;" width="100%" src="https://drive.google.com/uc?id=123y6jkMX6hpS--T66rqjHBs3y8lBGuPp&export=media"></td>
// 					@endfor
// 				</tbody>
// 			</table>   
// 			<!-- <table class="table table-image table-bordered">
// 				<thead style="background: grey">
// 					<tr style="text-align: center">
// 						<th scope="col">ID</th>
// 						<th scope="col">วันที่ได้รับ</th>
// 						<th scope="col">เซตการซื้อ</th>
// 						<th scope="col">ชื่อต้นไม้</th>
// 						<th scope="col">ราคา</th>
// 						<th scope="col">หมายเหตุ</th>
// 					</tr>
// 				</thead>
// 				<tbody id="">
// 				@for ($i = 0; $i < $max_row; $i++)
// 					<tr>
// 						<td scope="col">A001</td>
// 						<td scope="col">2020/01/05</td>
// 						<td scope="col">SET001</td>
// 						<td scope="col">Ariocarpus kotschubeyanus v. macdowelli</td>
// 						<td scope="col">550</td>
// 						<td scope="col">ซื้อมาใหม่</td>
// 					</tr>
// 					@endfor
// 				</tbody>
// 			</table>  -->