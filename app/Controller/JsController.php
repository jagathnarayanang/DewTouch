<?php
	class JsController extends AppController{

		public function q1(){
			$this->loadModel('User');
			$userdata = $this->User->find('all');
			$this->set("alldata",$userdata);
			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function q1_detail(){
			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		public function update(){
					$this->loadModel('User');

			$this->autoRender = false;
			$postData=$this->request->data;			
			$uniqueid=$postData['id'];
			unset($postData['id']);
			$postData["ID"]=$uniqueid;
			$user = $this->User->find('all',array('conditions' => array('User.id' => $uniqueid)));
			
			if(count($user) == 0){
				$this->User->save($postData);
				$id=$this->User->getInsertID();
				$res='{"id":"'.$id.'","mode":"insert"}';
				echo json_encode($res);die;
			}
			else{
				$this->User->updateAll(
    				array('description' => ($postData['description'] != '' ? "'".$postData['description']."'" : NULL),'quantity' => ($postData['quantity'] != '' ?"'".$postData['quantity']."'" : NULL),'price' => ($postData['price'] != '' ? "'".$postData['price']."'" : NULL)),
    				array('ID' => $uniqueid)
				);
				$res='{"mode":"updated"}';
				echo ($res);die;
			}
		}
	}