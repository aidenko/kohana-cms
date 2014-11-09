<?php
/**
 * Model_Database_Comment
 * 
 * @author Artem Kolombet
 * @copyright 2014
 * @version 1.0
 
 		History
 	=================================================================
 		Date				|	Author					| [Version]		| comment
 	=================================================================
 		2014-03-23		Artem Kolombet		[1.0]					created
 */
class Model_Database_Comment extends Model_System_ApplicationModelDatabase
{
	private $sTable = 'comment';
	private $sVotesTable = 'comment_votes';
	private $sSubscribeTable = 'comment_subscribe';
	
	public function getComments()
	{
		return DB::select()->from($this->sTable)->as_object()->execute()->as_array();
	}
	
	public function getItemComments($iItemType, $iItemId, $aOrderBy = array('cm_datetime' => 'DESC'), $aLimit = array(), $bActive = true, $bDeleted = false)
	{

		$oQuery = DB::select()
							->from(array($this->sTable, 'c'))
							->where('c.ct_id', '=', $iItemType)
							->where('c.item_id', '=', $iItemId)
							;
							
		if($bActive)
			$oQuery->where('c.cm_active', '=', '1');
		
		if(!$bDeleted)
			$oQuery->where('c.cm_deleted', '!=', '1');
							
		if(is_array($aOrderBy))
			foreach($aOrderBy as $c => $d)
				$oQuery->order_by($c, $d);
				
		if(is_array($aLimit) && count($aLimit) > 0)
		{
			if(count($aLimit) == 1)
				$oQuery->limit($aLimit[0]);
			else	
				$oQuery->offset($aLimit[0])->limit($aLimit[1]);
		}								 
		
		return $oQuery->as_object()->execute()->as_array();
	}
	
	public function getCountItemComments($iItemType, $iItemId, $bActive = true, $bDeleted = false)
	{
		$oQuery = DB::select(array(DB::expr('COUNT(cm_id)'), 'total_comments'))
						->from($this->sTable)
						->where('ct_id', '=', $iItemType)
						->where('item_id', '=', $iItemId);
		
		if($bActive)
			$oQuery->where('cm_active', '=', '1');
		
		if(!$bDeleted)
			$oQuery->where('cm_deleted', '!=', '1');				
						
		return $oQuery->as_object()->execute()->get('total_comments', 0);
	}
	
	public function getCommentPlusMinus($iCommentId)
	{	
		return DB::select('cv_value', array(DB::expr('COUNT(cv_id)'), 'number'))
						->from($this->sVotesTable)
						->where('cm_id', '=', $iCommentId)
						->as_object()->execute()->as_array();						
	}
	
	public function getCommentVotes($iCommentId, $bCount = true)
	{
		
	}
	
	public function insertComment($aComment = array())
	{
		return DB::insert(
			$this->sTable, 
			array(
				'ct_id', 
				'item_id',
				'cm_title',
				'cm_text',
				'cm_name',
				'cm_username',
				'cm_email', 
				'cm_ip',
				'cm_datetime',
				'cm_fk',
				'cm_active',
				'cm_deleted'
			))
			->values(array(
				$aComment['ct_id'],
				$aComment['id'],
				$aComment['cm_title'],
				$aComment['cm_text'],  
				$aComment['cm_name'],
				$aComment['cm_username'],
				$aComment['cm_email'],
				//DB::expr('INET_ATON("'.$aComment['cm_ip'].'")'),
				$aComment['cm_ip'],
				$aComment['cm_datetime'], 
				$aComment['cm_fk'],
				$aComment['cm_active'],
				$aComment['cm_deleted'] 
			))
			->execute();
	} 
	
	public function insertSubscribtion($sEmail, $iCtId, $iItemId, $sName)
	{
		ob_start();?>
		
		INSERT INTO akb_comment_subscribe
	    (cs_email,
	     cs_name,
	     ct_id,
	     item_id,
			 cs_datetime)
			 
		VALUES (
			:cs_email,
			:cs_name,
			:ct_id,
			:item_id,
			:cs_datetime
		)	ON DUPLICATE KEY UPDATE
			cs_name = :cs_name2
		
		<?php $sQuery = ob_get_clean();
		
		$oQuery = DB::query(Database::INSERT, $sQuery);
		
		$oQuery->parameters(array(
	    ':cs_email' => $sEmail,
	    ':cs_name' => $sName,
	    ':ct_id' => $iCtId,
	    ':item_id' => $iItemId,
	    ':cs_datetime' => date('Y-m-d H:i:s'),
	    ':cs_name2' => $sName
			));
			
		return $oQuery->execute(); 	
	}
	
	public function getCommentsForNotification($aOrderBy = array('cm_datetime' => 'DESC'), $aLimit = array(), $bActive = true, $bDeleted = false)
	{
		$oQuery = DB::select()
							->from(array($this->sTable, 'c'))
							->where('c.cm_notified', '=', '0')
							;
							
		if($bActive)
			$oQuery->where('c.cm_active', '=', '1');
		
		if(!$bDeleted)
			$oQuery->where('c.cm_deleted', '!=', '1');
							
		if(is_array($aOrderBy))
			foreach($aOrderBy as $c => $d)
				$oQuery->order_by($c, $d);
				
		$oQuery->group_by('c.ct_id');
		$oQuery->group_by('c.item_id');	
				
		if(is_array($aLimit) && count($aLimit) > 0)
		{
			if(count($aLimit) == 1)
				$oQuery->limit($aLimit[0]);
			else	
				$oQuery->offset($aLimit[0])->limit($aLimit[1]);
		}								 
		
		return $oQuery->as_object()->execute()->as_array();
	}
	
	public function getSubscribed($iItemType, $iItemId)
	{
		return DB::select()
			->from($this->sSubscribeTable)
			->where('cs_active', '=', '1')
			->where('cs_deleted', '!=', '1')
			->where('ct_id', '=', $iItemType)
			->where('item_id', '=', $iItemId)
			->as_object()->execute()->as_array();
	}
	
	public function setAsNotified($iItemType, $iItemId)
	{
		return DB::update($this->sTable)
			->set(array('cm_notified' => '1'))
			->where('ct_id', '=', $iItemType)
			->where('item_id', '=', $iItemId)
			->execute();
	}
}