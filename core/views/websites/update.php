<?php $this->layout('layouts/app', ['title' => 'Websites']) ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Website
        <small><?=$website->name?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Websites</a></li>
        <li class="active"><?=$website->name?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-md-6 col-md-offset-3" >
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Website</h3>
                </div>
                <form class="form-horizontal" method="POST" action="<?=url('/websites/' . $website->id)?>">
                    <input type="hidden" name="csrf_token" value="<?=csrf_token()?>" />
                    <div class="box-body">
                        <div class="form-group <?=(hasErrors($errors, 'name') ? 'has-error' : '')?>">
                            <label class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?=$website->name?>">
                                <?=(hasErrors($errors, 'name') ? '<span class="help-block">' . $errors->first('name') . '</span>' : '')?>
                            </div>
                        </div>
                        <div class="form-group <?=(hasErrors($errors, 'link') ? 'has-error' : '')?>">
                            <label class="col-sm-2 control-label">Link</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="link" name="link" placeholder="Link" value="<?=$website->link?>">
                                <?=(hasErrors($errors, 'link') ? '<span class="help-block">' . $errors->first('link') . '</span>' : '')?>
                            </div>
                        </div>
                        <div class="form-group <?=(hasErrors($errors, 'xpath') ? 'has-error' : '')?>">
                            <label class="col-sm-2 control-label">XPath</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="xpath" name="xpath" placeholder="XPath" value="<?=$website->xpath?>">
                                <?=(hasErrors($errors, 'xpath') ? '<span class="help-block">' . $errors->first('xpath') . '</span>' : '')?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="hidden" name="previous" value="<?=(request()->request->has('previous') ? request()->request->get('previous') : lastUrl('/websites'))?>">
                        <a href="<?=lastUrl('/websites')?>" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </section>
    <!-- /.content -->