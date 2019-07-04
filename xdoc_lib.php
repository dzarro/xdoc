<?php

      function xdoc_root() {
	   return "https://sohowww.nascom.nasa.gov/solarsoft";
       // return "ftp://sohoftp.nascom.nasa.gov/solarsoft";
      }
      
/////////////////////////////////////////////////////////////////////////

      function IsURL($url) {
	   $cmp = parse_url($url);
       return isset($cmp["host"]);
	  }
	  
///////////////////////////////////////////////////////////////////////////
      function URLIsValid($URL){
       $headers = @get_headers($URL);
	   //print_r($headers);
       preg_match("/ [4|5][0-9]{2} /", (string)$headers[0] , $match);
	   //echo count($match);
       return count($match) === 0;
      }
      
/////////////////////////////////////////////////////////////////////////

    function match_files($files,$term)  {
    
     $return_arr = array();
     $count=count($files);
     if (!is_blank($term) && $count !== 0 && $files !== false)  {
      $matches=preg_grep("#$term#",$files);
      if (count($matches) !== 0) $return_arr=$matches;
     } 
     echo json_encode($return_arr);
    }
    
/////////////////////////////////////////////////////////////////////////

     function remote_file_size($url){
	  $data = @get_headers($url, true);
	  if ($data === false) return 0;
      preg_match("/ [45][0-9]{2} /", (string)$data['0'] , $match);
      
      if (count($match) !== 0) return 0;
	    if (isset($data['Content-Length'])) return (int) $data['Content-Length'];
      return 0;
	 }
	 
/////////////////////////////////////////////////////////////////////////


      function get_xdoc_map($ssw_file="ssw_map.dat")  {
      
	 //  session_start();
       if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = 0;
        } else {
        $_SESSION['count']++;
       }
	 //  alert ( (string) $_SESSION['count']);
       
	   $ssw_gen="/gen/setup";
       $ssw_dir=xdoc_root().$ssw_gen;
       $temp_dir=sys_get_temp_dir();   

       $ssw_save_map = $temp_dir.'/'.$ssw_file;
       $ssw_map=$ssw_dir.'/'.$ssw_file;
      
 // check if recent map file is saved.
     
       $hour=3600;       
       $diff=0;
       
       $exists=file_exists($ssw_save_map);
	  
       if ($exists) {
//		alert("Reading file"."$ssw_save_map");
		
        $diff=time()-filemtime($ssw_save_map); 
       } 
       
       if ( $exists && ( $diff < $hour || ($_SESSION['count'] ==0) ) ) {
	  //  alert('in cache...');
        $sub=@file($ssw_save_map);
        $count = count($sub);
	    if ($count !== 0 && $sub !== false) return $sub;
       }
       
// else read it.
   //    alert('reading new');
       $contents=@file($ssw_map);
       $count = count($contents);
       if ( $count === 0 || $contents === false) {
        if ($exists) {
         $sub = @file($ssw_save_map);
         $count = count($sub);
         if ($count !== 0 && $sub !== false) return $sub;
        }
        alert('Problem reading remote SSW catalog file '."$ssw_map");
        return false;
       }
        
       $sub=preg_grep('/^(\$SSW).*/',$contents);
	  // if (!is_writable($temp_dir)) {alert('Temp dir not writeable:'.$temp_dir}
       if (is_writable($temp_dir)) file_put_contents($ssw_save_map,$sub);
        
       return $sub;    
      }    
//////////////////////////////////////////////////////////////////////////////////////////////////
// PHP alert 

      function alert($message)
      {
       if (is_string($message)) echo "<script language = 'javascript'>alert('$message');</script>";
      }

//////////////////////////////////////////////////////////////////////////////////////////////// 

function is_blank($input) {

 if (!is_string($input)) return true;
 if (is_numeric($input)) return true;
 if (trim($input) === '') return true;
 return false;

}

/////////////////////////////////////////////////////////////////////////////////////////////////

function parse_file($file)
{
 $file=trim($file);
 $ext='.pro';
 $wild='*';
 $dfile=basename($file,$ext);
 $pos=strpos($file,$ext);
 $wpos=strpos($file,$wild);
 //if (($pos === false) && ($wpos === false) ){
 // $dfile=$wild.$dfile.$wild;
 // }
 $dfile=str_replace('*','[^\/]*',$dfile);
 $dfile=str_replace('.','\.',$dfile);
 return $dfile;
}

/////////////////////////////////////////////////////////////////////

function get_xdoc_files() {
      
       $temp_dir=sys_get_temp_dir();   
       $ssw_list=$temp_dir.'/ssw_list.dat';
      
 // check if file list is saved.
       
       $hour=3600;       
       $diff=0;
	 //  print_r($ssw_list);
       $exists=file_exists($ssw_list);
       if ($exists) $diff=time()-filemtime($ssw_list); 
       
       if (($exists) && ($diff < $hour)) {
        $files=@file($ssw_list);
        $count = count($files);
        if ($count !== 0 && $files !== false) return $files;
       }
       
// else read map file and save file list
      
       $contents=get_xdoc_map();
       $count = count($contents);
       if ($count !== 0 && $contents !== false) {
		   
		
	//	print_r($contents);
        $files=array_map('rem_ext',$contents);
        $files = array_keys(array_flip($files));
		sort($files);
        if (is_writable($temp_dir)) file_put_contents($ssw_list,$files);
        return $files;
       }
       
       alert("Problem reading SSW file list"); 
       return false;   
       
      }    
////////////////////////////////////////////////////////////////////////////

function rem_ext($file)
{
 return basename($file,".pro\n")."\n";
}
////////////////////////////////////////////////////////////////////////////

// find procedure in SSW catalog 

function find_proc($filename) {

if (is_blank($filename)) return NULL;

// check for .pro extension

$file=basename($filename);
$ext='.pro';
$pos=strpos($file,$ext);
if ($pos === false) $file=$file.$ext;

$contents=get_xdoc_map();
if (!$contents) return false;

// find first match in SSW database
 
$SSW=xdoc_root();
$temp= preg_grep("/\/$file/",$contents);
$file=array_shift($temp);
$file=str_replace('$SSW',"$SSW",$file);
$file=trim($file);
return $file;
}

?>