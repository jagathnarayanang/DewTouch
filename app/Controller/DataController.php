<?php
	class DataController extends AppController{

		public function index(){
			ini_set('max_execution_time', 300);
			$this->loadModel('Member');
			$this->loadModel('Transaction');
			$this->loadModel('TransactionItem');
			$this->autoRender = false;
			App::import('Vendor', 'php-excel-reader/XLSXReader'); //import statement
			$xlsx = new XLSXReader('files/migration_sample_1.xlsx');
			$sheetNames = $xlsx->getSheetNames();
			foreach($sheetNames as $sheetName) {
				$sheet = $xlsx->getSheet($sheetName);
				$result=$sheet->getData();
			}
			$re=0;
			$res=array_shift($result);
			foreach ($result as $key => $value) {
				$memData=explode(" ", $value[3]);
				$memberData['Member']['type']=$memData[0];
				$memberData['Member']['no']=$memData[1];
				$memberData['Member']['name']=$value[2];
				$memberData['Member']['company']=$value[5];			
				$this->Member->saveAll($memberData,['type','no','name','company']);
				$memberId=$this->Member->getInsertID();
				$trans['Transaction']['member_id']=$memberId;
				$trans['Transaction']['member_name']=$value[2];
				$trans['Transaction']['member_paytype']=$value[4];
				$trans['Transaction']['member_company']=$value[5];
				$finddate=$value[0]-42006;
				$Date = "1/2/2015";
				$trans['Transaction']['date']=date('Y-m-d', strtotime($Date. ' + '.$finddate.'	 days'));
				$trans['Transaction']['year']=date('Y', strtotime($Date. ' + '.$finddate.'	 days'));
				$trans['Transaction']['month']=date('m', strtotime($Date. ' + '.$finddate.'	 days'));
				$trans['Transaction']['ref_no']=$value[1];
				$trans['Transaction']['receipt_no']=$value[8];
				$trans['Transaction']['payment_method']=$value[6];
				$trans['Transaction']['batch_no']=$value[7];
				$trans['Transaction']['cheque_no']=$value[9];
				$trans['Transaction']['payment_type']=$value[10];
				$trans['Transaction']['renewal_year']=$value[11];
				$trans['Transaction']['subtotal']=$value[12];
				$trans['Transaction']['tax']=$value[13];
				$trans['Transaction']['total']=$value[14];
				$this->Transaction->saveAll($trans,['member_id','member_name','member_paytype','member_company','date','year','month','ref_no','receipt_no','payment_method','batch_no','cheque_no','payment_type','renewal_year','subtotal','tax','total']);
				$transId=$this->Transaction->getInsertID();
				$transItems['TransactionItem']['transaction_id']=$transId;
				$transItems['TransactionItem']['description']="Being Payment for:".$value[10].":".$value[11];
				$transItems['TransactionItem']['quantity']=1;
				$transItems['TransactionItem']['unit_price']=$value[12];
				$transItems['TransactionItem']['sum']=$value[12];
				$transItems['TransactionItem']['table']="Member";
				$transItems['TransactionItem']['table_id']=$memberId;
				$this->TransactionItem->saveAll($transItems,['transaction_id','description','quantity','unitPrice','sum','table','table_id']);
				echo $re;
				$re++;
			}
}
		
}