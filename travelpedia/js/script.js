const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

function switchView() {
  var loginContainer = document.getElementById("loginContainer");
  var signUpContainer = document.getElementById("signUpContainer");

  var email = document.getElementById("usle");
  var fname = document.getElementById("f");

  loginContainer.classList.toggle("d-none");
  signUpContainer.classList.toggle("d-none");

  if (signUpContainer.classList.contains("d-none")) {
    email.focus();
  }

  if (loginContainer.classList.contains("d-none")) {
    fname.focus();
  }
}

function onLoadFocus() {
  document.addEventListener("DOMContentLoaded", function () {
    var userEmail = document.getElementById("usle");
    if (userEmail) {
      userEmail.focus();
    }
  });
}

function switchRMView() {
  var signUpRMContainer = document.getElementById("signUpRMContainer");
  var loginRMContainer = document.getElementById("loginRMContainer");

  var e = document.getElementById("le");
  var fn = document.getElementById("fn");

  signUpRMContainer.classList.toggle("d-none");
  loginRMContainer.classList.toggle("d-none");

  if (signUpRMContainer.classList.contains("d-none")) {
    e.focus();
  }

  if (loginRMContainer.classList.contains("d-none")) {
    fn.focus();
  }
}

function onRULoadFocus() {
  document.addEventListener("DOMContentLoaded", function () {
    var userEmail = document.getElementById("le");
    if (userEmail) {
      userEmail.focus();
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  var f = document.getElementById("f");
  var l = document.getElementById("l");
  var e = document.getElementById("e");
  var p = document.getElementById("p");
  var m = document.getElementById("m");
  var g = document.getElementById("g");

  function addEnterKeyListener(field) {
    if (field) {
      field.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
          event.preventDefault();

          signUp();
        }
      });
    }
  }
  addEnterKeyListener(f);
  addEnterKeyListener(l);
  addEnterKeyListener(e);
  addEnterKeyListener(p);
  addEnterKeyListener(m);
  addEnterKeyListener(g);
});

//sign up from index.php
function signUp() {
  var f = document.getElementById("f");
  var l = document.getElementById("l");
  var e = document.getElementById("e");
  var p = document.getElementById("p");
  var mo = document.getElementById("m");
  var g = document.getElementById("g");

  var form = new FormData();
  form.append("f", f.value);
  form.append("l", l.value);
  form.append("e", e.value);
  form.append("p", p.value);
  form.append("m", mo.value);
  form.append("g", g.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200 && request.status == 200) {
      var text = request.responseText;

      if (text == "success") {
        var acm = document.getElementById("accCreationSuccessModal");
        bm = new bootstrap.Modal(acm);
        bm.show();
      } else if (
        text == "Please enter your first name" ||
        text == "Your First Name must have less than 50 characters"
      ) {
        document.getElementById("starF").className = "d-block";

        var fname = document.getElementById("fname");
        fname.classList.add("red-placeholder");
        document.getElementsByClassName("1")[0].placeholder = text;

        f.focus();
        f.value = "";
      } else if (
        text == "Please enter your last name" ||
        text == "Your Last Name must have less than 50 characters"
      ) {
        document.getElementById("starL").className = "d-block";

        var lname = document.getElementById("lname");
        lname.classList.add("red-placeholder");
        document.getElementsByClassName("2")[0].placeholder = text;

        l.focus();
        l.value = "";
      } else if (
        text == "Please enter your Email" ||
        text == "Your Email must have less than 100 characters" ||
        text == "Invalid Email"
      ) {
        document.getElementById("starE").className = "d-block";

        var email = document.getElementById("email");
        email.classList.add("red-placeholder");
        document.getElementsByClassName("3")[0].placeholder = text;

        e.focus();
        e.value = "";
      } else if (
        text == "Please enter your Password" ||
        text == "Password must be between 8 - 24 characters"
      ) {
        document.getElementById("starP").className = "d-block";

        var pass = document.getElementById("pass");
        pass.classList.add("red-placeholder");
        document.getElementsByClassName("4")[0].placeholder = text;

        p.focus();
        p.value = "";
      } else if (
        text == "Please enter your Mobile Number" ||
        text == "Mobile Number must have 10 characters" ||
        text == "Invalid Mobile"
      ) {
        document.getElementById("starM").className = "d-block";

        mo.focus();
        mo.value = "";

        var mob = document.getElementById("mob");
        mob.classList.add("red-placeholder");
        document.getElementsByClassName("5")[0].placeholder = text;
      } else if (text == "User with the same Email or Mobile already exists") {
        var m = document.getElementById("userExistsModal");
        bm = new bootstrap.Modal(m);
        bm.show();
      } else {
        alert(text);
      }
    }
  };

  request.open("POST", "user/prcs/signUpProcess.php", true);
  request.send(form);
}

document.addEventListener("DOMContentLoaded", function () {
  var f = document.getElementById("fn");
  var l = document.getElementById("ln");
  var e = document.getElementById("em");
  var p = document.getElementById("pw");
  var m = document.getElementById("mb");

  function addEnterKeyListener(field) {
    if (field) {
      field.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
          event.preventDefault();

          signUpRM();
        }
      });
    }
  }
  addEnterKeyListener(f);
  addEnterKeyListener(l);
  addEnterKeyListener(e);
  addEnterKeyListener(p);
  addEnterKeyListener(m);
});

function signUpRM() {
  var f = document.getElementById("fn");
  var l = document.getElementById("ln");
  var e = document.getElementById("em");
  var p = document.getElementById("pw");
  var mb = document.getElementById("mb");
  var g = document.getElementById("g");

  var form = new FormData();
  form.append("f", f.value);
  form.append("l", l.value);
  form.append("e", e.value);
  form.append("p", p.value);
  form.append("m", mb.value);
  form.append("g", g.value);

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200 && request.status == 200) {
      var text = request.responseText;

      if (text == "success") {
        var acm = document.getElementById("accCreationSuccessModal");
        bm = new bootstrap.Modal(acm);
        bm.show();
        switchView();
      } else if (
        text == "Please enter your first name" ||
        text == "Your First Name must have less than 50 characters"
      ) {
        document.getElementById("starF").className = "d-block";

        f.focus();
        f.value = "";

        var fname = document.getElementById("fname");
        fname.classList.add("red-placeholder");
        document.getElementsByClassName("1")[0].placeholder = text;
      } else if (
        text == "Please enter your last name" ||
        text == "Your Last Name must have less than 50 characters"
      ) {
        document.getElementById("starL").className = "d-block";

        l.focus();
        l.value = "";

        var lname = document.getElementById("lname");
        lname.classList.add("red-placeholder");
        document.getElementsByClassName("2")[0].placeholder = text;
      } else if (
        text == "Please enter your Email" ||
        text == "Your Email must have less than 100 characters" ||
        text == "Invalid Email"
      ) {
        document.getElementById("starE").className = "d-block";

        e.focus();
        e.value = "";

        var email = document.getElementById("email");
        email.classList.add("red-placeholder");
        document.getElementsByClassName("3")[0].placeholder = text;
      } else if (
        text == "Please enter your Password" ||
        text ==
          "Password must be between 8 - 24 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character."
      ) {
        document.getElementById("starP").className = "d-block";

        p.focus();
        p.value = "";

        var pass = document.getElementById("pass");
        pass.classList.add("red-placeholder");
        document.getElementsByClassName("4")[0].placeholder = text;
      } else if (
        text == "Please enter your Mobile Number" ||
        text == "Mobile Number must have 10 characters" ||
        text == "Invalid Mobile"
      ) {
        document.getElementById("starM").className = "d-block";

        mb.focus();
        mb.value = "";

        var mob = document.getElementById("mob");
        mob.classList.add("red-placeholder");
        document.getElementsByClassName("5")[0].placeholder = text;
      } else if (text == "User with the same Email or Mobile already exists") {
        var m = document.getElementById("userExistsModal");
        bm = new bootstrap.Modal(m);
        bm.show();
      } else {
        alert(text);
      }
    }
  };

  request.open("POST", "../prcs/signUpRMProcess.php", true);
  request.send(form);
}

document.addEventListener("DOMContentLoaded", function () {
  var userMailField = document.getElementById("usle");
  var userPassField = document.getElementById("uslp");

  function addEnterKeyListener(field) {
    if (field) {
      field.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
          event.preventDefault();

          login();
        }
      });
    }
  }
  addEnterKeyListener(userMailField);
  addEnterKeyListener(userPassField);
});

function login() {
  var e = document.getElementById("usle");
  var p = document.getElementById("uslp");
  var rememberme = document.getElementById("rme");

  var invalidLoginAttempts = 0;
  var maxAttempts = 5;

  
  var r = new XMLHttpRequest();
  if(r.onreadystatechange){
  if(r.readyState == 4 && r.status == 200){
    var t = r.responseText;
      if (t == "success") {
        window.location = "user/ui/home.php";
      } else if (
        t == "Please enter your Email" ||
        t == "Your Email is Invalid !"
      ) {
        document.getElementById("starLe").className = "d-block";

        var email = document.getElementById("loginEmail");
        email.classList.add("red-placeholder");
        document.getElementsByClassName("6")[0].placeholder =
          "Please enter a valid email";

        e.focus();
        e.value = "";
      } else if (
        t == "Please enter your Password" ||
        t == "Password must be in between 8 - 24 characters"
      ) {
        document.getElementById("starLp").className = "d-block";

        var pass = document.getElementById("loginPass");
        pass.classList.add("red-placeholder");
        document.getElementsByClassName("7")[0].placeholder =
          "Please enter a valid password";

        p.focus();
        p.value = "";
      } else if (t == "Invalid Login Credentials") {
        const invalidCredsText = document.getElementById("ic");
        invalidCredsText.textContent = t;

        invalidLoginAttempts++;
        if (invalidLoginAttempts >= maxAttempts) {
          alert("You have exceeded the maximum number of login attempts.");
          document.querySelector('button[type="submit"]').disabled = true;
        }
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "logInProcess.php?e="+e+"&p="+p+"&rme="+rme, true);
  r.send(f);
}

document.addEventListener("DOMContentLoaded", function () {
  var emailField = document.getElementById("le");
  var passField = document.getElementById("lp");

  function addEnterKeyListener(field) {
    if (field) {
      field.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
          event.preventDefault();

          loginRM();
        }
      });
    }
  }

  addEnterKeyListener(emailField);
  addEnterKeyListener(passField);
});

function loginRM() {
  var e = document.getElementById("le");
  var p = document.getElementById("lp");
  var rememberme = document.getElementById("rme");

  var f = new FormData();
  f.append("e", e.value);
  f.append("p", p.value);
  f.append("r", rememberme.checked);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        window.location = "resortUserHome.php";
      } else if (
        t == "Please enter your Email" ||
        t == "Your Email is Invalid !"
      ) {
        document.getElementById("starLe").className = "d-block";

        var email = document.getElementById("loginEmail");
        email.classList.add("red-placeholder");
        document.getElementsByClassName("6")[0].placeholder =
          "Please enter a valid email";

        e.focus();
        e.value = "";
      } else if (
        t == "Please enter your Password" ||
        t == "Password must be in between 8 - 24 characters"
      ) {
        document.getElementById("starLp").className = "d-block";

        var pass = document.getElementById("loginPass");
        pass.classList.add("red-placeholder");
        document.getElementsByClassName("7")[0].placeholder =
          "Please enter a valid password";

        p.focus();
        p.value = "";
      } else if (t == "Invalid Login Credentials") {
        const invalidCredsText = document.getElementById("ic");
        invalidCredsText.textContent = t;
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/RMloginProcess.php", true);
  r.send(f);
}

var googleUser = {};
var startApp = function () {
  gapi.load("auth2", function () {
    // Retrieve the singleton for the GoogleAuth library and set up the client.
    auth2 = gapi.auth2.init({
      client_id:
        "679676425412-h3cica7tipm4dlamv4dpcrt8bjjgtug5.apps.googleusercontent.com",
      cookiepolicy: "single_host_origin",
      // Request scopes in addition to 'profile' and 'email'
      //scope: 'additional_scope'
    });
    attachSignin(document.getElementById("my-signin2"));
  });
};

function attachSignin(element) {
  console.log(element.id);
  auth2.attachClickHandler(
    element,
    {},
    function (googleUser) {
      document.getElementById("name").innerText =
        "Signed in: " + googleUser.getBasicProfile().getName();
      if (auth2.isSignedIn.get()) {
        var profile = auth2.currentUser.get().getBasicProfile();
        console.log("ID: " + profile.getId());
        console.log("Full Name: " + profile.getName());
        console.log("Given Name: " + profile.getGivenName());
        console.log("Family Name: " + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
      }
    },
    function (error) {
      alert(JSON.stringify(error, undefined, 2));
    }
  );
}



window.onload = function() {
  gapi.load(auth2, function(){
    gapi.auth2.initialise;
  })

  google.accounts.id.initialize({
      client_id: '679676425412-h3cica7tipm4dlamv4dpcrt8bjjgtug5.apps.googleusercontent.com',
      callback: handleCredentialResponse
  });
};

function handleCredentialResponse(response) {
  var id_token = response.credential;
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'user/prcs/googleLoginProcess.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  if(xhr.responseText = "success"){
    window.location = 'user/ui/home.php';
  }
  xhr.onload = function() {
      console.log('Signed in as: ' + xhr.responseText);
  };

  // Decode JWT token to extract user information (client-side for now, but validate on server-side)
  var profileObj = decodeJwt(id_token); // Replace with your JWT decoding logic

  // Build data to send
  var data = {
      idtoken: id_token,
      email: profileObj.email || '',
      firstName: profileObj.given_name || '',
      lastName: profileObj.family_name || '',
      profilePicture: profileObj.picture || '',
  };

  // Send data as a URL-encoded string
  xhr.send('data=' + encodeURIComponent(JSON.stringify(data)));
}

function decodeJwt(token) {
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join(''));
  return JSON.parse(jsonPayload);
}

var bm;
function forgotPassword() {
  var email = document.getElementById("le");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        alert(
          "Verification code has been sent to your email. Please check your inbox"
        );
        var m = document.getElementById("forgotPasswordModal");
        bm = new bootstrap.Modal(m);
        bm.show();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "user/prcs/forgotPasswordProcess.php?e=" + email.value, true);
  r.send();
}

var bm;
function forgotPasswordRM() {
  var email = document.getElementById("usle",value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        alert(
          "Verification code has been sent to your email. Please check your inbox"
        );
        var m = document.getElementById("forgotPasswordModal");
        bm = new bootstrap.Modal(m);
        bm.show();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "../prcs/forgotRUPasswordProcess.php?e=" + email, true);
  r.send();
}

function ShowPassword() {
  var i = document.getElementById("npi");
  var eye = document.getElementById("e1");

  if (i.type == "password") {
    i.type = "text";
    eye.className = "bi bi-eye";
  } else {
    i.type = "password";
    eye.className = "bi bi-eye-slash";
  }
}

function ShowPassword2() {
  var i = document.getElementById("rnp");
  var eye = document.getElementById("e2");

  if (i.type == "password") {
    i.type = "text";
    eye.className = "bi bi-eye";
  } else {
    i.type = "password";
    eye.className = "bi bi-eye-slash";
  }
}

function resetpw() {
  var email = document.getElementById("loginEmail");
  var np = document.getElementById("npi");
  var rnp = document.getElementById("rnp");
  var vcode = document.getElementById("vc");

  var f = new FormData();
  f.append("e", email.value);
  f.append("n", np.value);
  f.append("r", rnp.value);
  f.append("v", vcode.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        bm.hide();
        alert("Password reset success");
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/resetUserPassword.php", true);
  r.send(f);
}

function resetrupw() {
  var email = document.getElementById("loginEmail");
  var np = document.getElementById("npi");
  var rnp = document.getElementById("rnp");
  var vcode = document.getElementById("vc");

  var f = new FormData();
  f.append("e", email.value);
  f.append("n", np.value);
  f.append("r", rnp.value);
  f.append("v", vcode.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        bm.hide();
        alert("Password reset success");
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/resetRUPassword.php", true);
  r.send(f);
}

function logOut() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var txt = r.responseText;
      if (txt == "success") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "../prcs/logoutProcess.php", true);
  r.send();
}

function ruLogout() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        // window.location = "home.php";
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "../prcs/logoutRMProcess.php", true);
  r.send();
}

function changeImage() {
  var view = document.getElementById("viewImg"); //img tag
  var file = document.getElementById("profileImg"); //file chooser

  file.onchange = function () {
    var file1 = this.files[0];
    var url = window.URL.createObjectURL(file1);
    view.src = url;
  };
}

function updateProfile() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mobile");
  var no = document.getElementById("no");
  var street1 = document.getElementById("street1");
  var street2 = document.getElementById("street2");
  var province = document.getElementById("province");
  var district = document.getElementById("district");
  var city = document.getElementById("city");
  var image = document.getElementById("profileimg");

  var f = new FormData();
  f.append("fn", fname.value);
  f.append("ln", lname.value);
  f.append("m", mobile.value);
  f.append("no", no.value);
  f.append("s1", street1.value);
  f.append("s2", street2.value);
  f.append("p", province.value);
  f.append("d", district.value);
  f.append("c", city.value);

  if (image.files.length == 0) {
    var confirmation = confirm(
      "Are you sure that you don't want to update your profile image?"
    );

    if (confirmation) {
      alert("You have not selected any image");
    }
  } else {
    f.append("image", image.files[0]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success <br/> image data will load upon next sign in") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/updateUserProfileProcess.php", true);
  r.send(f);
}

function updateResortUserProfile() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var mobile = document.getElementById("mobile");
  var image = document.getElementById("profileimg");

  var f = new FormData();
  f.append("fn", fname.value);
  f.append("ln", lname.value);
  f.append("m", mobile.value);

  if (image.files.length == 0) {
    var confirmation = confirm(
      "Are you sure that you don't want to update your profile image?"
    );

    if (confirmation) {
      alert("You have not selected any image");
    }
  } else {
    f.append("image", image.files[0]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success <br/> image data will load upon next sign in") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/updateResortUserProfileProcess.php", true);
  r.send(f);
}

function changeResThumbnailImage() {
  var view = document.getElementById("viewResImg"); //img tag
  var file = document.getElementById("resImg"); //file chooser

  file.onchange = function () {
    var file1 = this.files[0];
    var url = window.URL.createObjectURL(file1);
    view.src = url;
  };
}

function changeResImage() {
  var img = document.getElementById("res-imguploader");

  img.onchange = function () {
    var fileCount = img.files.length;

    if (fileCount <= 4) {
      for (x = 0; x < fileCount; x++) {
        var file = this.files[x];
        var url = window.URL.createObjectURL(file);

        document.getElementById("ri" + x).src = url;
      }
    } else {
      alert("Please insert 4 or less than 4 images");
    }
  };
}

function addNewResort() {
  var rname = document.getElementById("rname");
  var rmobile = document.getElementById("rmobile");

  var image = document.getElementById("resImg");

  var rid = document.getElementById("rn");
  //input forms to disable upon receiving values
  var res_add_id = document.getElementById("ra-id");
  var res_img_id = document.getElementById("rin");
  var res_roo_id = document.getElementById("rrn");

  var f = new FormData();

  f.append("rname", rname.value);
  f.append("rmo", rmobile.value);

  if (image.files.length == 0) {
    var confirmation = confirm(
      "Are you sure that you don't want to update your profile image?"
    );

    if (confirmation) {
      alert("You have not selected any image");
    }
  } else {
    f.append("image", image.files[0]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Thumbnail Uploaded") {
        window.location.reload();
        res_add_id.classList.add("disabled");
        res_img_id.classList.add("disabled");
        res_roo_id.classList.add("disabled");

        res_add_id.value(rid);
        res_img_id.value(rid);
        res_roo_id.value(rid);

      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/addResortProcess.php", true);
  r.send(f);
}

function updateResort() {
  var rname = document.getElementById("rname");
  var rmobile = document.getElementById("rmobile");

  var image = document.getElementById("resImg");

  var f = new FormData();

  f.append("rname", rname.value);
  f.append("rmo", rmobile.value);

  if (image.files.length == 0) {
    var confirmation = confirm(
      "Are you sure that you don't want to update your profile image?"
    );

    if (confirmation) {
      alert("You have not selected any image");
    }
  } else {
    f.append("image", image.files[0]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Thumbnail Uploaded") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "ru/prcs/updateResortProcess.php", true);
  r.send(f);
}

// $(document).ready(function(){
//     $('#add-resort-form').submit(function(e){
//         e.preventDefault(); // to prevent the form from submitting the default way
//         $.ajax({
//             type: 'POST',
//             url: 'syncNewResortId.php',
//             data: $(this).serialize(),
//             success: function(response){
//                 var newResortId = response;
//                 $('#new-resort-id').text(newResortId);
//             }
//         });
//     });
// });

function addResortAddress() {
  var ra_id = document.getElementById("ra-id");
  var ra_no = document.getElementById("ra-no");
  var ra_street1 = document.getElementById("ra-street1");
  var ra_street2 = document.getElementById("ra-street2");
  var ra_city = document.getElementById("ra-city");

  var f = new FormData();

  f.append("ra-id", ra_id.value);
  f.append("rno", ra_no.value);
  f.append("rst1", ra_street1.value);
  f.append("rst2", ra_street2.value);
  f.append("rc", ra_city.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Resort address saved successfully") {
        alert(t);
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/addResortAddressProcess.php", true);
  r.send(f);
}

function addResortImages() {
  var rin = document.getElementById("rin");
  var img = document.getElementById("res-imguploader");

  var fileCount = img.files.length;

  var f = new FormData();
  f.append("rin", rin.value);

  for (var x = 0; x < fileCount; x++) {
    f.append("img" + x, img.files[x]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Resort Image(s) saved successfully") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/addResortImagesProcess.php", true);
  r.send(f);
}

function updateResortImages() {
  var rn = document.getElementById("rn");
  var img = document.getElementById("res-imguploader");

  var fileCount = img.files.length;

  var f = new FormData();
  f.append("rn", rn.value);

  for (var x = 0; x < fileCount; x++) {
    f.append("img" + x, img.files[x]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Resort Image(s) Updated successfully") {
        window.location.reload("travelpedia/ru/ui/updateResort.php");
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/updateResortImagesProcess.php", true);
  r.send(f);
}

function addResortRoomRates() {
  var rrn = document.getElementById("rrn");
  var drc = document.getElementById("drc");
  var hdr = document.getElementById("hdr");
  var fdr = document.getElementById("fdr");
  var trc = document.getElementById("trc");
  var htr = document.getElementById("htr");
  var ftr = document.getElementById("ftr");
  var src = document.getElementById("src");
  var hsr = document.getElementById("hsr");
  var fsr = document.getElementById("fsr");

  var f = new FormData();
  f.append("rrn", rrn.value);
  f.append("drc", drc.value);
  f.append("hdr", hdr.value);
  f.append("fdr", fdr.value);
  f.append("trc", trc.value);
  f.append("htr", htr.value);
  f.append("ftr", ftr.value);
  f.append("src", src.value);
  f.append("hsr", hsr.value);
  f.append("fsr", fsr.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Resort Rate(s) saved successfully") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/addRoomRatesProcess.php", true);
  r.send(f);
}

function updateResortRoomRates() {
  var rn = document.getElementById("rn");
  var drc = document.getElementById("drc");
  var hdr = document.getElementById("hdr");
  var fdr = document.getElementById("fdr");
  var trc = document.getElementById("trc");
  var htr = document.getElementById("htr");
  var ftr = document.getElementById("ftr");
  var src = document.getElementById("src");
  var hsr = document.getElementById("hsr");
  var fsr = document.getElementById("fsr");

  var f = new FormData();
  f.append("rn", rn.value);
  f.append("drc", drc.value);
  f.append("hdr", hdr.value);
  f.append("fdr", fdr.value);
  f.append("trc", trc.value);
  f.append("htr", htr.value);
  f.append("ftr", ftr.value);
  f.append("src", src.value);
  f.append("hsr", hsr.value);
  f.append("fsr", fsr.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Resort Rate(s) saved successfully") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/updateRoomRatesProcess.php", true);
  r.send(f);
}

function sendId(id) {
  var r = new XMLHttpRequest();
  var name = 'Hey';

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "success") {
        window.location = "updateResort.php";
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "../../sendResortIdProcess.php?id=&"+id, true);
  r.send();
}

function basicSearch(x) {
  var text = document.getElementById("basic_search_text");
  var select = document.getElementById("basic_search_select");

  var f = new FormData();
  f.append("t", text.value);
  f.append("s", select.value);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("basicSearchResult").innerHTML = t;
    }
  };

  r.open("POST", "../prcs/basicRSearchProcess.php", true);
  r.send(f);
}

function searchUser(x) {
  var text = document.getElementById("userSearchText");

  var f = new FormData();
  f.append("t", text.value);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("userSearchResult").innerHTML = t;
    }
  };

  r.open("POST", "../prcs/userSearchProcess.php", true);
  r.send(f);
}

function resortSearchUser(x) {
  var text = document.getElementById("resortUserSearchText");

  var f = new FormData();
  f.append("t", text.value);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("resortUserSearchResult").innerHTML = t;
    }
  };

  r.open("POST", "../prcs/resortUserSearchProcess.php", true);
  r.send(f);
}

function resortSearch(x) {
  var text = document.getElementById("resortSearchText");

  var f = new FormData();
  f.append("t", text.value);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("resortSearchResult").innerHTML = t;
    }
  };

  r.open("POST", "../prcs/resortSearchProcess.php", true);
  r.send(f);
}

function formatDateForSQL(dateString) {
  const dateParts = dateString.split("-");
  return `${dateParts[0]}-${dateParts[1]}-${dateParts[2]}`;
}

function searchInvoices(x) {
  var start = document.getElementById("start_date");
  var end = document.getElementById("end_date");

  var formattedStartDate = formatDateForSQL(start.value);
  var formattedEndDate = formatDateForSQL(end.value);

  sessionStorage.setItem("selectedStartDate", start.value);
  sessionStorage.setItem("selectedEndDate", end.value);

  var f = new FormData();
  f.append("s", formattedStartDate);
  f.append("e", formattedEndDate);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("invoiceSearchResult").innerHTML = t;
    }
  };

  r.open("POST", "../prcs/invoiceSearchProcess.php", true);
  r.send(f);
}

//store start & end date
document.addEventListener("DOMContentLoaded", function () {
  var start = document.getElementById("start_date");
  var end = document.getElementById("end_date");

  var storedStartDate = sessionStorage.getItem("selectedStartDate");
  var storedEndDate = sessionStorage.getItem("selectedEndDate");

  if (storedStartDate) {
    start.value = storedStartDate;
  }
  if (storedEndDate) {
    end.value = storedEndDate;
  }
});

function loadMainImg(id) {
  var img = document.getElementById("resortImg" + id).src;
  var tn = document.getElementById("tn_img");
  tn.style.backgroundImage = "url(" + img + ")";
}

function addToWishlist(resort_id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200 && r.status == 200) {
      var t = r.responseText;

      if (t == "removed") {
        document.getElementById("wish" + resort_id).innerHTML = "Add To Wishlist";
        document.getElementById("wishbtn" + resort_id).classList =
          "col-lg-10 offset-lg-1 btn btn-outline-danger mt-4 mb-4 fw-bold";
        document.getElementById("heart" + resort_id).classList =
          "bi bi-heart-fill text-dark fs-5";
        window.location.reload();
      } else if (t == "added") {
        document.getElementById("wish" + resort_id).innerHTML = "Remove from Wishlist";
        document.getElementById("wishbtn" + resort_id).classList =
          "col-lg-10 offset-lg-1 btn btn-outline-dark mt-4 mb-4 fw-bold";
        document.getElementById("heart" + resort_id).classList =
          "bi bi-heart-fill text-danger fs-5";
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET","../prcs/addToWishlistProcess.php?resort_id=" + resort_id, true);
  r.send();
}

//internal removal from user/ui/wishlist.php
function removeFromWishlist(resort_id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open(
    "GET",
    "../prcs/removeFromWishlistProcess.php?resort_id=" + resort_id,
    true
  );
  r.send();
}

//room value check from user/ui/singleResortView.php
function checkValue(double, triple, suite) {
  var i1 = document.getElementById("booked_double");
  var i2 = document.getElementById("booked_triple");
  var i3 = document.getElementById("booked_suite");

  if (i1.value > double) {
    alert("Maximum Double Rooms Available");
    i1.value = double;
  } else if (i2.value > triple) {
    alert("Maximum Triple Rooms Available");
    i2.value = triple;
  } else if (i3.value > suite) {
    alert("Maximum Suites Available");
    i3.value = suite;
  }
}

function payNow(resort_id) {
  var checkin = document.getElementById("start_date").value;
  var checkout = document.getElementById("end_date").value;
  var doublerooms = document.getElementById("booked_double").value;
  var triplerooms = document.getElementById("booked_triple").value;
  var suites = document.getElementById("booked_suite").value;
  var doubletype = document.getElementById("db").value;
  var tripletype = document.getElementById("tb").value;
  var suitetype = document.getElementById("sb").value;
  var price = document.getElementById("total_price").value;

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var t = req.responseText;
      var obj = JSON.parse(t);

      var mail = obj["mail"];
      var amount = obj["amount"];

      merchant_id = "1221408";
      merchant_secret = "MjI1NTE5MjcxNTcyMDU2MzQyOTM0MDA2MzQ3NDIwNTU0MjU5";

      if (t == "1") {
        alert("Please log in or sign up");
        window.location = "index.php";
      } else {
        // Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID:" + orderId);

          var order_id = obj["id"];
          var umail = obj["umail"];
          bookingReservation(
            order_id,
            resort_id,
            umail,
            checkin,
            checkout,
            doublerooms,
            triplerooms,
            suites,
            doubletype,
            tripletype,
            suitetype,
            price
          );

          // Note: validate the payment and show success or failure page to the customer
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
          // Note: Prompt user to pay again or show an error page
          console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
          // Note: show an error page
          console.log("Error:" + error);
        };

        // Put the payment variables here
        var payment = {
          sandbox: true,
          merchant_id: "1221408", // Replace your Merchant ID
          return_url:
            "http://localhost/travelpedia/user/ui/singleResortView.php?id" +
            resort_id, // Important
          cancel_url:
            "http://localhost/travelpedia/user/ui/singleResortView.php?id" +
            resort_id, // Important
          notify_url: "http://localhost/travelpedia/user/prcs/notify.php",
          order_id: obj["id"],
          hash: obj["hash"],
          items: obj["resort_name"],
          amount: amount,
          currency: "USD",
          first_name: obj["fname"],
          last_name: obj["lname"],
          email: mail,
          phone: obj["mobile"],
          address: obj["address"],
          city: obj["city"],
          country: "Sri Lanka",
        };

        // Show the payhere.js popup, when "PayHere Pay" is clicked
        // document.getElementById('payhere-payment').onclick = function (e) {
        payhere.startPayment(payment);
        // };
      }
    }
  };

  req.open("GET","../prcs/authorizeBooking.php?resort_id="+resort_id+"&price="+price,true);
  req.send();
}

function bookingReservation(
  booking_id,
  resort_id,
  umail,
  checkin,
  checkout,
  doublerooms,
  triplerooms,
  suites,
  doubletype,
  tripletype,
  suitetype,
  price
) {
  var f = new FormData();
  f.append("bid", booking_id);
  f.append("rid", resort_id);
  f.append("umail", umail);
  f.append("cin", checkin);
  f.append("cot", checkout);
  f.append("dr", doublerooms);
  f.append("tr", triplerooms);
  f.append("sr", suites);
  f.append("dty", doubletype);
  f.append("tty", tripletype);
  f.append("sty", suitetype);
  f.append("t", price);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "1") {
        window.location = "invoice.php?booking_id=" + booking_id;
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/bookingConfirmationProcess.php", true);
  r.send(f);
}

function customerViewInvoice(booking_id) {
  var url = "invoice.php?booking_id=" + booking_id;

  var r = new XMLHttpRequest();
  r.open("GET", url, true);
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200 && r.status == 200) {
      var newWindow = window.open();
      newWindow.document.write(r.responseText);
    }
  };
  r.send();
}



function viewInvoice(booking_id) {
  var f = new FormData();
  f.append("bid", booking_id);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "1") {
        window.location = "viewInvoice.php?booking_id=" + booking_id;
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/viewInvoiceProcess.php", true);
  r.send(f);
}

function printInvoice() {
  var body = document.body.innerHTML;
  var page = document.getElementById("page").innerHTML;
  document.body.innerHTML = page;
  window.print();
  document.body.innerHTML = body;
}

function viewAsPDF() {
  var page = document.getElementById("page"); // Replace with the ID of the element you want to convert

  html2canvas(page, {
    useCORS: true,
    onrendered: function(canvas) {
      var imgData = canvas.toDataURL("image/jpeg");
      var pdf = new jsPDF('p', 'mm', 'a4');

      var pageWidth = 210;
      var pageHeight = 297;
      var imgWidth = 210;
      var imgHeight = canvas.height * imgWidth / canvas.width;

      var heightLeft = imgHeight;
      var position = 0;

      pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
      heightLeft -= pageHeight;

      while (heightLeft >= 0) {
        position = heightLeft - imgHeight;
        pdf.addPage();
        pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;
      }

      // Create a Blob URL for the generated PDF
      var blob = pdf.output('blob');
      var url = URL.createObjectURL(blob);
      
      // Open the Blob URL in a new tab
      var tab = window.open();
      tab.location.href = url;
    }
  });
}



function adminSignIn() {
  var email = document.getElementById("e");

  var f = new FormData();
  f.append("e", email.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        var adminVerificationModal =
          document.getElementById("verificationModal");
        av = new bootstrap.Modal(adminVerificationModal);
        av.show();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/adminVerificationProcess.php", true);
  r.send(f);
}

function verify() {
  var verification = document.getElementById("vcode");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        av.hide();
        window.location = "adminDashboard.php";
      } else {
        alert(t);
      }
    }
  };

  r.open(
    "GET",
    "../prcs/verificationProcess.php?v=" + verification.value,
    true
  );
  r.send();
}

function blockUser(email) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var txt = request.responseText;
      if (txt == "blocked") {
        document.getElementById("ub" + email).innerHTML = "Unblock";
        document.getElementById("ub" + email).classList =
          "col-4 offset-2 btn btn-outline-success";
      } else if (txt == "unblocked") {
        document.getElementById("ub" + email).innerHTML = "Block";
        document.getElementById("ub" + email).classList =
          "col-4 offset-2 btn btn-outline-dark";
      } else {
        alert(txt);
      }
    }
  };

  request.open("GET", "../prcs/blockUserProcess.php?email=" + email, true);
  request.send();
}

function deleteUser(email) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if ((t = "success")) {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "../prcs/deleteUserProcess.php?email=" + email, true);
  r.send();
}

function blockResortUser(email) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var txt = request.responseText;
      if (txt == "blocked") {
        document.getElementById("rub" + email).innerHTML = "Unblock";
        document.getElementById("rub" + email).classList =
          "col-10 offset-1 btn btn-outline-success";
      } else if (txt == "unblocked") {
        document.getElementById("rub" + email).innerHTML = "Block Resort User";
        document.getElementById("rub" + email).classList =
          "col-10 offset-1 btn btn-outline-dark";
      } else {
        alert(txt);
      }
    }
  };

  request.open(
    "GET",
    "../prcs/blockResortUserProcess.php?email=" + email,
    true
  );
  request.send();
}

function blockResort(resort_id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var txt = request.responseText;
      if (txt == "blocked") {
        document.getElementById("rb" + resort_id).innerHTML = "Unblock";
        document.getElementById("rb" + resort_id).classList =
          "col-10 offset-1 btn btn-outline-success";
      } else if (txt == "unblocked") {
        document.getElementById("rb" + resort_id).innerHTML = "Block Resort";
        document.getElementById("rb" + resort_id).classList =
          "col-10 offset-1 btn btn-outline-dark";
      } else {
        alert(txt);
      }
    }
  };

  request.open(
    "GET",
    "../../blockResortProcess.php?resort_id=" + resort_id,
    true
  );
  request.send();
}

function blockResortId(resort_id) {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var txt = request.responseText;
      if (txt == "blocked") {
        document.getElementById("rb" + resort_id).innerHTML = "Unblock Resort";
        document.getElementById("rb" + resort_id).classList =
          "col-lg-8 offset-lg-2 btn btn-outline-success mt-2 mb-2 fw-bold";
      } else if (txt == "unblocked") {
        document.getElementById("rb" + resort_id).innerHTML = "Block Resort";
        document.getElementById("rb" + resort_id).classList =
          "col-lg-8 offset-lg-2 btn btn-outline-info mt-2 mb-2 fw-bold";
      } else {
        alert(txt);
      }
    }
  };

  request.open(
    "GET",
    "../../blockResortProcess.php?resort_id=" + resort_id,
    true
  );
  request.send();
}

//splits mm/dd/yyyy format
function formatDateToISO(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  return `${year}-${month}-${day}`;
}

//checks multiple bookings on same day
function checkOverlappingBookings() {
  const startDateInput = document.getElementById("start_date");
  const endDateInput = document.getElementById("end_date");

  // parsing dates
  const selectedStartDate = new Date(startDateInput.value);
  const selectedEndDate = new Date(endDateInput.value);

  // checking if dates are numbers
  if (isNaN(selectedStartDate) || isNaN(selectedEndDate)) {
    return "Invalid Dates";
  }

  // sends dates for formatting
  const formattedStartDate = formatDateToISO(selectedStartDate);
  const formattedEndDate = formatDateToISO(selectedEndDate);

  const r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState === 4) {
      if (r.status === 200) {
        var response = r.responseText;

        if (response.hasOverlappingBookings) {
          //error on bootstrap modal
          document.getElementById("modalTitle").innerText = "Booking Error";
          document.getElementById("modalBody").innerText = response;
          const modal = new bootstrap.Modal(
            document.getElementById("bookingErrorModal")
          );
          modal.show();
        } else {
          // No overlapping bookings
        }
      } else {
        prompt("Error checking for overlapping bookings");
      }
    }
  };

  r.open(
    "GET",
    "../prcs/checkOverlappingBookings.php" +
      `?start_date=${formattedStartDate}&end_date=${formattedEndDate}`,
    true
  );
  r.send();
}

function sendAdminMessage(email) {
  var txt = document.getElementById("msgtxt" + email).value;

  var f = new FormData();
  f.append("t", txt);
  f.append("e", email);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "success") {
        msgbox(email);
        msgbox2(email);
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../../sendAdminMessageProcess.php", true);
  r.send(f);
}

function msgbox(email) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("msg_box" + email).innerHTML = t;
      document.getElementById("msgtxt" + email).value = "";
      var box = document.getElementById("msg_box" + email);
      box.scrollTop = box.scrollHeight;
    }
  };

  r.open("GET", "../../messageBoxProcess.php?e=" + email, true);
  r.send();
}

function msgbox2(email) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("msg_box2" + email).innerHTML = t;
      document.getElementById("msgtxt" + email).value = "";
      var box = document.getElementById("msg_box2" + email);
      box.scrollTop = box.scrollHeight;
    }
  };

  r.open("GET", "../../messageBox2Process.php?e=" + email, true);
  r.send();
}

var cam;
function contactAdmin(email) {
  var m = document.getElementById("contactAdmin");
  cam = new bootstrap.Modal(m);
  cam.show();
}

function viewMessages(email) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("chat_box").innerHTML = t;
    }
  };

  r.open("GET", "../prcs/viewMessageProcess.php?e=" + email, true);
  r.send();
}

function send_msg() {
  // var email = document.getElementById("rmail");
  var email = "sanjunadelpitiya1@gmail.com";
  var txt = document.getElementById("msg_txt").value;

  var f = new FormData();
  f.append("e", email);
  f.append("t", txt);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        alert(t);
        // window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "../prcs/sendMessageProcess.php", true);
  r.send(f);
}

var mm;
function viewMsgModal(email) {
  var m = document.getElementById("userMsgModal" + email);
  mm = new bootstrap.Modal(m);
  mm.show();
}

function advancedSearch(x) {
  var txt = document.getElementById("t");
  var province = document.getElementById("province");
  var district = document.getElementById("district");
  var city = document.getElementById("city");
  var from = document.getElementById("pf");
  var to = document.getElementById("pt");
  var sort = document.getElementById("s");

  var f = new FormData();
  f.append("t", txt.value);
  f.append("p", province.value);
  f.append("d", district.value);
  f.append("c", city.value);
  f.append("pf", from.value);
  f.append("to", to.value);
  f.append("s", sort.value);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      document.getElementById("advancedSearchArea").innerHTML = t;
    }
  };

  r.open("POST", "../prcs/advancedSearchProcess.php", true);
  r.send(f);
}
