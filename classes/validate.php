<?php 

class Validate{

    private $_passed = false,
            $_errors = array(),
            $_db = null;

    /*---------------------------------*/
    /* HACIENDO UNA INSTANCIA DE LA DB */
    /*---------------------------------*/
    public function __construct() {
        $this->_db = DB::getInstance();
    }

    /*--------------------------------*/
    /* VALIDA LOS DATOS DE LOS INPUTS */
    /*--------------------------------*/
    public function check($source, $items = array()){
        //TRAE TODOS LOS ITEM CON SUS ARRAYS(reglas)
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                //DEVUELVE LOS VALORES DE LOS INPUTS
                $value = trim($source[$item]);
                $item = escape($item);
                
                if ($rule === 'required' && empty($value)) {
                    //SI EL INPUT ESTA VACIO Y ES REQUERIDO AGREGA EL ERROR
                    $this->addError("{$item} es requerido");

                }else if(!empty($value)){

                    switch ($rule) {
                        case 'min':
                            //VALIDANDO EL LARGO DE LOS CAMPOS
                            if (strlen($value) < $rule_value) {
                                $this->addError("<strong>{$item}</strong> debe de tener un minimo de {$rule_value} caracteres");
                            }
                            break;

                        case 'max':
                            //VALIDANDO EL LARGO DE LOS CAMPOS
                            if (strlen($value) > $rule_value) {
                                $this->addError("<strong>{$item}</strong> debe de tener un maximo de {$rule_value} caracteres");
                            }
                            break;

                        case 'matches':
                            //COMPROBANDO QUE LAS PASSWORD COINCIDAN
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} debe de coincidir con {$item}");
                            }                            
                            break;

                        case 'unique':
                            //VALIDANDO SI EL USUARIO INGRESADO ES UNICO
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if ($check->count()) {
                                $this->addError("El usuario <strong>{$value}</strong> ya existe");
                            }                                                     
                            break;
                        
                        default:
                            
                            break;
                    }

                }
            }            

        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    /*-------------------------------*/
    /* AGREGA LOS ERRORES A UN ARRAY */
    /*-------------------------------*/
    private function addError($error){
        $this->_errors[] = $error;
    }

    /*-----------------------------*/
    /* LISTA LOS ERRORES DEL ARRAY */
    /*-----------------------------*/
    public function errors(){
        return $this->_errors;
    }

    /*----------------------------------------------------------*/
    /* DEVUELVE EL VALOS DE LA VARIABLE PASSED SI NO HAY ERRORES*/
    /*----------------------------------------------------------*/
    public function passed(){
        return $this->_passed;
    }
    
}
