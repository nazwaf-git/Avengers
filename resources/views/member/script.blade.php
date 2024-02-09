<script src="../../assets/js/core/jquery.3.2.1.min.js"></script>
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<!-- jQuery UI -->
<script src="../../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="../../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<!-- Datatables -->
<script src="../../assets/js/plugin/datatables/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- Atlantis JS -->
<script src="../../assets/js/atlantis.min.js"></script>
<!-- Atlantis DEMO methods, don't include it in your project! -->
<script src="../../assets/js/setting-demo2.js"></script>
<script>
    // GLOBAL SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#memberDatatable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{ url('memberAjax') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'name',
                name: 'Name'
            }, {
                data: 'email',
                name: 'Email'
            }, {
                data: 'departemen',
                name: 'Departemen',
                render: function(data, type, full, meta) {
                    // Peta untuk mengonversi nilai Departemen
                    var departemenMap = {
                        1: 'Information System',
                        2: 'Digitalization',
                        3: 'Command Center'
                    };

                    return departemenMap[data] || data;
                }
            }, {
                data: 'title',
                name: 'Title',
                render: function(data, type, full, meta) {
                    // Peta untuk mengonversi nilai Title
                    var titleMap = {
                        1: 'Division',
                        2: 'Manager',
                        3: 'IT Functional',
                        4: 'Business Analyst',
                        5: 'Developer',
                        6: 'Data Scientist',
                        7: 'Data Analyst'
                    };

                    return titleMap[data] || data;
                }
            }, {
                data: 'role',
                name: 'Role',
                render: function(data, type, full, meta) {
                    // Peta untuk mengonversi nilai Role
                    var roleMap = {
                        1: 'Admin',
                        2: 'Bussiness Analyst',
                        3: 'Member',
                        4: 'Non-Member'
                    };

                    return roleMap[data] || data;
                }
            }, {
                data: 'action',
                name: 'Action'
            }]
        });
    });

    // Collect data dari modal 2 page
    function collectFormData() {
        var formData = {};

        formData.name = $('#name').val();
        formData.nrp = $('#nrp').val();
        formData.email = $('#email').val();
        formData.noTelp = $('#noTelp').val();
        formData.departemen = $('#departemen').val();
        formData.title = $('#title').val();
        formData.role = $('#role').val();
        formData.gender = $('input[name="gender"]:checked').val();

        return formData;
    }

    // Proses Button Simpan
    $('.button-simpan').on('click', function() {
        simpan();
    });

    // Proses Button Update
    $('body').on('click', '.button-edit', function(e) {
        var id = $(this).data('id');
        $.ajax({
            url: 'memberAjax/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#name').val(response.result.name);
                $('#nrp').val(response.result.nrp);
                $('#email').val(response.result.email);
                $('#noTelp').val(response.result.noTelp);
                $('#departemen').val(response.result.departemen);
                $('#title').val(response.result.title);
                $('#role').val(response.result.role);
                console.log(response.result);
                $('.button-simpan').click(function() {
                    simpan(id);
                });
            }
        });
    });

    // Fungsi Simpan Data
    function simpan(id = '') {
        var formData = collectFormData();
        formData['_token'] = '{{ csrf_token() }}';
        console.log(formData);

        if (id == '') {
            var var_url = 'memberAjax';
            var var_type = 'POST';
        } else {
            var var_url = 'memberAjax/' + id;
            var var_type = 'PUT';
        }
        $.ajax({
            url: var_url,
            type: var_type,
            data: formData,
            success: function(response) {
                if (response.errors) {
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').html("<ul>");
                    $.each(response.errors, function(key, value) {
                        $('.alert-danger').find('ul').append("<li>" + value + "</li>");
                    });
                    $('.alert-danger').append("</ul>");
                } else {
                    $('#name').val('');
                    $('#nrp').val('');
                    $('#email').val('');
                    $('#noTelp').val('');
                    $('#departemen').val('');
                    $('#title').val('');
                    $('#role').val('');
                    $('input[name="gender"]:checked').val();

                    resetAddMemberModal();
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').html(response.success);
                    setTimeout(function() {
                        $('.alert-success').addClass('d-none');
                        $('.alert-success').html('');
                    }, 5000);

                }
                $('#memberDatatable').DataTable().ajax.reload();
            }
        });
    }

    // Proses Button Delete
    $('body').on('click', '.button-delete', function(e) {
        var id = $(this).data('id');
        console.log(id);

        // Ambil token CSRF dari meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Show the delete confirmation modal
        $('#deleteModal').modal('show');

        // Handle deletion upon confirmation
        $('#confirmDelete').off('click').on('click', function() {
            $.ajax({
                url: 'memberAjax/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF ke header
                },
                success: function() {
                    $('#memberDatatable').DataTable().ajax.reload();
                    // Menampilkan notifikasi bahwa data berhasil dihapus
                    showDeleteSuccessModal();
                },
                error: function() {
                    // Menampilkan notifikasi jika terjadi kesalahan saat menghapus data
                    showNotification('error');
                }
            });

            // Hide the modal after deletion
            $('#deleteModal').modal('hide');
        });
    });

    $('#addMemberModal').on('hidden.bs.modal', function() {
        resetAddMemberModal();
    });

    $('#closeModalBtn').click(function() {
        resetAddMemberModal();
    });

    // Clear Modal
    function resetAddMemberModal() {
        $('#name').val('');
        $('#nrp').val('');
        $('#email').val('');
        $('#noTelp').val('');
        $('#departemen').val('');
        $('#title').val('');
        $('#role').val('');
        $('input[name="gender"]').prop('checked', false);
        $('input[name="gender"][value="1"]').prop('checked', true);

        $('.page').hide();
        $('[data-page="1"]').show();

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    }

    // Fungsi Notif Delete
    function showDeleteSuccessModal() {
        $('#deleteSuccessModal').modal('show');

        // Set a timeout to hide the modal after 3000 milliseconds (3 seconds)
        setTimeout(function() {
            $('#deleteSuccessModal').modal('hide');
        }, 1500);
    }

    // Next and Previous Modal
    function nextPage() {
        var currentPage = parseInt($(".page:visible").data("page"));
        var nextPage = currentPage + 1;
        $(".page").hide();
        $(".page[data-page=" + nextPage + "]").show();
    }

    function prevPage() {
        var currentPage = parseInt($(".page:visible").data("page"));
        var prevPage = currentPage - 1;
        $(".page").hide();
        $(".page[data-page=" + prevPage + "]").show();
    }
</script>