<style>
	h4 {
		margin: 2rem 0rem 1rem;
	}

	.table-image {
		td, th {
			vertical-align: middle;
		}
	}

	.pointer {
		cursor: pointer;
	}

	/* The Modal (background) */
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
	}

	/* Modal Content (image) */
	.modal-content {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px;
	}

	/* Caption of Modal Image */
	#modalCaption {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px;
		text-align: center;
		color: #ccc;
		padding: 10px 0;
		height: 150px;
	}

	/* Add Animation */
	.modal-content, #modalCaption {  
		-webkit-animation-name: zoom;
		-webkit-animation-duration: 0.6s;
		animation-name: zoom;
		animation-duration: 0.6s;
	}

	@-webkit-keyframes zoom {
		from {-webkit-transform:scale(0)} 
		to {-webkit-transform:scale(1)}
	}

	@keyframes zoom {
		from {transform:scale(0)} 
		to {transform:scale(1)}
	}

	/* The Close Button */
	.close {
		position: absolute;
		top: 15px;
		right: 35px;
		color: #f1f1f1;
		font-size: 40px;
		font-weight: bold;
		transition: 0.3s;
	}

	.close:hover,
	.close:focus {
		color: #bbb;
		text-decoration: none;
		cursor: pointer;
	}

	/* 100% Image Width on Smaller Screens */
	@media only screen and (max-width: 700px){
		.modal-content {
			width: 100%;
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

<!-- The Modal -->
<div id="myModal" class="modal">
	<span class="close">&times;</span>
	<img class="modal-content" id="modalImg">
	<div id="modalCaption"></div>
</div>

<script>
	var modal = document.getElementById("myModal");
	var modalImg = document.getElementById("modalImg");
	var captionText = document.getElementById("modalCaption");

	function showImgModal(plant, img_cloud_path){
		modal.style.display = "block";
		modalImg.src = img_cloud_path;
		captionText.innerHTML = plant.alt;
	}

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
		modal.style.display = "none";
	}
</script>