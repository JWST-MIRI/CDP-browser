<?php
class Utils
{
  public  function checkGetKey($key,$default='')
  { return (array_key_exists($key,$_GET)&&($_GET[$key]!=''))?$_GET[$key]:$default;
  }

  public  function utilitiesDispatchIndexAction()
  {
  	if(!($indexActionInclude=$this->utilitiesCheckIndexActionAdmin('admin_users', 'common/content/user_admin.php')))

  	if ($indexActionInclude == "") {
  		$indexActionInclude = 'cdp/list.php';
  	}
  		
    return $indexActionInclude;
  }
  // Only logged in users can do this action
  private function utilitiesCheckIndexActionMember($action, $includefile)
  { global $loggedUser;
  if(array_key_exists('indexAction',$_GET) && ($_GET['indexAction'] == $action) && $loggedUser)
  	return $includefile;
  }
  // All users can do this action
  private function utilitiesCheckIndexActionAll($action, $includefile)
  { if(array_key_exists('indexAction',$_GET)&&($_GET['indexAction']==$action))
  	return $includefile;
  }
  // Only administrators can do this action
  private function utilitiesCheckIndexActionAdmin($action, $includefile)
  { if(array_key_exists('indexAction',$_REQUEST) && ($_REQUEST['indexAction'] == $action) && array_key_exists('admin', $_SESSION) && ($_SESSION['admin'] == "yes"))
  	return $includefile;
  }
}
?>
