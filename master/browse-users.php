<?php
session_start();
$level = strtoupper($_SESSION['level']);
if ($level == NULL) echo "<script>window.location = '../index.php'</script>";
include "../include/database.php";
?>


<!doctype html>
<!-- <html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec" prefix="og: http://ogp.me/ns#" class="no-js"> -->

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title></title>

	<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" type="text/css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<?php
	$xkey = '';
	if (isset($_GET['submit'])) {
		$xkey = $_GET['xkey'];
		$_SESSION['xkey'] = $xkey;
	} else {
		if (isset($_GET['halaman']) || isset($_REQUEST['xkey']) || isset($_REQUEST['update'])) {
			$xkey = $_SESSION['xkey'];
		} else {
			$xkey = '';
			$_SESSION['xkey'] = '';
		}
	}

	if (isset($_REQUEST['update'])) {
		$username_e = (isset($_GET['username_e']) ? $_GET['username_e'] : '');
		$level_e = (isset($_GET['level_e']) ? $_GET['level_e'] : '');
		$id_e = (isset($_GET['id_e']) ? $_GET['id_e'] : '');
		$sql = "UPDATE tbuser set username='$username_e',',level ='$level_e' where id=$id_e";
		mysqli_query($conn, $sql);
	}


	$sql = "SELECT t.id,t.username, t.level,l.nama_level FROM tbuser t INNER JOIN tblevel l ON t.level = l.id where t.username like '%$xkey%' or l.nama_level like '%$xkey%' order by t.username";
	$halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
	$q = mysqli_query($conn, $sql);
	$jumlahDataPerhalaman = 4;
	$jumlahData = mysqli_num_rows($q);
	$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
	$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
	$sql = "SELECT t.id,t.username,t.level,l.nama_level FROM tbuser t INNER JOIN tblevel l ON t.level = l.id where t.username like '%$xkey%' or l.nama_level like '%$xkey%' order by t.username limit $awalData, $jumlahDataPerhalaman";
	$q = mysqli_query($conn, $sql);

	?>

	<div class="container">
		<div class="card">
			<div class="card-header">
				<form method="GET">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<a href="" class="btn btn-primary" data-toggle="modal" data-target="#addUser"><i class="fa fa-fw fa-plus-circle"></i> Add User</a>
							</div>
						</div>
						<div class="col-sm-6">

							<div class="form-group">
								<input type="text" name="xkey" id="xkey" class="form-control" value="<?= $xkey; ?>" placeholder="Enter key pencarian">
							</div>
						</div>
						<div class="col-sm-3 text-right">
							<div class="form-group">
								<div>

									<a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-danger"><i class="fa fa-fw fa-sync"></i> Clear</a>

									<button type="submit" name="submit" value="search" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>

		<div>

			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr class="bg-primary text-white">
						<th>#</th>
						<th>User</th>
						<th>Level</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$n = $awalData;
					while ($d = mysqli_fetch_array($q)) {
					?>
						<tr>
							<td><?php echo ++$n; ?></td>
							<td><?php echo $d['username']; ?></td>
							<td><?php echo $d['nama_level']; ?></td>
							<td align="center">

								<a href="#" type="button" style="height:34px" class="btn btn-success btn-md  pl-4 pr-4" data-toggle="modal" data-target="#myModal<?php echo $d['id']; ?>"><i class="fa fa-fw fa-edit"></i>Edit</a>

								<a href="del-user.php?delId=<?php echo $d['id']; ?>" type="button" class="btn btn-danger" style="height:34px" onClick="return confirm('Are you sure to delete this user?');"><i class="fa fa-fw fa-trash"></i> Delete</a>
							</td>

						</tr>

						<!-- Edit data -->


						<div class="modal fade" id="myModal<?php echo $d['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header bg-primary text-white">
										<h5 class="modal-title " id="exampleModalLabel">Edit User</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="modal-body">
										<form role="form" action="" method="get">

											<?php
											$id = $d['id'];
											$sql = "SELECT * FROM tbuser where id ='$id'";
											$qr = mysqli_query($conn, $sql);

											//$result = mysqli_query($conn, $query);
											while ($row = mysqli_fetch_array($qr)) {
											?>

												<input type="hidden" name="id_e" value="<?php echo $row['id']; ?>">

												<div class="form-group row my-0">
													<label for="username" class="col-sm-4 col-form-label">User</label>
													<div class="col-sm-8">
														<input type="text" style="height:30px" class="form-control" id="username_e" name="username_e" value="<?= $row['username']; ?>">
													</div>
												</div>


												<div class="form-group row my-0">
													<label for="user_level" class=" col-sm-4 col-form-label">User Level</label>
													<div class="col-sm-8">
														<select class="custom-select my-1 mr-sm-2" id="level_e" name="level_e">
															<option selected>User Level</option>
															<?php
															$sql = "Select * from tblevel order by id";
															$ql = mysqli_query($conn, $sql);
															while ($dl = mysqli_fetch_array($ql)) {
																if ($row['level'] == $dl['id']) {
															?>
																	<option value="<?= $dl['id']; ?>" selected><?= $dl['nama_level']; ?></option>
																<?php
																} else { ?>
																	<option value="<?= $dl['id']; ?>"><?= $dl['nama_level']; ?></option>
															<?php }
															} ?>
														</select>
													</div>

												</div>


												<div class="form-group mt-4">

													<button type="submit" name="update" value="update" id="update" class="btn btn-primary"> Update </button>
													<button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>

												</div>

											<?php
											}
											?>
										</form>
									</div>
								</div>

							</div>
						</div>

						<!-- end edit data -->




					<?php
					}
					?>
				</tbody>
			</table>
			<div class="mt-2">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<?php if ($halamanAktif > 1) : ?>
							<li class="page-item">
								<a class="page-link" href="?halaman= <?= $halamanAktif - 1; ?>">Previous</a>
							</li>
						<?php endif; ?>
						<?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
							<?php if ($i == $halamanAktif) : ?>
								<li class="page-item active"><a class="page-link" href="?halaman= <?= $i; ?>"><?= $i; ?></a></li>
							<?php else : ?>
								<li class="page-item"><a class="page-link" href="?halaman= <?= $i; ?>"><?= $i; ?></a></li>
							<?php endif; ?>
						<?php endfor; ?>
						<?php if ($halamanAktif < $jumlahHalaman) : ?>
							<li class="page-item"><a class="page-link" href="?halaman= <?= $halamanAktif + 1; ?>">Next</a></li>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
		</div> <!--/.col-sm-12-->

	</div>

	<!-- add data User -->

	<?php

	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$level = isset($_POST['level']) ? $_POST['level'] : '';
	$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : '';

	?>


	<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title " id="exampleModalLabel">Add User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php
					if (isset($_POST['submit'])) {
						$passwd = md5($passwd);
						$sql = "INSERT tbuser (username,level,passwd) VALUES ('$username','$level','$passwd')";
						mysqli_query($conn, $sql);
						echo "<script>window.location = 'browse-users.php'</script>";
					}

					$sql = "Select * from tblevel order by id";
					$q = mysqli_query($conn, $sql);
					?>

					<div class="container">
						<form method="POST">
							<div class="form-group row my-0">
								<label for="username" class="col-sm-4 col-form-label">User</label>
								<div class="col-sm-8">
									<input type="text" style="height:30px" class="form-control" id="username" name="username" placeholder="Enter user" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
								</div>
							</div>


							<div class="form-group row my-0">
								<label for="user_level" class=" col-sm-4 col-form-label">User Level</label>
								<div class="col-sm-8">
									<select class="custom-select my-1 mr-sm-2" id="level" name="level">
										<option selected>User Level</option>
										<?php
										while ($d = mysqli_fetch_array($q)) {
										?>
											<option value="<?= $d['id']; ?>"><?= $d['nama_level']; ?></option>
										<?php
										} ?>
									</select>
								</div>
							</div>
							<div class="form-group row my-0">
								<label for="passwd" class="col-sm-4 col-form-label">Password</label>
								<div class="col-sm-8">
									<input type="password" style="height:30px" class="form-control" id="passwd" name="passwd" placeholder="Password anda" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
								</div>
							</div>
							<div class="form-group mt-4">

								<button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary  pl-4 pr-4"> Save </button>
								<button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Close</button>
							</div>
					</div>

				</div>

			</div>
		</div>
	</div>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/jquery.caret/0.1/jquery.caret.js"></script>
	<script src="https://www.solodev.com/_/assets/phone/jquery.mobilePhoneNumber.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
</body>

</html>