<?php
include '../Models/PngUploadResults.php';

// define constant variables
define('validType', "png");
define('maximumSize', 200000);

	class PngUpload{
                const validType="png";
                const maximumSize="200000";
            
		private $file,
                        $directory,
                        $results;
                
                /*
                 * when creating the object -> we upload the file to server
                 */
		function __construct($file,$directory){
			// set parameters
			$this->file = $file;
			$this->directory = $directory;
                        
			// upload the file
			$this->UploadFileToServer();
		}
                
		// method to upload file to server
		private function UploadFileToServer(){
                    // check if the paramters are empty
                    if (empty($this->file) || (empty($this->directory))) {
                        $this->results = new PngUploadResults('Error',"הפרמטרים לא מאותחלים",false);
                    } else{
                        // check if the extension is png
                        $path = $this->file['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if(!($ext == 'png')){
                            $this->results = new PngUploadResults('Error',"רק סיומת png חוקית ",false);
                        } else{
                            // check for valid size
                            if ($this->file['size'] > maximumSize) {
                                $this->results = new PngUploadResults('Error',"התמונה גדולה מדי",false);  
                            } else{
                                // name the file with unique name and save it to server
                                    $filePath = $this->directory.date('Y-m-d_h:i:s').'.png';
                                    if(move_uploaded_file($this->file['tmp_name'], $filePath)){
                                        $this->results = new PngUploadResults("Success","התמונה עלתה בהצלחה",$filePath); 
                                } else {
                                    $this->results = new PngUploadResults('Error',"קרתה שגיאה",false);
                                }
                            }
                        }
                    }
                }
                
		// get results as json
		public function GetResult(){
			return $this->results->getJson();
		}
	}
?>