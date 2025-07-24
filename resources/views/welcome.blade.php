<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login & Registration</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      background: #f0f2f5;
    }
    .auth-container {
      max-width: 400px;
      margin: 60px auto;
    }
    .auth-card {
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      padding: 2rem;
    }
    .form-toggle {
      text-align: center;
      margin-top: 1rem;
    }
    .form-toggle button {
      border: none;
      background: none;
      color: #0d6efd;
      text-decoration: underline;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="auth-container">
    <div class="auth-card" id="login-form">
      <h3 class="text-center mb-4">Login</h3>
      <form>
        <div class="mb-3">
          <label for="loginEmail" class="form-label">Email address</label>
          <input type="email" class="form-control" id="loginEmail" placeholder="name@example.com" />
        </div>
        <div class="mb-3">
          <label for="loginPassword" class="form-label">Password</label>
          <input type="password" class="form-control" id="loginPassword" placeholder="••••••••" />
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <div class="form-toggle">
          <p>Don't have an account?
            <button><a href="#"></a></button>
          </p>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
