function login(){
  var email = $("#email").val();
  var password = $("#password").val();
  console.log(email + password);

  $.get( "http://152.23.118.214/cats/server_side/login.php?email=" + email + "&password=" + password, function( data ) {
  $( ".result" ).html( data );
  console.log(data);
  console.log(JSON.parse(data));
});
  return false; 
}
