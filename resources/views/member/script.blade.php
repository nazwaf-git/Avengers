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
                        // Tambahkan peta lain jika ada nilai departemen lainnya
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
                        // Tambahkan peta lain jika ada nilai title lainnya
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
                        // Tambahkan peta lain jika ada nilai role lainnya
                    };

                    return roleMap[data] || data;
                }
            }, {
                data: 'action',
                name: 'Action'
            }]
        });
    });

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

    // Fungsi Simpan Data
    function simpan(id = '') {
        var formData = collectFormData();
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
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').html(response.success);
                    $('#name').val('');
                    $('#nrp').val('');
                    $('#email').val('');
                    $('#noTelp').val('');
                    $('#departemen').val('');
                    $('#title').val('');
                    $('#role').val('');
                    $('input[name="gender"]:checked').val();
                }
                $('#memberDatatable').DataTable().ajax.reload();
            }
        });
    }

    // Clear Modal
    $('#memberDatatable').on('hidden.bs.modal', function() {
        $('#name').val('');
        $('#nrp').val('');
        $('#email').val('');
        $('#noTelp').val('');
        $('#departemen').val('');
        $('#title').val('');
        $('#role').val('');
        $('#gender').val('1');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });

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