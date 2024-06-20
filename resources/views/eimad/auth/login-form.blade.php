<form id="formAuthentication" class="mb-3" action="{{route('login-user')}}" method="POST">
  @csrf
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus>
    @error('email')
      <div class="alert alert-danger mt-2 mb-0">Esta conta não existe!</div>
    @enderror
  </div>
  <div class="mb-3 form-password-toggle">
    <div class="d-flex justify-content-between">
      <label class="form-label" for="password">Password</label>
    </div>
    <div class="input-group input-group-merge">
      <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
    @error('password')
    <div class="alert alert-danger mt-2 mb-0">A password está incorreta!</div>
    @enderror
  </div>
  <div class="mb-3">
    <button class="btn btn-primary d-grid w-100" type="submit">Entrar</button>
  </div>
</form>
