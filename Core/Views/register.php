<!DOCTYPE html>
<html lang="en">
<?php require_once VIEW_DIR . "Shared/Head.phtml"; ?>
<body>
   <div class="container mt-5">
      <h2>Register</h2>
      <?php if (isset($_SESSION['message'])): ?>
         <div class="alert alert-<?php echo explode('#',$_SESSION['message'])[0];?>">
            <?php echo explode('#',$_SESSION['message'])[1];  ?>


            <?php unset($_SESSION['message']); ?>
         </div>
      <?php endif; ?>
      <form action="/register" method="POST">
         <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
         </div>
         <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
         </div>
         <button type="submit" class="btn btn-primary">Register</button>
      </form>
      <p>Already have an account? <a href="./login">Log In instead</a></p>
   </div>
</body>
</html>