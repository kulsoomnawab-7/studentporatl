<?php
use App\Models\Labs;
use App\Models\LabSystem;
use App\Models\facultyreg;

?>


<!doctype html>
<html lang="en">
  <head>
    <title>Lab System</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    
/* This is to be able to center the content in the middle of the page; */
.cat label span {
    text-align: center;
    padding: 3px 0;
    display: block;
  }
  
  .cat label input {
    position: absolute;
    display: none;
    color: #fff !important;
  }
  /* selects all of the text within the input element and changes the color of the text */
  .cat label input + span{color: #fff;}
  
  
  /* This will declare how a selected input will look giving generic properties */
  .cat input:checked + span {
      color: #ffffff;
  }
  
  /*
  This following statements selects each category individually that contains an input element that is a checkbox and is checked (or selected) and chabges the background color of the span element.
  */
  @media (max-width: 896px) {
        #container
        {
          margin-top: 8px;
        }
      }
      #img
      {
        background-image: url("images/pc (2).png");

      }
      .centered {
  position: absolute;
  top: 48%;
  left: 55%;
  transform: translate(-50%, -50%);
}
#css
{
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: linear-gradient(312.25deg, #008E6B 0%,     rgba(255, 255, 255, 0) 66.19%);
  /* width: 300px; */
  text-align: center;
  height: 240px;
  outline-style: solid;
  border-radius: 16px;
  position: relative;
}

  </style>
    </head>
  <body id="img">
<nav class="navbar navbar-expand-sm navbar-light bg-light">
  <!-- <a class="navbar-brand" href="#">Navbar</a> -->
  <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
      aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavId">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link ml-5" href="/register_complains" style="color:black;">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/view_complains" style="color:black;">Complain View</a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
        <div class="dropdown-menu" aria-labelledby="dropdownId">
          <a class="dropdown-item" href="#">Action 1</a>
          <a class="dropdown-item" href="#">Action 2</a>
        </div>
      </li> -->
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0"> -->

    <li class="dropdown nav-icon mr-2" style="list-style:none;">
        <a href="#" data-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user" style="color:black;">
            <div class="d-lg-inline-block">
                <i data-feather="mail"></i>{{session('sessionusername')}}
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <!-- <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
            <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
            <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> -->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i data-feather="log-out"></i> 
            <form method="POST" action="{{ route('logout') }}" class="inline">
						@csrf
						<button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
							{{ __('Log Out') }}
						</button>
					</a>
        </div>
    </li>
      <!-- <ul style="list-style:none;">
        <li>{{session('sessionusername')}}  </li>
      </ul> -->
      <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
    </form>
  </div>
</nav>
<br>

<!-- <form method="POST" action="{{ route('logout') }}" class="inline">
						@csrf
						<button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
							{{ __('Log Out') }}
						</button>
					</form> -->
<h1 class="text-uppercase text-center mb-3 text-white">Register Lab Complains</h1><br>
  <div class="container-fluid">
    <div class="row">
    @foreach($lab as $f)
      <div class="col-md-3 mt-1" id="css">
        <center>
          <button type="button"><a href="/lab_systems/{{$f->id}}" name="labin" class="labinput" id="updatebtn" data-id="" style="text-transform: capitalize; color:white;"><h1 class="centered" style="font-size:3rem;">{{$f->lab_number}}</h1></a></button>
        </center>
       
      </div>
  @endforeach

  <div class="col-md-3">
<?php
  $login =DB::table("facultyregs")->where(["email"=>session('sessionuseremail')])->first();
  ?>
    @if(isset($login))
      @if($login->role==2)
      <div class="col-md-12 mt-1" id="css">
        <center>
          <button type="button"><a href="/all_lab" name="labin" class="labinput" style="text-transform: capitalize; color:white;"><h1 class="centered" style="font-size:3rem;">All Lab</h1></a></button>
        </center>
       
      </div>
      <!-- <button type="button"><a href="/all_lab" name="labin" class="labinput" id="updatebtn css" data-id="" style="text-transform: capitalize; color:white;"><h1 class="centered" style="font-size:3rem;">All Lab</h1></a></button> -->
      <!-- <button type="button"><a href="/all_lab" name="labin" class="labinput" id="css" style="text-transform: capitalize; color:white;"><h1 class="centered" style="font-size:3rem;">All Lab</h1></a></button> -->
      @endif
    @endif
  </div>
    </div>
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
  <script>
//     function myFunction2() {
//   alert("Hello! I am an alert box!");
// }



    function myFunction() 
    {
    window.location.replace("/register_form");
  }

$(document).ready(function(){
$(document).on("click" , "#updatebtn" ,function(){
  //alert("clicked");
  var uid = $(this).attr("data-id");
  //console.log(uid);
  //$("updatemodal").modal("show");

  $.ajax({

    url:"/getdataevent",
    type:"POST",
    data:"userid="+uid+
    "&_token={{csrf_token()}}",

    success:function(result)
    {
      $("#updatemodal").modal("show");
      var res = JSON.parse(result);
      $("#userid").val(res["id"]);

      var labid =  res["id"]; 
      console.log(labid);
      $.ajax({
            url:"{{URL::to('/getcity')}}",
            type:"POST",
            data:'labid='+labid+
            '&_token={{csrf_token()}}'
            ,
            success:function(result)
            {
                $("#labsystem").html(result);
            },
          });
            cache:false


    },

    error:function()
    {
      alert("error found");
    }

  });
});
});

$(document).ready(function(){
    $(".labinput").change(function(){
        var labid  = $(this).val();
        console.log(labid);
        $.ajax({
            url:"{{URL::to('/getcity')}}",
            type:"POST",
            data:'labid='+labid+
            '&_token={{csrf_token()}}'
            ,
            success:function(result)
            {
                $("#labsystem").html(result);
            },
            cache:false
        });
    });
  });

  // ____________________________________________________________________


  $(document).ready(function(){

$(document).on("click" , "#updatebtn1" ,function(){
  //alert("clicked");
  var uid = $(this).attr("data-id");
  //console.log(uid);
  //$("updatemodal").modal("show");

  $.ajax({

    url:"/getdataevent_",
    type:"POST",
    data:"userid_="+uid+
    "&_token={{csrf_token()}}",

    success:function(result)
    {
      $("#compmodal").modal("show");
      var res = JSON.parse(result);
      $("#userid_1").val(res["Lab_id"]);
      $("#hostname").val(res["Host_Name"]);
      
      var labid =  res["id"]; 
      console.log(labid);
      $.ajax({
            url:"{{URL::to('/getcity')}}",
            type:"POST",
            data:'labid='+labid+
            '&_token={{csrf_token()}}'
            ,
            success:function(result)
            {
                $("#labsys").html(result);
            },
          });
            cache:false


    },

    error:function()
    {
      alert("error found");
    }

  });
});
});

$(document).ready(function(){
    $(".labit2").change(function(){
        var labid  = $(this).val();
        // console.log(labid);
        $.ajax({
            url:"{{URL::to('/getcity')}}",
            type:"POST",
            data:'labid='+labid+
            '&_token={{csrf_token()}}'
            ,
            success:function(result)
            {
                $("#labsys").html(result);
            },
            cache:false
        });
    });
  });


  $(document).ready(function(){
    $.ajaxSetup({
   headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});

    $(document).on("click",".lab_id1",function(e){
    // alert("The paragraph was clicked.");
    var id = $(this).val();
    var user = $('#userid').val();
    console.log(id);
    $.ajax({
      url:'/temp_comp/'+id+'/'+user,
      type: 'POST',
      success: function(data){
        console.log(data)
      }
    })

  //  e.preventDefault();

  //  jQuery.ajax({
  //   url:"{{URL::to('/temp_comp')}}",
  //     data:jQuery('#submitbtn').serialize(),
  //     type:'POST',
  //     success:function(result){
  //       // console.log(result);
  //       // window.load();
  //     }
  //  });
  // myFunc.call(this);
  //   // your code here
    // return true;


});
});

// jQuery('#submitbtn').submit(function(e)
// {
//   e.preventDefault();
//   alert("The paragraph was clicked.");
//   jQuery.ajax({
//     url:"{{URL::to('temp_comp')}}",
//       data:jQuery('#submitbtn').serialize(),
//       type:'POST',
//       success:function(result){
//         console.log(result);
//       }
//    });
// });

// $(document).ready(function(){
//     $('input[type="checkbox"]').click(function(){
//     if($(this).prop("checked") == true)
//     {      
//       //console.log($(this).val());
//       $.ajax({
//           url:"/updatestatuscompany1",
//           type:"POST",
//           data:"userid="+$(this).val()+
//           '&_token={{csrf_token()}}',
//           success:function()
//           {
//             alert("Status Updated");
//             window.location="/adminapprovecompany";
//           },
//           error:function()
//           {
//             alert("Error found");
//           }
//       });
//     }

//     else if($(this).prop("checked") == false)
//     {      

//       $.ajax({
//         url:"/updatestatuscompany0",
//         type:"POST",
//         data:"userid1="+$(this).val()+
//         '&_token={{csrf_token()}}',
//         success:function()
//         {
//           alert("Status Updated");
//           window.location="/adminapprovecompany";
//         },
//         error:function()
//         {
//           alert("Error found");
//         }
//       });
//     }
//     });

//   });
  


  </script>
  
  </body>
</html>