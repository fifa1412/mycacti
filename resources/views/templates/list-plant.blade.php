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
<script>
	let max_per_row = <?php echo config('config-prod.LIST_PLANT_PER_ROW');?>;
</script>

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
		<div id="list-plant-row" class="col-12"></div>
  	</div>
	
</div>