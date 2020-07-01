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
                  User Group
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
                    <th>Group</th>
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
                  Nama User
                  <input name="nama_user" type="text" id="nama_user" placeholder="" class="form-control" required/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  Username
                  <input type="text" id="username" name="username" placeholder="" class="form-control" required/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  Email
                  <input type="text" id="email" name="email" placeholder="" class="form-control" required/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  Password
                  <input name="password" type="password" id="password" placeholder="" class="form-control" required/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  Group
                  <select id="id_group" name="id_group" class="form-control" required>
                  <?php $result = $this->db->get("tbl_user_roles")->result(); ?>
                  <option value="">PILIH</option>
                  <?php foreach($result as $data): ?>
                    <option value="<?php echo $data->id_roles;?>"><?php echo $data->nama_roles;?></option>
                  <?php endforeach;?>
                  </select>
                </div>
              </div>
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
          var id_edit = $(this).attr("id_user");
          var nama_user = $(this).attr("nama_user");
          var username = $(this).attr("username");
          var email = $(this).attr("email");
          var password = $(this).attr("password");
          var id_group = $(this).attr("id_group");
          $("#id_edit").val(id_edit);
          $("#nama_user").val(nama_user);
          $("#username").val(username);
          $("#email").val(email);
          $("#id_group").val(id_group);
          $("#modal-default").modal("show");
        });

      $(document).on("click", "#hapus", function(){
        var c = confirm("Data akan dihapus?");
        var id_user = $(this).attr("id_user");
        if(c){
          $.ajax({
            type:"POST",
            url:"<?php echo base_url();?>user/user_group/hapus",
            data: {id_user:id_user},
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
        var nama_user = $("#nama_user").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var id_group = $("#id_group").val();
        if(nama_user==""){
          alert("Nama user wajib diisi!");
          return;
        }
        if(username==""){
          alert("Username wajib diisi!");
          return;
        }
        if(email==""){
          alert("Email wajib diisi!");
          return;
        }
        if(parseInt(id_edit)<1){
          if(password==""){
            alert("Password wajib diisi!");
            return;
          }
        }
        if(id_group==""){
          alert("Group wajib diisi!");
          return;
        }
        $.ajax({
          type:"POST",
          url:"<?php echo base_url();?>user/user_group/simpan",
          data: $("#_form_").serialize(),
          success: function(data){
            table.ajax.reload();
            if(data==2){
              alert("Username sudah ada!");
            }else if(data==1){
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
            "url": "<?php echo base_url()?>user/user_group/ajax_list",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,1,2,3,4,5], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
      });
    });
  </script>
