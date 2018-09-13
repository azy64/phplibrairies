<?php
	class FileUpload{
		protected $pathSrc=null,
		$pathDest=null,
		$name=null,
		$fileExt=null,
		$fileLen=null,
		$type=null,
		$restrictSize=2000000,
		$err=null,
        $newName=null,
		$file=null;
		/*
		 * cette classe reçoit un parametre dans son constructeur
		 * le parametre est de type file d'ou venant d'un $_File
		 *
		 */
		
		public function __construct($file){
			if(isset($file) and !empty($file)){
				$this->file=$file;
				$this->name=$file['name'];
				$this->fileLen=$file['size'];
				$this->type=$file['type'];
				$this->err=$file['error'];
                $this->pathSrc=$file['tmp_name'];
			}
			
			
		}
		public function upload($dest){
			$this->pathDest=utf8_encode($dest).".".$this->getFileExt();
			if($this->fileLen<$this->restrictSize){
				//if(!preg_match("/",$this->pathDest))
				move_uploaded_file($this->pathSrc,$this->pathDest);
                if(preg_match("#/#",$this->pathDest)){
                    $val=preg_split("#/#",$this->pathDest);
                    $this->newName=$val[$this->getArrayLen($val)-1];
                }
                else
                    $this->newName=$this->pathDest;
			}
            else
                trigger_error("la taille du fichier ne doit pas depasser 2Mo");
		}
		public function getPathDest(){
			return $this->pathDest;
		}
		public function getName(){
			return $this->name;
		}
		public function getPathSrc(){
			return $this->pathSrc;
		}
		public function getFileExt(){
            $val=preg_split("#\.#",$this->getName(),3,PREG_SPLIT_NO_EMPTY);
            return $val[$this->getArrayLen($val)-1];
		}
		public function setPathDest($value){
			if(isset($value) and !empty($value) and is_string($value))
				$this->pathDest=$value;
		}

        public function getFileLen(){
            return $this->fileLen;
        }
        public function getTypeMime(){
            return $this->type;
        }
        public function getNewName(){
            return $this->newName;
        }
        public function getArrayLen(array $tab){
            $nbr=0;
            foreach($tab as $el)
                $nbr++;

            return $nbr;
        }
		public function uploadWithRestrict(array $ext){
			return false;
		}
        public function PdfPage (){
            $i=0;
            if(strtolower($this->getFileExt())=="pdf"){
                $handle = @fopen($this->getPathSrc(), "r");
                if ($handle) {
                    while (!feof($handle)) {
                        $buffer = fgets($handle, 4096);
                        if( preg_match("/Type\s*\/Page[^s]/", $buffer) ){
                            ++$i;
                        }
                    }
                    fclose($handle);
                }
                $i = 0+$i;
            }

            return $i;
        }
	}
?>