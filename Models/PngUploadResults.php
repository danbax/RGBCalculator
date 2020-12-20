<?php
class PngUploadResults
{    
  private $type;
  private $message;
  private $filePath;
  
  public function __construct($type,$message,$filePath)
  {
    $this->type = $type;
    $this->message = $message;
    $this->filePath = $filePath;
  }
 
  public function getType()
  {
    return $this->type;
  }
 
  public function getMessage()
  {
    return $this->message;
  }
 
  public function getFilePath()
  {
    return $this->filePath;
  }
  
  public function getJson(){
      return 
      '{"type":'.'"'.$this->getType().'","message":'.'"'.$this->getMessage().'","filePath":'.'"'.$this->getFilePath().'"}';
  }
}
?>