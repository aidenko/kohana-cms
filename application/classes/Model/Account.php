<?php
class Model_Account extends Model_Database
{
	public function getAccount($iId = null)
	{
		$oQuery = DB::select()->from("account"); 
		
		if(is_numeric($iId))
			$oQuery->where("acc_id","=", $iId);

		return $oQuery->execute();
	}
}