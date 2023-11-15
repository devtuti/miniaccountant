@extends('web.layout.app')
@section('title', __('Profile Edit'))
@section('content')
<form class="" action="{{route('profile.update')}}" method="post" novalidate>
   @csrf
  <input type="hidden" name="id" value="{{$user->id}}">
    <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Name<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="name" value="{{$user->name}}" placeholder="User Name" required="required" />
        </div>
    </div>
   
    <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">email<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6">
            <input class="form-control" name="email" value="{{$user->email}}" class='email' required="required" type="email" /></div>
    </div>
   
    <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Password<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6">
            <input class="form-control" type="password" id="password1" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" title="Minimum 8 Characters Including An Upper And Lower Case Letter, A Number And A Unique Character" required />
            
            <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()" >
                <i id="slash" class="fa fa-eye-slash"></i>
                <i id="eye" class="fa fa-eye"></i>
            </span>
        </div>
    </div>
   
    <div class="ln_solid">
        <div class="form-group">
            <div class="col-md-6 offset-md-3">
                <button type='submit' class="btn btn-primary">Submit</button>
                <button type='reset' class="btn btn-success">Reset</button>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')

<script src="{{url('front/vendors/validator/multifield.js')}}"></script>
<script src="{{url('front/vendors/validator/validator.js')}}"></script>

<!-- Javascript functions	-->
<script>
    function hideshow(){
        var password = document.getElementById("password1");
        var slash = document.getElementById("slash");
        var eye = document.getElementById("eye");
        
        if(password.type === 'password'){
            password.type = "text";
            slash.style.display = "block";
            eye.style.display = "none";
        }
        else{
            password.type = "password";
            slash.style.display = "none";
            eye.style.display = "block";
        }

    }
</script>

<script>
    // initialize a validator instance from the "FormValidator" constructor.
    // A "<form>" element is optionally passed as an argument, but is not a must
    var validator = new FormValidator({
        "events": ['blur', 'input', 'change']
    }, document.forms[0]);
    // on form "submit" event
    document.forms[0].onsubmit = function(e) {
        var submit = true,
            validatorResult = validator.checkAll(this);
        console.log(validatorResult);
        return !!validatorResult.valid;
    };
    // on form "reset" event
    document.forms[0].onreset = function(e) {
        validator.reset();
    };
    // stuff related ONLY for this demo page:
    $('.toggleValidationTooltips').change(function() {
        validator.settings.alerts = !this.checked;
        if (this.checked)
            $('form .alert').remove();
    }).prop('checked', false);

</script>
@endpush