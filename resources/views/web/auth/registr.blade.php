<div id="register" class="animate form registration_form">
    <section class="login_content">
      <form action="{{route('signup.post')}}" method="POST">
          @csrf
        <h1>Create Account</h1>
        <div>
          <input type="text" class="form-control" name="name" placeholder="Username" required="" />
        </div>
        <div>
          <input type="email" class="form-control" name="email" placeholder="Email" required="" />
        </div>
        <div>
          <input type="password" class="form-control" name="password" placeholder="Password" required="" />
        </div>
        <div>
          <button class="btn btn-default" type="submit">Submit</button>
          
        </div>

        <div class="clearfix"></div>

        <div class="separator">
          <p class="change_link">Already a member ?
            <a href="#signin" class="to_register"> Log in </a>
          </p>

          <div class="clearfix"></div>
          <br />

          <div>
            <h1><i class="fa fa-paw"></i> CodeMoves!</h1>
            <p>©2023 All Rights Reserved. CodeMoves! is an Accountant.</p>
          </div>
        </div>
      </form>
    </section>
  </div>