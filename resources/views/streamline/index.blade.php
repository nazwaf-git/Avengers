@extends('dashboard.main')

@section('container')
<link rel="stylesheet" href="path/to/select2.min.css">
<!-- Memasukkan Select2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css">

<!-- Memasukkan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Memasukkan Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Streamline</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Kelola Streamline</h4>
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
                                <span class="fw-light">Streamline</span>
                            </h4>
                            <button type="button" id="closeModalBtn" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="page" data-page="1">
                                <p class="small">Create your streamline, and build stunning projects</p>
                                <form>
                                    <!-- Form fields for page 1 -->
                                    <div class="alert alert-danger d-none"></div>
                                    <div class="alert alert-success d-none"></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="namaStreamline">Nama Streamline<span class="text-danger">*</span></label>
                                                <input id="namaStreamline" type="text" class="form-control" placeholder="fill streamline name" required>
                                            </div>
                                        </div>
                                        <!-- Untuk Leader -->
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="leader">Leader<span class="text-danger">*</span></label>
                                                <select id="leader" class="form-control" required>
                                                    <!-- Opsi default -->
                                                    <option value="">Pilih Leader</option>

                                                    <!-- Menggunakan data yang dikirim dari controller -->
                                                    @foreach($leaders as $leader)
                                                    <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="member">Member<span class="text-danger">*</span></label>
                                                <select id="member" class="form-control" required multiple="true" data-live-search="true">
                                                    <!-- Opsi default -->
                                                    <option value="">Pilih Member</option>

                                                    <!-- Mengambil data dari model MsMember -->
                                                    @php
                                                    // Gantilah dengan nama model dan field yang sesuai dengan struktur database Anda
                                                    use App\Models\MsMember as AnggotaModel;

                                                    // Query menggunakan Eloquent untuk mengambil data MsMember
                                                    $anggotas = AnggotaModel::all();

                                                    // Tampilkan data sebagai opsi dropdown
                                                    foreach ($anggotas as $anggota) {
                                                    echo "<option value='" . $anggota->id . "'>" . $anggota->name . "</option>";
                                                    }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer no-bd">
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary button-simpan">Simpan</button>
                                    </div>
                                </form>
                            </div>
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
                            <th>Nama Streamline</th>
                            <th>Leader</th>
                            <th style="width: 10%">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@include('streamline.script')
@endsection