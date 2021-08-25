<?php
 if ($data['success'] === true) {
  echo '<div class="container-lg">
  <h2 class="alert alert-success" style="text-align: center;">User registered succesfully</h2>
  </div>';
 } 

 if ($data['success'] === false) {
  echo '<div class="container-lg">
  <h2 class="alert alert-danger" style="text-align: center;">There was an error while trying to register the user</h2>
  </div>';
 }


?>


<div class="container-lg">
  <h2>Register </h2>
  <form class="register-form" action="/register" method="post">
<div class="mb-3">
    <label for="firstname" class="form-label">First name</label>
    <input type="text" class="form-control" name="name" >
  </div>
  <div class="mb-3">
    <label for="lastname" class="form-label">Last name</label>
    <input type="text" class="form-control" name="lastname" >
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" >
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


