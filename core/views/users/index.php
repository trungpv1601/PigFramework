<?php $this->layout('layouts/app', ['title' => 'Users']) ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>manager users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Filter:</h3>
              </div>
              <form method="GET" action="<?=url('/users')?>">
                <div class="box-body">
                  <div class="form-group">
                      <label class="control-label">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?=$request ? $request->query->get('name') : ''?>">
                  </div>
                  <div class="form-group">
                      <label class="control-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?=$request ? $request->query->get('username') : ''?>">
                  </div>
                  <div class="form-group">
                      <label class="control-label">Admin</label>
                      <?php 
                      $is_admin = $request->query->get('is_admin');
                      ?>
                      <select class="form-control" name="is_admin">
                        <option value="-1">--- All ---</option>
                        <option value="1" <?=$is_admin != NULL && $is_admin == 1 ? 'selected' : ''?>>Active</option>
                        <option value="0" <?=$is_admin != NULL && $is_admin == 0 ? 'selected' : ''?>>In Active</option>
                      </select>
                  </div>
                </div>
                <div class="box-footer">
                  <a href="<?=url('/users')?>" class="btn btn-danger btn-sm">Reset</a>
                  <button type="submit" class="btn btn-primary btn-sm pull-right">Search</button>
                </div>
              </form>
          </div>
        </div>
        <div class="col-md-9">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data: <?=$paginator->getTotalItems()?> items</h3>

              <div class="box-tools pull-right">
                <a href="<?= url('/users/store') ?>" type="button" class="btn btn-primary btn-sm" title="Add new">
                  <i class="fa fa-plus"></i></a>
              </div>
            </div>
            <div class="box-body">
              <table id="tableData" class="table table-striped">
                <tbody>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Admin</th>
                    <th>Action</th>
                  </tr>
                  <?php 
                    foreach ($users as $key => $user) {
                  ?>
                  <tr>
                    <td><?=($key + 1) + (($paginator->getCurrentPage() - 1) * $paginator->getItemsPerPage())?>.</td>
                    <td><?=$user->name?></td>
                    <td><?=$user->username?></td>
                    <td><?=$user->is_admin ? '<span class="label label-primary">Active</span>' : '<span class="label label-danger">In Active</span>'?></td>
                    <td>
                      <a href="<?=url('/users/' . $user->id)?>" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i> Update</a> <button type="text" id="btnDelete" data-form="formDelete-<?=$user->id?>" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-remove"></i> Delete</button>
                      <form method="POST" action="<?=url('/users/' . $user->id . '/delete')?>" id="formDelete-<?=$user->id?>"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>" /></form>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
              <?= $paginator ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
    <?php $this->start('JS') ?>
<script>
    $(function () {
      $('#tableData').on('click', '#btnDelete', function(){
        var that = this;
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this item!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            var dataForm = $(that).attr('data-form');
            $( '#' + dataForm).submit();
          }
        });
      });
    });
</script>
<?php $this->stop() ?>