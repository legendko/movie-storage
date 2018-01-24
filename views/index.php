<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/styles.css">

</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">			
				<h1 class="text-center">Movie Storage</h1>
				<hr>

				<div class="form-group text-center">
					<button class="btn btn-success" id="open-movie-form">Add new movie</button>
				</div>
			</div>

			<div class="col-sm-4 col-sm-offset-4">
				<form action="/add-movie" method="POST" id="movie-form">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name" >
					</div>

					<div class="form-group">
						<label for="name">Year</label>
						<input type="text" class="form-control" name="year" >
					</div>

					<div class="form-group">
						<label for="name">Format</label>
						<input type="text" class="form-control" name="format" >
					</div>

					<div class="form-group">
						<label for="name">List of actors</label>
						<input type="text" class="form-control" name="list_of_actors" >
					</div>

					<div class="form-group text-center">
						<button class="btn btn-success" type="submit">Add</button>
					</div>

				</form>

				<form method="POST" action="/upload-file" enctype="multipart/form-data">
					<div class="form-group">
						<strong>or upload file:</strong> 
						<input type="file" name="file" />							
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success">Upload</button>
					</div>	
				</form>

			</div>

			<div class="col-sm-8 col-sm-offset-2">

				<hr>

				<?php if(isset($_SESSION['success-message'])): ?>
					<div class="alert alert-success" role="alert">
						<?= $_SESSION['success-message'] ?>
						<?php unset($_SESSION['success-message']) ?>
					</div>
				<?php elseif(isset($_SESSION['fail-message'])): ?>
					<div class="alert alert-danger" role="alert">
						<?= $_SESSION['fail-message'] ?>
						<?php unset($_SESSION['fail-message']) ?>
					</div>
				<?php endif; ?>

				<?php if(count($movies) > 0) : ?>
					<form action="/search-movie" method="POST">
						<div class="row">
							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" name="search" class="form-control">
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-primary pull-right">Search</button>
								</div>
								<div class="col-sm-12">
									<small class="hint">min: 5 symbols</small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-12">
									<input type="checkbox" name="params[]" value="title">by Title
									<input type="checkbox" name="params[]" value="stars" id="ml">by Stars
								</div>
							</div>
						</div>
					</form>

					<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="movies_table">
						<thead>
							<tr>
								<th> Title </th>
								<th> Release Year </th>
								<th> Format </th>
								<th> Stars </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($movies as $movie): ?>
								<tr>
									<td><?= $movie->name ?></td>
									<td><?= $movie->year ?></td>
									<td><?= $movie->format ?></td>
									<td><?= $movie->list_of_actors ?></td>		
									<td>
										<form action="/delete-movie" method="DELETE">
											<input type="hidden" name="movie_id" value="<?= $movie->id ?>">
											<button type="submit" class="btn btn-danger btn-sm">Delete</button>
										</form>
									</td>					
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>

			</div>
		</div>
	</div>	

</body>

<script   src="https://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>

<script>
	$(function() {
	    $('#open-movie-form').on('click', function() {
	    	$(this).fadeOut(500, function() {
	    		$('#movie-form').slideDown();
	    	});	    	
	    })
	});
</script>

</html>
