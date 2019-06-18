<?php
/**
  * Generates an UUID
  *
  * @author     Anis uddin Ahmad <admin@ajaxray.com>
  * @param      string  an optional prefix
  * @return     string  the formatted uuid
  */
  $task = '';
  if ( isset($_POST['task'])){
    $task = $_POST['task'];
  }
  switch($task){
    case "NCUUID":
        echo json_encode(uuid());
    break;
    case "NCUUIDS":
        $jsonresult = json_encode(uuids(7));
        echo '({"results":'.$jsonresult.'})';
        break;
    default:
        break;
  }

  function uuid($prefix = '')
  {
    $chars = md5(uniqid(mt_rand(), true));
    $uuid  = substr($chars,0,8) . '-';
    $uuid .= substr($chars,8,4) . '-';
    $uuid .= substr($chars,12,4) . '-';
    $uuid .= substr($chars,16,4) . '-';
    $uuid .= substr($chars,20,12);
    return $prefix . $uuid;
  }

  function uuids($num)
  {   
      for($i=0; $i<$num; $i++){
          $uuid = array('id'=>$i,
                        'uuid'=>uuid());
          $uuids[] = $uuid;
      }
      return $uuids;
  }