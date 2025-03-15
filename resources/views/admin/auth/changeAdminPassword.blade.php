@extends('admin.master')

@section('title', 'Admin | profile')

@section('body')

    <h2 class="mb-4">Change Admin Password</h2>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Change Admin Password
        </div>
        <div class="card-body">
            <form method="post" action="{{route('admin.changePassword')}}">
                @csrf

                <div class="col-md-12  container-fluid">
                    <div class="form-group">
                        <label for="sms_api" style="text-transform: uppercase;"><strong>Current password</strong></label>
                        <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-lg {{ $errors->has('current_password') ? ' is-invalid' : '' }}"  name="current_password" required id="password">
                        <span class="input-group-text">
                        <i class="far fa-eye" id="togglePassword" 
                       style="cursor: pointer"></i>
                       </span>
                   </div>
                        @if ($errors->has('current_password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12  container-fluid">
                    <div class="form-group">
                        <label for="sms_api" style="text-transform: uppercase;"><strong>New password</strong></label>
                        <div class="input-group mb-3">
                        <input type="password" id="npassword" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}"  name="password" required>
                        <span class="input-group-text">
                        <i class="far fa-eye" id="togglePasswordn" 
                       style="cursor: pointer"></i>
                       </span>
                    </div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12  container-fluid">
                    <div class="form-group">
                        <label for="sms_api" style="text-transform: uppercase;"><strong>Re-type password</strong></label>
                        <div class="input-group mb-3">
                        <input type="password" id="rpassword" class="form-control form-control-lg {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"  name="password_confirmation" required>
                        <span class="input-group-text">
                        <i class="far fa-eye" id="togglePasswordr" 
                       style="cursor: pointer"></i>
                       </span>
                    </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <br>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-secondary btn-block btn-lg customs-btn-bd">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
  const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", function () {
   
  // toggle the type attribute
  const type = password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);
  // toggle the eye icon
  this.classList.toggle('fa-eye');
  this.classList.toggle('fa-eye-slash');
});
const togglePassword1 = document.querySelector("#togglePasswordn");
const password1 = document.querySelector("#npassword");

togglePassword1.addEventListener("click", function () {
   
  // toggle the type attribute
  const type1 = password1.getAttribute("type") === "password" ? "text" : "password";
  password1.setAttribute("type", type1);
  // toggle the eye icon
  this.classList.toggle('fa-eye');
  this.classList.toggle('fa-eye-slash');
});
const togglePassword2 = document.querySelector("#togglePasswordr");
const password2 = document.querySelector("#rpassword");

togglePassword2.addEventListener("click", function () {
   
  // toggle the type attribute
  const type2 = password2.getAttribute("type") === "password" ? "text" : "password";
  password2.setAttribute("type", type2);
  // toggle the eye icon
  this.classList.toggle('fa-eye');
  this.classList.toggle('fa-eye-slash');
});
</script>

@endsection