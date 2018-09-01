<?php $this->layout('layouts/app', ['title' => 'Users']) ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User
        <small>add new user</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">Add</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-md-6 col-md-offset-3" >
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">User</h3>
                </div>
                <form class="form-horizontal" method="POST" action="<?=url('/users/store')?>">
                    <input type="hidden" name="csrf_token" value="<?=csrf_token()?>" />
                    <div class="box-body">
                        <div class="form-group <?=(hasErrors($errors, 'name') ? 'has-error' : '')?>">
                            <label class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?=$request ? $request->request->get('name') : ''?>">
                                <?=(hasErrors($errors, 'name') ? '<span class="help-block">' . $errors->first('name') . '</span>' : '')?>
                            </div>
                        </div>
                        <div class="form-group <?=(hasErrors($errors, 'username') ? 'has-error' : '')?>">
                            <label class="col-sm-2 control-label">Username</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?=$request ? $request->request->get('username') : ''?>">
                                <?=(hasErrors($errors, 'username') ? '<span class="help-block">' . $errors->first('username') . '</span>' : '')?>
                            </div>
                        </div>
                        <div class="form-group <?=(hasErrors($errors, 'password') ? 'has-error' : '')?>">
                            <label class="col-sm-2 control-label">Password</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?=$request ? $request->request->get('password') : ''?>">
                                <?=(hasErrors($errors, 'password') ? '<span class="help-block">' . $errors->first('password') . '</span>' : '')?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Is Admin</label>

                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_admin">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="<?=url('/users')?>" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary pull-right">Add new</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->