<?php
	class FormatController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		public function qdetail(){
			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		
			$this->setFlash('You have Selected '.$this->request->data['Type']['type']);
			$this->set('val',$this->request->data['Type']['type']);
		}
		public function q1_detail(){

			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
			
 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
	}