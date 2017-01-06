  function randomString(length, chars) {
            var email=document.getElementById("p_email").value;
            var a = email.substr(0, 1);
            var b = email.substr(email.indexOf("."), 2);
            var mask = '';
            if (chars.indexOf('a') > -1) mask += 'abcdefghijklmnopqrstuvwxyz';
            if (chars.indexOf('A') > -1) mask += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if (chars.indexOf('#') > -1) mask += '0123456789';
            if (chars.indexOf('!') > -1) mask += '!@#$%&*_+-=:;<>?,.';
            var result = '';
            for (var i = length; i > 0; --i) result += mask[Math.round(Math.random() * (mask.length - 1))];
                document.getElementById("pwd").value = a+b+"!@pf"+result;
            return result;
    //document.getElementById("pwd").innerHTML = result;
    
}

function validarEmail() {
    var email=document.getElementById("p_email").value;
    var a = email.substr(1, 1);
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
        alert("Error: La dirección de correo " + email + " es incorrecta.");
        document.getElementById("pwd").value = "";
    }
    else{
        randomString(4, '#A!');
    }
    }