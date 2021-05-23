<br>
<div class="container" style="width: 50%">
  <div class="row">
    <div class="col">
      <h2>Add New Plant</h2>
    </div>
  </div>

  <hr>
  <div class="row">
    <div class="col">
    <form>
        <div class="form-group" style="margin-bottom: 10px">
            <label>Plant Name</label>
            <input type="text" class="form-control" id="plant_name" name="plant_name" placeholder="Enter plant name">
        </div>
        <div class="form-group" style="margin-bottom: 10px">
            <label>Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter price">
        </div>
        <div class="form-group" style="margin-bottom: 10px">
            <label>Received Date</label>
            <input type="text" class="form-control" id="received_date" name="received_date" placeholder="Enter received date (YYYY-mm-dd)">
        </div>
        <div class="form-group" style="margin-bottom: 10px">
            <label class="form-label" for="customFile">Select Plant Image</label>
            <input type="file" class="form-control" id="plant_img" name="plant_img"/>
        </div>
        <div class="form-group" style="margin-bottom: 10px">
            <label class="form-label" for="customFile">Note</label>
            <textarea class="form-control" id="note" name="note" placeholder="Enter note" rows="3"></textarea>
        </div>
        <button type="button" onclick="AddPlant.doSubmit();" class="btn btn-primary">Save</button>
    </form>

    </div>
  </div>
</div>

