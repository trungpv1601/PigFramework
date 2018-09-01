<?php $this->layout('layouts/app', ['title' => 'Websites']) ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Websites
        <small>manager websites</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Websites</a></li>
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
                <form method="GET" action="<?=url('/websites')?>">
                  <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?=$request ? $request->query->get('name') : ''?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="Link" value="<?=$request ? $request->query->get('link') : ''?>">
                    </div>
                  </div>
                  <div class="box-footer">
                    <a href="<?=url('/websites')?>" class="btn btn-danger btn-sm">Reset</a>
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
                  <a href="<?= url('/websites/store') ?>" type="button" class="btn btn-primary btn-sm" title="Add new">
                    <i class="fa fa-plus"></i></a>
                </div>
              </div>
              <div class="box-body">
                <table id="tableData" class="table table-striped">
                  <tbody>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Link</th>
                      <th>Cookies</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                      foreach ($websites as $key => $website) {
                    ?>
                    <tr>
                      <td><?=($key + 1) + (($paginator->getCurrentPage() - 1) * $paginator->getItemsPerPage())?>.</td>
                      <td><?=$website->name?></td>
                      <td><?=$website->link?></td>
                      <td><?=$website->cookies()->count()?></td>
                      <td>
                        <a href="<?=url('/websites/' . $website->id)?>" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i> Update</a> <button type="text" id="btnDelete" data-form="formDelete-<?=$website->id?>" class="btn btn-danger btn-xs" <?=$website->cookies()->count() > 0 ? 'disabled' : ''?>><i class="fa fa-fw fa-remove"></i> Delete</button>
                        <form method="POST" action="<?=url('/websites/' . $website->id . '/delete')?>" id="formDelete-<?=$website->id?>"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>" /></form>
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