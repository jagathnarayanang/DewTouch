<?php

class FileUpload extends AppModel {

	public function save1($value){
		$data['name']="test";
		$data['email']="test@test.com";
		$this->FileUpload->save($data);

}
}