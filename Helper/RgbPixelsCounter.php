<?php

class RgbPixelsCounter{         
        private $image;
        private $imageWidth;
        private $imageHeight;
        private $histogram = array();
        private $maxValues = array();
        private $maxValuesCounters = array();

        function __construct($picturePath){
                $this->image = imagecreatefrompng($picturePath);
            
                // initialize counter array
                for($i=0; $i<5; $i++){
                    $this->maxValues[$i] = 0;
                    $this->maxValuesCounters[$i]=0;
                }
        }
        
        public function getTopFiveRgbColors(){
            $this->createHistogram();
            $this->findMax();
            
            return $this->getMaxValues();
        }
        
        public function createHistogram(){
            $this->imageWidth = imagesx($this->image);
            $this->imageHeight = imagesy($this->image);

            for($x = 0; $x < $this->imageWidth; $x++) {
                for($y = 0; $y < $this->imageHeight; $y++) {
                    // pixel color at (x, y)
                    $rgb = imagecolorat($this->image, $x, $y);
                    
                // get the Value from the RGB value
                    if(!isset($this->histogram[strval($rgb)])){
                        $this->histogram[strval($rgb)]=0;
                    }
                    $this->histogram[strval($rgb)]++;
                }
            }
        }
        
        public function returnHistogram(){
             $json = "[";
             foreach ($this->histogram as $rgbValue => $counter) {
                $colors = imagecolorsforindex($this->image, $rgbValue);
                $r = $colors["red"];
                $g = $colors["green"];
                $b = $colors["blue"];
                $hex = sprintf("#%02x%02x%02x", $r, $g, $b);
                
                if($json!=='[')
                    $json.=',';
                
                $json.='{"rgbColor":"('.$r.','.$g.','.$b.')","counter":'.$counter.''
                        . ',"percentage":'.($counter/($this->imageHeight*$this->imageWidth))
                        . ',"hexColor":"'.$hex.'"}';
            
             }
            $json.= ']';
            return $json;
            }
        
        function findMax(){
            $isFull=false;
            $counterFull=0;
            foreach ($this->histogram as $rgbValue => $counter) {
                $counterFull++;
                if($counterFull==5)
                    $isFull=true;

                for($i=0; $i<5; $i++){
                    if(!$isFull){
                        if($this->maxValuesCounters[$i]==0){
                            if($i>0){
                                if($this->maxValuesCounters[$i]<$counter){
                                    $this->maxValuesCounters[$i]=$this->maxValuesCounters[$i-1];
                                    $this->maxValues[$i] = $this->maxValues[$i-1];
                                    $this->maxValuesCounters[$i]=$counter;
                                    $this->maxValues[$i] = $rgbValue;
                                    break;
                                }else{
                                    $this->maxValuesCounters[$i]=$counter;
                                    $this->maxValues[$i] = $rgbValue;
                                    break;
                                }
                            }
                            else{
                                $this->maxValuesCounters[$i]=$counter;
                                $this->maxValues[$i] = $rgbValue;
                                    break;
                            }
                        }
                    }
                    else{
                        if($this->maxValuesCounters[$i]<$counter){
                            $this->maxValuesCounters[$i]=$counter;
                            $this->maxValues[$i] = $rgbValue;
                            break;
                        }
                    }
                }
            }
        }
        
        function getMaxValues(){
            $json = "[";
            for($i=0; $i<5; $i++){
                $colors = imagecolorsforindex($this->image, $this->maxValues[$i]);
                $r = $colors["red"];
                $g = $colors["green"];
                $b = $colors["blue"];
                $hex = sprintf("#%02x%02x%02x", $r, $g, $b);
                
                if($json!=='[')
                    $json.=',';
                
                $json.='{"rgbColor":"('.$r.','.$g.','.$b.')","counter":'.$this->maxValuesCounters[$i].''
                        . ',"percentage":'.($this->maxValuesCounters[$i]/($this->imageHeight*$this->imageWidth))
                        . ',"hexColor":"'.$hex.'"}';
            }
            $json.= ']';
            return $json;
        }
        
}