<?php $this->layout('layouts/auth', ['title' => 'Log in']) ?>

<div class="login-box">
  <div class="login-logo">
    <a href="<?= url('/') ?>"><b>Admin</b>LTE</a>
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="<?= url('/login') ?>" method="POST">
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>" />
      <div class="form-group has-feedback <?= (hasErrors($errors, 'username') || $username ? 'has-error' : '') ?>">
        <input type="text" name="username" class="form-control" placeholder="Username" value="<?=$request ? $request->request->get('username') : ''?>"
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <?php
        if ($username) {
          echo '<span class="help-block">' . $username . '</span>';
        } else {
        ?>
          <?= (hasErrors($errors, 'username') ? '<span class="help-block">' . $errors->first('username') . '</span>' : '') ?>
        <?php
        }
        ?>
      </div>
      <div class="form-group has-feedback <?= (hasErrors($errors, 'password') ? 'has-error' : '') ?>">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?= (hasErrors($errors, 'password') ? '<span class="help-block">' . $errors->first('password') . '</span>' : '') ?>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="#">I forgot my password</a><br>
    <a href="<?= url('/register') ?>" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
