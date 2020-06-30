<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-user mr-1"></i>
                  User Roles
                </h3>
                <div class="card-tools">
                  <button class="btn btn-success" id="tambah">Tambah</button>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                <table width="100%" class="table-hover table-bordered table" id="table">
                <thead>
                  <tr>
                    <th width="50px">No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Create date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
          <form id="_form_" method="post">
            <input type="hidden" id="id_edit" name="id_edit" value="0">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  Nama Roles
                  <input name="nama_roles" type="text" id="nama_roles" placeholder="" class="form-control" required/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  Menu Roles
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-10">User Group</div>
              <div class="col-md-2"><input type="checkbox" name="roles[]" id="user_group" value="user_group"></div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-10">User Roles</div>
              <div class="col-md-2"><input type="checkbox" name="roles[]" id="user_roles" value="user_roles"></div>
            </div>
          </form>
          </p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="simpan">SIMPAN</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <script>
    $(document).ready(function(){
      $("#tambah").click(function(){
        $("#id_edit").val("");
        $("#_form_").trigger("reset");
        $("#modal-default").modal("show");
      });

      $(document).on("click", "#edit", function(){
          var id_edit = $(this).attr("id_roles");
          var nama_roles = $(this).attr("nama_roles");
          var roles = $(this).attr("roles");
          var roles = roles.split(",");
          roles.forEach(function(entry) {
              if(entry){$("#"+entry).prop('checked', true);}
          });
          $("#id_edit").val(id_edit);
          $("#nama_roles").val(nama_roles);
          $("#modal-default").modal("show");
        });

      $(document).on("click", "#hapus", function(){
        var c = confirm("Data akan dihapus?");
        var id_roles = $(this).attr("id_roles");
        if(c){
          $.ajax({
            type:"POST",
            url:"<?php echo base_url();?>user/user_roles/hapus",
            data: {id_roles:id_roles},
            success: function(data){
              $("#_form_").trigger("reset");
              table.ajax.reload();
              alert("Data dihapus!");
            }
          });
        }
      });

      $("#simpan").click(function(){
        var id_edit = $("#id_edit").val();
        var nama_roles = $("#nama_roles").val();
        if(nama_roles==""){
          alert("Nama roles wajib diisi!");
          return;
        }
        $.ajax({
          type:"POST",
          url:"<?php echo base_url();?>user/user_roles/simpan",
          data: $("#_form_").serialize(),
          success: function(data){
            table.ajax.reload();
            if(data==1){
              alert("Data berhasil disimpan!");
            }else{
              alert("Data gagal disimpan!");
            }
            $("#_form_").trigger("reset");
            $("#modal-default").modal("hide");
          }
        });
      });

      var table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's condend from an Ajax source
        "ajax": {
            "url": "<?php echo base_url()?>user/user_roles/ajax_list",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
      });
    });
  </script>