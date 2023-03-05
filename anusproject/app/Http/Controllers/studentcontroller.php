<?php

namespace App\Http\Controllers;
use App\Models\Labs;
use App\Models\hardware_complain;
use App\Models\software_complain;
use App\Models\network_issue;
use App\Models\other_issue;
use App\Models\facultyreg;

use Illuminate\Support\Carbon;

use App\Models\user;
use App\Models\usermodels;
use App\Models\temp_verfy;
use App\Models\student;
use App\Models\temp_comp;


use Mail;
use App\Models\LabSystem;
use App\Models\Complain_Master;
use DB;                                                                                             
use Illuminate\Http\Request;

class studentcontroller extends Controller
{
    public function get_email()
    {
        return view("/code_match_");
    }

    public function code_match()
    {
        //$user =DB::table("usermodels")->where("email", session('sessionuseremail'))->first();
        $fetch = temp_verfy::all();
        return view("/code_match" , compact ('fetch'));
    }

    public function input(Request $res)
    {
        //taking input
        $get_Email = $res->emailinput;

        //checking from aptech user data
        $studcheck =DB::table("students")->where("Student_email", $get_Email)->first();
        if(isset($studcheck))
        {
            $v_code = $this->generateUniqueCode();
            $user =DB::table("usermodels")->where("email", $get_Email)->first();
            $email_match =DB::table("students")->where("Student_email", $get_Email)->first();
    
            if(isset($user))
            {
                echo "<script>alert('Email Already Exists.')
                window.location.href='/login'
                </script>";
            }
            else
            {
                $studcheck = new temp_verfy();
                $studcheck->email = $get_Email;
                $studcheck->code = $v_code;
                $studcheck->save();
                
                try
                {
                    $data= ['name'=> $studcheck->name ,'data'=> $studcheck->email , 'code'=>$studcheck ->code ]; 
                    //$data= Auth::User()->name;
                    $user ['to'] = $studcheck->email;    
                    Mail::send('email_user',$data ,function($messages) use ($user)
                    {
                        $messages->to($user ['to']);
                        $messages->subject('Registration Code for Online Varsity');
                    });

                    return redirect("/code_match");
            
                }
                catch(Exception $ex)
                {
                    echo $ex->getMessage();
                    die;
                }
            }
                
        }else{
            echo 
            "<script>alert('Record Not Found.')
            window.location.href='/'
            </script>";
        }
        
    }


    public function code_match_(Request $req)
    {   
        $email =$req->emailinput;
        $codes =$req->code0;
        $codes =$codes.$req->code1;
        $codes =$codes.$req->code2;
        $codes =$codes.$req->code3;
        $codes =$codes.$req->code4;
        $codes =$codes.$req->code5;

        //$studcheck =DB::table("students")->where("Student_email", $email)->first();
        //$req->emailinput;

        $login = temp_verfy::where("email", $email)->first();
        $code_check = $req->code;
        $user =DB::table("usermodels")->where("email", $email)->first();
        $login2 =DB::table("students")->where("Student_email", $email)->first();
        $pass =$req->passwordinput;
        $conpass =$req->coninput;

        if(isset($codes))
        { 
            if($codes   ==  $login->code)                    
            {
                $fetch = temp_verfy::all();
                echo "<script>alert('Verfication Code Match.')
                window.location.href='/register'
                </script>";
            }
            else
            {
                echo "<script>alert('Wrong Verfication Code.')
                window.location.href='/code_match'
                </script>";
            }
        }
        else
        {
            echo "<script>alert('Please enter code and try again.')
            window.location.href='code_match'
            </script>";
        }
            
    }
    public function registerget()
    {
        $fetch = temp_verfy::all();
        $lab = Labs::all();
        $hardware = hardware_complain::all();
        $software = software_complain::all();
        $Network = network_issue::all();
        return view ("/register" ,compact('fetch','hardware','software','Network'));
    }

    public function registerpost(Request $req)
    {
        $email = $req->emailinput;

        $login = temp_verfy::where("email", $email)->first();
        $login2 =DB::table("students")->where("Student_email", $email)->first();
        $pass =$req->passwordinput;
        $conpass =$req->coninput;

         if(strlen($pass) < 8)
        {
            echo "<script>alert('Woops! Password cannot be less the 8 characters.')
            window.location.href=''
            </script>";
            return;
        } 
        else
        { 
            if($pass == $conpass)
            {   
                session(["sessionuseremail"=>$email]);
                session(["sessionusername"=>$login2->Std_Name]);
    
                //forgot 
                if($login->status ==8)
                { 

                    $user = usermodels::where("email", $email)->first();  
                    $user->password = $req->passwordinput;
                    $user->update();
                }else{ 
                    $user = new usermodels();
                    $user->email = $req->emailinput;    
                    $user->password = $req->passwordinput;
                    $user->role = 1;
                    $user->save();

                    // echo "Registerd";
                    $data= ['Std_Name'=> $login2->Std_Name ,'data'=> $login->email]; 
                    $user ['to'] = $login->email;  

                    Mail::send('email_register',$data ,function($messages) use ($user)
                    {
                        $messages->to($user ['to']);
                        $messages->subject('User Registration Completed!');
                    }); 

                }
                //$userid = $email;

                $systemcheck =temp_comp::where('email' , $email)->first();
    
                if(isset($systemcheck))
                {
                    // echo "Email ALready Registerd";
                }
                else
                {
                    $systemcheck = new temp_comp();
                    $systemcheck->email = $email;
                    $systemcheck->save();
                }

                $fetch = temp_verfy::all();
                $fetch = LabSystem::all();
                $lab = Labs::whereNotIn('lab_number' , ['seminar'])->get();
                $hardware = hardware_complain::all();
                $software = software_complain::all();
                $Network = network_issue::all();

                return view("/register_complains" ,compact( 'fetch','lab','hardware','software','Network'));

            }
            else
            {   
                echo 
                "<script>alert('Password and Confirm password does not match.')
                window.location.href='/register'
                </script>";
            }                
        } 

    }

    public function register_complains(Request $req)
    {
        if(isset($request->emailinput)){
            $email = $request->emailinput;
        }else{
            $email = session('sessionuseremail');
        }
        $fcheck =DB::table("facultyregs")->where('email' ,$email)->first();
        $schecm =DB::table("usermodels")->where('email' ,$email)->first();

        //to disguise between faculty & Student
        if(isset($fcheck))
        {
           $login =DB::table("facultyregs")->where('email' ,$email)->first();
        }elseif(isset($schecm)){
            $login =DB::table("usermodels")->where('email' ,$email)->first();
        }   

        if(isset($email))
        {
            $systemcheck = temp_comp::where('email' , $email)->first();
            if(isset($systemcheck))
            {
                $systemcheck = temp_comp::where('email' , $email)->first();
                $systemcheck->email= $email;
                $systemcheck->update();
            }
            else
            {
                $systemcheck = new temp_comp();
                $systemcheck->email= $email;
                $systemcheck->save();
            }

            $id = $req->inputuserid;
            $fetch = LabSystem::all();

        //    echo  'HELLO'.$login->role;
           if($login->role==1)
           {
                $lab = Labs::whereNotIn('lab_number' , ['seminar'])->get();
           }
           else if($login->role==2)
           {
                $lab =  Labs::all();
           }
           
            $hardware = hardware_complain::all();
            $Software = software_complain::all();
            $Network = network_issue::all();
            // $Other = other_issue::all();
            $system = temp_comp::where('email' , $email)->get();
            
            return view("/register_complains" ,compact('fetch','lab','system','hardware','Software','Network'));
        }
        else
        {
            echo 
            "<script>alert('Please Login First.')
            window.location.href='/login'
            </script>";
        }
    }

    public function facultylogin()
    {
        return view("faculty_login");
    }

    public function facultyregister()
    {
        return view("faculty_register");
    }
    public function regpost_(Request $req)
    {
        $user = new facultyreg();
        $user->name = $req->nameinput;    
        $user->email = $req->emailinput;    
        $user->password = $req->passwordinput;
        $user->role = 2;
        $user->save();
        return redirect("/faculty")->with("success" , "company has been register");
       
    }
    public function facultyget(Request $req)
    {
        $email =$req->emailinput;
        $password= $req->passwordinput;
        $userid = session('sessionuseremail'); 

        $login =DB::table("facultyregs")->where(["email"=>$email , "password"=>$password])->first();
        // $studcheck =DB::table("students")->where(["Student_email"=>$email])->first();
        $userid = $req->emailinput;

        if($login!="")
        {
            if(isset($email))
            {
                $systemcheck =temp_comp::where('email' , $email)->first();
                // echo $systemcheck;
    
                if(isset($systemcheck))
                {
                    ;
                }
                else
                {
                    $systemcheck = new temp_comp();
                    $systemcheck->email=$req->emailinput;
                    $systemcheck->save();
                }
            }

            if($login->role=="2")
            {

                $systemcheck =temp_comp::where('email' , $email)->first();  
                session(["sessionid"=>$login->id]);
                session(["sessionuseremail"=>$login->email]);
                session(["sessionusername"=>$login->name]);
                $fetch = LabSystem::all();
                $lab = Labs::all();
                $hardware = hardware_complain::all();
                $software = software_complain::all();
                $Network = network_issue::all();
                // $other = other_issue::all();

                return view("/register_complains" ,compact( 'fetch','lab','hardware','software','Network'));

            }
           
        }

        else
        {
            return redirect()->back()->with("errormessage" , "Record Not Found");

        }
    }

    public function loginadminpost(Request $req)
    {
        $email =$req->emailinput;
        $password= $req->passwordinput;
        $userid = session('sessionuseremail');

        $login =DB::table("usermodels")->where(["email"=>$email , "password"=>$password])->first();
        $studcheck =DB::table("students")->where(["Student_email"=>$email])->first();
        $userid = session('sessionuseremail');

        if($login!="")
        {
            if(isset($email))
            {
                // $userid = session('sessionuseremail');
                // $emailse=session('sessionuseremail');
                $systemcheck =temp_comp::where('email' , $email)->first();
                // echo $systemcheck;
    
                if(isset($systemcheck))
                {
                    ;
                }
                else
                {
                    $systemcheck = new temp_comp();
                    $systemcheck->email = $email;
                    $systemcheck->save();
                }
            }

            if($login->role=="1")
            {
                session(["sessionid"=>$login->id]);
                session(["sessionuseremail"=>$login->email]);
                session(["sessionusername"=>$studcheck->Std_Name]);

                $fetch = LabSystem::all();
                $lab = Labs::whereNotIn('lab_number' , ['seminar'])->get();
                $hardware = hardware_complain::all();
                $software = software_complain::all();
                $Network = network_issue::all();
                // $other = other_issue::all();

                return view("/register_complains" ,compact( 'fetch','lab','hardware','software','Network'));
            }
            else if($login->role=="0")
            {   
                session(["sessionid"=>$login->id]);
                session(["sessionuseremail"=>$login->email]);

                $fetch = LabSystem::all();
                $lab = Labs::whereNotIn('lab_number' , ['seminar'])->get();
                $hardware = hardware_complain::all();
                $software = software_complain::all();
                $Network = network_issue::all();
                // $other = other_issue::all();

                $mytime = Carbon::now();
                $mytime->toDateTimeString();
                // echo $mytime;

                $fetchprevious = Complain_Master::whereDate('Date_of_Complain','<',$mytime)->get();
                // echo $fetchprevious;
                $fetchtoday = Complain_Master::whereDate('Date_of_Complain','=',$mytime)->get();

                $fetch = Complain_Master::whereDate('Date_of_Complain','>',$mytime)->get();

                return view("/admin_dashboard" ,compact( 'fetchprevious','fetchtoday','fetch','software','Network'));
            }

        }
        else
        {
            return redirect()->back()->with("errormessage" , "Record Not Found");

        }
    }
    public function adminget()
    {
        return view("/login");
    }
   
    
    public function generateUniqueCode()
    {
        // $code = random_int(1000000, 999999);
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        return  $code;
    }

    
    public function lab_systems_()
    {
        $user =DB::table("usermodels")->where("email", session('sessionuseremail'))->first();
        $fetch = LabSystem::all();
        return view("/lab_systems" , compact ('fetch')); 
    }
    

    public function lab(Request $req)
    {
        $labid = $req->post("userid");
        return view("/register_complains" , compact('fetch' ,'lab'));
    }

    public function lab_systems()
    {
        
        $lab = new LabSystem();
        $lab->Host_Name=$req->Host_Nameinput;
        $lab->Status=$req->Statusinput;
        $lab->save();
        return redirect()->back();
    }

    public function interviewinvite1(Request $res)
    {
        $developerid = $res->post("interid_");
        echo $developerid;

        $developer = LabSystem::find($developerid);
        $developer->Status="1";
        $developer->update();

        return redirect()->back();
    }    

    public function interviewinvite2(Request $res)
    {
        $developerid = $res->post("interid_1");
        echo $developerid;

        $developer = LabSystem::find($developerid);
        $developer->Status="0";
        $developer->update();

        return redirect()->back();
    }

    public function getcity($id)
    {
        $labid = $id;
        $lab_system = DB::table("lab_systems")->where("Lab_id",$labid)->get();        
        return view("labs_" ,compact('lab_system'));   
    }

    // _______________________________________________________________________________

    public function get_data(Request $req)
    {
        $id = $req->post("userid");
        $record = Labs::where('id' ,$id)->get();
        foreach($record as $r)
        {
            $user =$r;
            echo json_encode($user);
        }
    }
    // ____________________________________________________________________-

    public function get_data_(Request $req)
    {
        $id = $req->post("userid_");
        $record = temp_comp::where('id' ,$id)
        ->orderBy('created_at', 'desc')->get();
        foreach($record as $r)
        {
            $user =$r;
            echo json_encode($user);
        }
    }


    public function temp_comp(Request $request,$id)
    {

        if(isset($request->emailinput)){
            $userid = $request->emailinput;
        }else{
            $userid = session('sessionuseremail');
        }
        $name = LabSystem::where('id' ,$id)->first();
        $emailse=session('sessionuseremail');
        
        $system =temp_comp::where('email' , $userid)
        ->where('Host_Name',$name->Host_Name)->first();
        if(isset($system))
        {
            echo "<script>alert('Lab Already Exists.')
            window.location.href='/register_complains'
            </script>";
        }
        else
        {
            $userid = session('sessionuseremail');
            $systemcheck =temp_comp::where('email' , $userid)->first();
            $system =temp_comp::where('email' , $userid)->first();
            $system->Host_Name=$name->Host_Name;
            $system->email=session('sessionuseremail');
            $system->Lab_id=$name->Lab_id;
            $system->Pc_ip=$id;
            $system->Date_of_Complain = Date("y-m-d");
            $system->update();
        }
            
        $fetch = LabSystem::all();
        $lab = Labs::all();
        $hardware = hardware_complain::all();
        $software = software_complain::all();
        $Network = network_issue::all();
        // $other = other_issue::all();

        // $systems = temp_comp::where('email' , $userid)->get();
        return view("/register_complains" ,compact( 'fetch','lab','hardware','software','Network'));
    }
    public function getdatmodal(Request $req)
    {
        $id = $req->post("userid_");
        //echo $id;
        $record = temp_comp::where('id' ,$id)->get();
        foreach($record as $r)
        {
            $user =$r;
            echo json_encode($user);
        }
    }


    public function hardwareissue(Request $req)
    {

        $user = usermodels::where('email',$req->emailinput)->first();
        // $login =DB::table("hardware_complains")->where('id' ,$req->id)->first();

        $hardware = $req->hardware;
        $other_issue = $req->other_issue;
        // $installation = $req->installation;

        // $id = $req->id;

        $status = $req->status;
        
        $userid = session('sessionuseremail');
        echo $userid;
        $user = temp_comp::where('email',session('sessionuseremail'))->first();   
        $user->hardware_name = $hardware;
        $user->other_hardware_issue=$other_issue;
        // $user->Date_of_Complain = Date("y-m-d");
        $user->update();

        $complain = new Complain_Master();
        $complain->Complain_Category=$hardware;
        $complain->Complain_Description=$other_issue;
        // $complain->installation=$installation;
        // $complain->id_=$id;
        $complain->status=$status;
        $complain->Date_of_Complain = Date("y-m-d");
        $complain->Regiystered_By=session('sessionuseremail');
        $complain->Lab_id=$user->Lab_id;
        $complain->Pc_ip=$user->Pc_ip;
        $complain->role_type=$req->role1;
        $complain->save();

        $data= ['data'=>session('sessionuseremail')]; 
        //$data= Auth::User()->name;
        $user ['to'] = 'muhammadanasz786@gmail.com';    //admins email t0 send the email to the admin of the site 
        Mail::send('email',$data ,function($messages) use ($user)
        {
            $messages->to($user ['to']);
            $messages->subject('New Complain register by');
        }); 

        $delete = temp_comp::where('email',$userid);
        $delete->delete();

        return redirect("register_complains")->with("updatedsuccess" , "Data has been updated");
    }


    public function softwareissue(Request $req)
    {
            $software = $req->software ;
            $other_issue = $req->other_issue;
            // $installation = $req->installation;

            $userid = session('sessionuseremail');
            $user = temp_comp::where('email',$userid)->first();   
            echo "ddd".$userid;    

            $user->software_name = $software;
            $user->other_software_issue=$other_issue;
            // $user->Date_of_Complain = Date("y-m-d");
            $user->update();

            $complain = new Complain_Master();
            $complain->Complain_Category=$software;
            $complain->Complain_Description=$other_issue;
            // $complain->installation=$installation;

            $complain->Date_of_Complain = Date("y-m-d");
            $complain->Regiystered_By=session('sessionuseremail');
            $complain->Lab_id=$user->Lab_id;
            $complain->Pc_ip=$user->Pc_ip;
            $complain->role_type=$req->role1;
            $complain->save();

            $data= ['data'=>session('sessionuseremail')]; 
            //$data= Auth::User()->name;
            $user ['to'] = 'muhammadanasz786@gmail.com';    //admins email t0 send the email to the admin of the site 
            Mail::send('email',$data ,function($messages) use ($user)
            {
                $messages->to($user ['to']);
                $messages->subject('New Complain register by');
            });

            $delete = temp_comp::where('email',$userid);
            $delete->delete();
            return redirect("register_complains")->with("updatedsuccess" , "Data has been updated");
        }
    public function networkissue(Request $req)
    {
        $network = $req->network;
        $other_issue = $req->other_issue;
        // $installation = $req->installation;

        $userid = session('sessionuseremail');
        $user = temp_comp::where('email',$userid)->first();   
        echo "ddd".$userid;    
        $user->Network_issue = $network;
        $user->other_hardware_issue=$other_issue;

        // $user->Date_of_Complain = Date("y-m-d");
        $user->update();

        $complain = new Complain_Master();
        $complain->Complain_Category=$network;
        $complain->Complain_Description=$other_issue;
        // $complain->installation=$installation;

        $complain->Date_of_Complain = Date("y-m-d");
        $complain->Regiystered_By=session('sessionuseremail');
        $complain->Lab_id=$user->Lab_id;
        $complain->Pc_ip=$user->Pc_ip;
        $complain->role_type=$req->role1;
        $complain->save();

        $data= ['data'=>session('sessionuseremail')]; 
        //$data= Auth::User()->name;
        $user ['to'] = 'muhammadanasz786@gmail.com';    //admins email t0 send the email to the admin of the site 
        Mail::send('email',$data ,function($messages) use ($user)
        {
            $messages->to($user ['to']);
            $messages->subject('New Complain register by');
        });

        $delete = temp_comp::where('email',$userid);
        $delete->delete();
        return redirect("register_complains")->with("updatedsuccess" , "Data has been updated");
    }

    public function otherissue(Request $req)
    {
        $other = $req->other;
        // $installation = $req->installation;

        $userid = session('sessionuseremail');
        $user = temp_comp::where('email',$userid)->first();   
        echo "ddd".$userid;   

        $user->other_issue = $other;
        // $user->Date_of_Complain = Date("y-m-d");
        $user->update();

        $complain = new Complain_Master();
        $complain->Complain_Category=1;
        $complain->Complain_Description=$other;
        // $complain->installation=$installation;
        $complain->Date_of_Complain = Date("y-m-d");
        $complain->Regiystered_By=session('sessionuseremail');
        $complain->Lab_id=$user->Lab_id;
        $complain->Pc_ip=$user->Pc_ip;
        $complain->role_type=$req->role1;
        $complain->save();

        $data= ['data'=>session('sessionuseremail')]; 
        //$data= Auth::User()->name;
        $user ['to'] = 'muhammadanasz786@gmail.com';    //admins email t0 send the email to the admin of the site 
        Mail::send('email',$data ,function($messages) use ($user)
        {
            $messages->to($user ['to']);
            $messages->subject('New Complain register by');
        });

        $delete = temp_comp::where('email',$userid);
        $delete->delete();
        
        return redirect("register_complains")->with("updatedsuccess" , "Data has been updated");
    }

    public function register_()
    {
        $userid = session('sessionuseremail');
        $system = temp_comp::where('email' , $userid)->get();

        $hardware = hardware_complain::all();
        $software = software_complain::all();
        $Network = network_issue::all();
        // $others = other_issue::all();
        $fetch = LabSystem::all();

        return view("/complain_register" ,compact('system','fetch','hardware','software','Network'));
    }



    public function view_complains()
    {
        $view_compl =Complain_Master::where('Regiystered_By',session('sessionuseremail'))->get();
        return view("/view_complains",compact('view_compl'));        
    }
    // _________________________________________________________________________
    public function update_status_company1(Request $res)
    {           
        try{
            $companyid = $res->post("userid");
            echo $companyid;
    
            $company = LabSystem::find($companyid);
    
            if(is_null($company)){

                echo "Error";
                die;
            }

            $company->status="1";
            $company->update();
 
            return redirect()->back();

            }
            catch(Exception $ex){


                echo $ex->getMessage();
                die;
            }
    }    

    public function update_status_company0(Request $res)
    {
        $companyid = $res->post("userid1");
        echo $companyid;

        $company = LabSystem::find($companyid);
        $company->status="0";
        $company->update();

        return redirect()->back();

    }
    public function forgetpassword()
    {
        $fetch = temp_verfy::all();
        return view("/forgetpassword",compact('fetch'));
    }
    public function forgetpassword_(Request $req)
    {
        $v_code =  $this->generateUniqueCode();
        $user = usermodels::where('email',$req->emailinput)->first();
        
       if(isset($req->emailinput))
       {
           if(isset($user))
           {
            $fetch = temp_verfy::all();

                 $data= ['data'=> $user->email , 'code'=>$v_code]; 
                //$data= Auth::User()->name;
                $user ['to'] = $user->email;    
                Mail::send('email_user_forg',$data ,function($messages) use ($user)
                {
                    $messages->to($user ['to']);
                    $messages->subject('Forgot Passwword Code for Online Varsity');
                });
                $fuser = temp_verfy::where('email',$req->emailinput)->first();
                $fuser->code = $v_code; 
                $fuser->status = 8;  
                $fuser->update();
                return view("/code_match",compact('fetch'));
            }else{
                echo "<script>alert('Invalid Email Address.')
                window.location.href='/forgetpassword'
                </script>";
            }
       }
       else{
        echo "<script>alert('Please Provide Email Addresss to Continue.')
            </script>";

       }
        
    }
    public function labs()
    {
        $lab = Labs::all();
        return view("/lab_insert",compact('lab'));
    }
    public function labsinst_(Request $req)
    {
        $lab = new Labs();
        $lab ->No_of_pcs=$req->intlab;
        $lab ->lab_number=$req->labnumb;
        $lab ->Utilization_status=$req->utlstatus;
        $lab->save();
        return redirect()->back();
    }

    public function labsinst(Request $req)
    {
        $lab = new Labs();
        $lab ->No_of_pcs=$req->intlab;
        $lab ->lab_number=$req->labnumb;
        $lab ->Utilization_status=$req->utlstatus;
        $lab->save();
        return redirect()->back();

    }

    public function labsystem()
    {
        $lab_sys = LabSystem::all();
        return view("lab_systemS",compact('lab_sys'));
    }
    public function labsystem_(Request $req)
    {
        $labs = new LabSystem();
        $labs ->Host_Name=$req->intlab;
        // $labs ->Status=$req->labnumb;
        $labs ->Lab_id=$req->utlstatus;

        $labs->save();
        return redirect()->back();

    }

    public function Complain_views_admin()
    {
        return view("Complain_views_admin");
    }


     // _________________________________________________________________________
     public function updatstatus_1(Request $res)
     {  
        $complainid = $res->post("id1");
        echo $complainid;
        $complain = Complain_Master::find($complainid);
        $complain->Status="1";
        $complain->update();
        return redirect()->back();
     }    
 
     public function updatstatus_0(Request $res)
     {
        $complainid = $res->post("id1");
        echo $complainid;
        $complain = Complain_Master::find($complainid);
        $complain->Status="0";
        $complain->update();
         return redirect()->back();
     }
     public function hardware_compalins()
     {
       
        $Complainhards = Complain_Master::join('hardware_complains','hardware_complains.id','complain__masters.Complain_Category')
        ->where('role_type' ,'1')->get();

        $Complainhar =Complain_Master::all();
        return view("hardware_complains" ,compact('Complainhards','Complainhar'));
     }

     public function software_compalins()
     {
        $Complainsoft = Complain_Master::join('software_complains','software_complains.id','complain__masters.Complain_Category')
        ->where('role_type' ,'2')->get();
        $Complainhar =Complain_Master::all();
        return view("software_complains" ,compact('Complainsoft','Complainhar'));
     }

     public function network_compalins()
     {
        $Complainnetwork = Complain_Master::join('network_issues','network_issues.id','complain__masters.Complain_Category')
        ->where('role_type' ,'3')->get();
        $Complainhar =Complain_Master::all();
        return view("network_compalins" ,compact('Complainnetwork','Complainhar'));
     }

     public function other_complains()
     {

        $Complainnetother = Complain_Master::join('other_issues','other_issues.id','complain__masters.Complain_Category')
        ->where('role_type' ,'4')->get();

        $Complainhar =Complain_Master::all();
        return view("other_complains" ,compact('Complainnetother','Complainhar'));
     }

     public function Complain_Master(Request $request)
     {
        $mytime = Carbon::now();
        $mytime->toDateTimeString();

        $fetchprevious = Complain_Master::whereDate('date_of_reg','<',$mytime)->get();

        $fetchtoday = Complain_Master::whereDate('date_of_reg','=',$mytime)->get();

        $fetch = Complain_Master::whereDate('date_of_reg','>',$mytime)->get();

        return view("admin_dashboard" ,compact('fetchprevious','fetchtoday','fetch'));

     }

     public function update_status_company_11(Request $res)
     {
        
        $companyid = $res->post("id");
         echo $companyid;
 
         $company = Complain_Master::find($companyid);
         $company->Status="1";
         $company->update();
 
         return redirect()->back();
     }    
 
     public function update_status_company_00(Request $res)
     {
         $companyid = $res->post("id1");
         echo $companyid;
 
         $company = Complain_Master::find($companyid);
         $company->Status="0";
         $company->update();
 
         return redirect()->back();
 
     }

     public function updatstatuscompany1(Request $res)
     {    
        try{
            $complainid = $res->post("compid");
            echo $complainid;
            $complain = Complain_Master::join('students','students.Student_email','complain__masters.Regiystered_By')
            ->where('id',$complainid)->first();
    
            if(is_null($complain)){

                echo "Error";
                die;
            }

            $complain->Status="1";
            $complain->update();

            $data= ['name'=> $complain->Std_Name,'data'=> $complain->Regiystered_By]; 
            //$data= Auth::User()->name;
            $user ['to'] = $complain->Regiystered_By;    //admins email t0 send the email to the admin of the site 
            Mail::send('complain_resolve_email',$data ,function($messages) use ($user)
            {
                $messages->to($user ['to']);
                $messages->subject('Working on your Complain is been started');
            }); 
            return redirect()->back();

            }
            catch(Exception $ex){


                echo $ex->getMessage();
                die;
            }
  
         return redirect()->back();
     }    
 
     public function updatstatuscompany0(Request $res)
     {
        try{
            $complainid = $res->post("compid1");
            echo $complainid;
            $complain = Complain_Master::join('students','students.Student_email','complain__masters.Regiystered_By')
            ->where('id',$complainid)->first();
    
            if(is_null($complain)){

                echo "Error";
                die;
            }

            $complain->Status="2";
            $complain->update();

            $data= ['name'=> $complain->Std_Name,'data'=> $complain->Regiystered_By]; 
            //$data= Auth::User()->name;
            $user ['to'] = $complain->Regiystered_By;    //admins email t0 send the email to the admin of the site 
            Mail::send('resloved',$data ,function($messages) use ($user)
            {
                $messages->to($user ['to']);
                $messages->subject('Complain is been Resolved');
            }); 
            return redirect()->back();

            }
            catch(Exception $ex){


                echo $ex->getMessage();
                die;
            }
 
         return redirect()->back();
 
     }

     public function all_lab()
     {
        $userid = session('sessionuseremail');
        $system =temp_comp::all();
        $lab = Labs::all();
        $software = software_complain::all();
        return view("/all_lab",compact('lab','software','system'));
     }
 

     public function lab_s_(Request $req)
     {
        $userid = session('sessionuseremail');
        $lab_id =$req->lab_id;
        $system =temp_comp::where('email' , $userid)->first();

        $system = new Complain_Master();
        $system->Lab_id=$req->select_lab;
        $system->Regiystered_By=$userid;
        $system->Complain_Category=$req->software;
        $system->Complain_Description=$req->other_install;
        $system->role_type=2;
        $system->Date_of_Complain = Date("y-m-d");
        $system->save();

        return redirect()->back();
        $userid = session('sessionuseremail');
        $system =temp_comp::all();
        $hardware = hardware_complain::all();
        $software = software_complain::all();
        $Network = network_issue::all();
        // $other = other_issue::all();
        $fetch = LabSystem::all();

        return view("/lab_issues",compact('hardware','software','Network','fetch','system'));

     }

  
}
