<?php 
class Pedido {
 	
 	public $num;
 	public $codcli;
 	public $fecha;
        
         function __construct($num, $codcli, $fecha) {
             $this->num = $num;
             $this->codcli = $codcli;
             $this->fecha = $fecha;
         }

         function getNum() {
             return $this->num;
         }

         function getCodcli() {
             return $this->codcli;
         }

         function getFecha() {
             return $this->fecha;
         }

         function setNum($num) {
             $this->num = $num;
         }

         function setCodcli($codcli) {
             $this->codcli = $codcli;
         }

         function setFecha($fecha) {
             $this->fecha = $fecha;
         }


}

