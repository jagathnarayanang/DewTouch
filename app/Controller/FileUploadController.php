<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
class FileUploadController extends AppController {
	public function index() {
		        $this->loadModel('Files');
		        $this->loadModel('FileUpload');

		$this->set('title', __('File Upload Answer'));	
		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
		if ($this->request->is('post')) {
			$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
			if(in_array($this->request->data['FileUpload']['file']['type'],$mimes)){
            if(!empty($this->request->data['FileUpload']['file'])){
                $fileName = $this->request->data['FileUpload']['file']['name'];
                $uploadPath = 'uploads/';
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($this->request->data['FileUpload']['file']['tmp_name'],$uploadFile)){
					$file = fopen($uploadFile, "r");
	      			$file = file_get_contents($uploadFile);
					$file_uploads = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $file));
					$data1=array_shift($file_uploads);
					foreach ($file_uploads as $key => $value) {
					$data['FileUpload']['name']=$value[0];
					$data['FileUpload']['email']=$value[1];										
					$this->FileUpload->saveAll($data,['name','email']);
					}
					$file_uploads=$this->FileUpload->find('all');
					$this->set(compact('file_uploads'));
					$this->setFlash('Your '.$fileName.' Uploaded succesfully');

					//this->setFlash('Unable to upload file, please try again.');           			
                } else{
                    $this->setFlash('Unable to upload file, please try again.');
                }
            }
        }
        else{
        	$this->setFlash('Check the file format, please try again.');
        }
        }
	}
}