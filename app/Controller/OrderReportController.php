<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');
/*
			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// debug($portions);exit;


			// To Do - write your own array in this format
			$order_reports = array('Order 1' => array(
										'Ingredient A' => 1,
										'Ingredient B' => 12,
										'Ingredient C' => 3,
										'Ingredient G' => 5,
										'Ingredient H' => 24,
										'Ingredient J' => 22,
										'Ingredient F' => 9,
									),
								  'Order 2' => array(
								  		'Ingredient A' => 13,
								  		'Ingredient B' => 2,
								  		'Ingredient G' => 14,
								  		'Ingredient I' => 2,
								  		'Ingredient D' => 6,
								  	),
								);

			// ...*/
								$this->loadModel('PortionDetail');
			$portion_details = $this->PortionDetail->find('all',array('conditions'=>array('PortionDetail.valid'=>1)));

			$partsArr = array();
			foreach($portion_details as $pdKey => $pdValue) {
				if (!(array_key_exists($pdValue['Part']['id'], $partsArr))) {
					$partsArr[$pdValue['Part']['id']] = $pdValue['Part']['name'];
				}
			}
			ksort($partsArr);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1)));

			$itemsArr = array();
			foreach($portions as $portionKey => $portionValue) {
				$itemsArr[$portionValue['Item']['id']]['name'] = $portionValue['Item']['name'];
				foreach($portionValue['PortionDetail'] as $pdKey => $pdValue) {
					$itemsArr[$portionValue['Item']['id']]['parts'][$partsArr[$pdValue['part_id']]] = $pdValue['value'];
				}
			}
			ksort($itemsArr);

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			$order_reports = array();
			foreach($orders as $orderKey => $orderValue) {
				$order_reports[$orderValue['Order']['name']] = array();
				foreach($orderValue['OrderDetail'] as $orderDetailsKey => $orderDetailsValue) {
					foreach($itemsArr[$orderDetailsValue['item_id']]['parts'] as $partsKey => $partsValue) {
						if (array_key_exists($partsKey, $order_reports[$orderValue['Order']['name']])) {
							$order_reports[$orderValue['Order']['name']][$partsKey] += $partsValue*$orderDetailsValue['quantity'];
						} else {
							$order_reports[$orderValue['Order']['name']][$partsKey] = $partsValue*$orderDetailsValue['quantity'];
						}
					}
				}
				ksort($order_reports[$orderValue['Order']['name']]);
			}

			$this->set('order_reports',$order_reports);


			$this->set('order_reports',$order_reports);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}