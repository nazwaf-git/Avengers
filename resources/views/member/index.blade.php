@extends('dashboard.main')

@section('container')
<div class="container mt-4">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
			<li class="breadcrumb-item active" aria-current="page">Member</li>
		</ol>
	</nav>
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">Kelola Member</h4>
				<button class="btn btn-primary btn-round ml-auto button-add" data-toggle="modal" data-target="#addMemberModal">
					<i class="fa fa-plus"></i>
					Add Row
				</button>
			</div>
		</div>
		<div class="card-body">
			<!-- Modal -->
			<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header no-bd">
							<h4 class="modal-title">
								<span class="fw-mediumbold">New</span>
								<span class="fw-light">Member</span>
							</h4>
							<button type="button" id="closeModalBtn" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="page" data-page="1">
								<p class="small">Add members, create your streamline, and build stunning projects (page 1/2)</p>
								<form>
									<!-- Form fields for page 1 -->
									<div class="alert alert-danger d-none"></div>
									<div class="alert alert-success d-none"></div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group form-group-default">
												<label for="name">Name<span class="text-danger">*</span></label>
												<input id="name" type="text" class="form-control" placeholder="fill name" required>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group form-group-default">
												<label for="nrp">NRP<span class="text-danger">*</span></label>
												<input id="nrp" type="text" class="form-control" placeholder="fill nrp" required>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group form-group-default">
												<label for="email">Email<span class="text-danger">*</span></label>
												<input id="email" type="email" class="form-control" placeholder="fill email" required>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group form-group-default">
												<label for="noTelp">Nomor Telepon<span class="text-danger">*</span></label>
												<input id="noTelp" type="text" class="form-control" placeholder="fill telepon" required>
											</div>
										</div>
									</div>
									<div class="modal-footer no-bd">
										<button type="button" class="btn btn-primary" onclick="nextPage()">Next</button>
									</div>
								</form>
							</div>

							<div class="page" data-page="2" style="display: none;">
								<p class="small">Add members, create your streamline, and build stunning projects (page 2/2)</p>
								<form>
									<!-- Form fields for page 2 -->
									<div class="alert alert-danger d-none"></div>
									<div class="alert alert-success d-none"></div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group form-group-default">
												<label for="departemen">Departement<span class="text-danger">*</span></label>
												<select id="departemen" class="form-control" required>
													<option value="">Select Departement</option>
													<option value="1">Information System</option>
													<option value="2">Digitalization</option>
													<option value="3">Command Center</option>
													<option value="0">lainnya..</option>
												</select>
											</div>
										</div>
										<div class="col-md-6 pr-0">
											<div class="form-group form-group-default">
												<label for="title">Title<span class="text-danger">*</span></label>
												<select id="title" class="form-control" required>
													<option value="">Select Title</option>
													<option value="1">Division</option>
													<option value="2">Manager</option>
													<option value="3">IT Functional</option>
													<option value="4">Business Analyst</option>
													<option value="5">Developer</option>
													<option value="6">Data Scientist</option>
													<option value="7">Data Analyst</option>
												</select>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label for="role">Role<span class="text-danger">*</span></label>
												<select id="role" class="form-control" required>
													<option value="">Select Role</option>
													<option value="1">Admin</option>
													<option value="2">Business Analyst</option>
													<option value="3">Member</option>
													<option value="4">Non-Member</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group form-group-default">
												<label for="gender" class="mr-3">Gender<span class="text-danger">*</span></label>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="gender" id="male" value="1" checked>
													<label class="form-check-label" for="male">Laki-laki</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="gender" id="female" value="2">
													<label class="form-check-label" for="female">Perempuan</label>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer no-bd">
										<button type="button" class="btn btn-warning" onclick="prevPage()">Previous</button>
										<button type="button" class="btn btn-primary button-simpan">Simpan</button>
									</div>
								</form>
							</div>

							<!-- Add more pages as needed -->

						</div>
					</div>
				</div>
			</div>
			<!-- Delete Confirmation Modal -->
			<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<!-- Modal Header -->
						<div class="modal-header">
							<h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<!-- Modal Body -->
						<div class="modal-body">
							<p>Yakin ingin menghapus data ini?</p>
						</div>
						<!-- Modal Footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
							<button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal Delete Notification-->
			<div class="modal" id="deleteSuccessModal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Notifikasi</h5>
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Data berhasil dihapus!</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table id="memberDatatable" class="display table table-striped table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Email</th>
							<th>Departemen</th>
							<th>Title</th>
							<th>Role</th>
							<th style="width: 10%">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

@include('member.script')
@endsection