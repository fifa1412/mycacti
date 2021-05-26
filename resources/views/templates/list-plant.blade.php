<style>
h4 {
  margin: 2rem 0rem 1rem;
}
.table-image {
  td, th {
    vertical-align: middle;
  }
}
</style>

<div class="container" style="padding: 2rem 0rem;">
	<div class="row">
		<div class="col-10">
			<h2>My Plant List</h2>
		</div>
		<div class="col-2" style="text-align: right;">
			<a style="width: 150px" class="btn btn-success" href="{{url('add-plant')}}" role="button">Add New Plant</a>
		</div>
	</div>
	<br>
  	<div class="row">
		<div class="col-12">
			<table class="table table-image table-bordered">
				<thead style="background: grey">
					<tr style="text-align: center">
					<th scope="col">ID</th>
					<th scope="col">Image</th>
					<th scope="col">Plant Name</th>
					<th scope="col">Price</th>
					<th scope="col">Received Date</th>
					<th scope="col">Note</th>
					<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody id="tbody_plant_list"></tbody>
			</table>   
		</div>
  	</div>
</div>