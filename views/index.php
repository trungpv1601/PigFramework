<?php $this->layout('template', ['title' => 'User Profile']) ?>

<h1>User Profile</h1>
<p>Hello, <?php echo $name ?></p>

<?php
echo getenv('APP_NAME');
?>