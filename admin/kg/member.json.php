<?
include_once("../../config.php");

$id = $_POST['id'];
$memberRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_kg WHERE id=?",array($id));
$obj = $memberRs->FetchObject();

$customerArray = array();
$fieldRs = $SysConfig['customerdb']->Execute("SELECT * FROM t_fields WHERE TypeName='t_kg' ORDER BY id");
while (!$fieldRs->EOF)
{
	$fieldObj = $fieldRs->FetchObject();
	$customerArray[] = array($fieldObj->CALLED,$memberRs->fields[$fieldObj->FIELDNAME]);
	$fieldRs->MoveNext();
}

$result = array(
	'member' => $obj,
	'customer' => $customerArray
);
echo json_encode($result);
?>