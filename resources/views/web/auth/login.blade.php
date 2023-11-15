<div class="animate form login_form">
    <section class="login_content">
      <form action="{{route('login.post')}}" method="POST">
          @csrf
        <h1>Login Form</h1>
        <div>
          <input type="email" class="form-control" name="email" placeholder="Email" required="" />
        </div>
        <div>
          <input type="password" class="form-control" name="password"  placeholder="Password" required="" />
        </div>
        <div>
            <button class="btn btn-default" type="submit">Login</button>
         
        </div>

        <div class="clearfix"></div>

        <div class="separator">
          <p class="change_link">U tebya netu account
            <a href="#signup" class="to_register"> Create Account </a>
          </p>

          <div class="clearfix"></div>
          <br />

          <div>
            <h1><i class="fa fa-paw"></i> CodeMoves!</h1>
            <p>©2023 All Rights Reserved. CodeMoves! is an Accountant</p>
          </div>
        </div>
      </form>
    </section>
  </div>