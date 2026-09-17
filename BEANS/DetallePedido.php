<?php
class DetallePedido {
    
    public $num;
    public $codpro;
    public $can;
    public $color;
    public $talla;
    

    
    function __construct($num, $codpro, $can,$color,$talla) {
        $this->num = $num;
        $this->codpro = $codpro;
        $this->can = $can;
        $this->color = $color;
        $this->talla = $talla;
       
    }

    function getNum() {
        return $this->num;
    }

    function getCodpro() {
        return $this->codpro;
    }

    function getCan() {
        return $this->can;
    }

    function getColor() {
        return $this->color;
    }

    function getTalla() {
        return $this->talla;
    }



    function setNum($num) {
        $this->num = $num;
    }

    function setCodpro($codpro) {
        $this->codpro = $codpro;
    }

    function setCan($can) {
        $this->can = $can;
    }

    function setColor($color) {
        $this->color = $color;
    }

    function setTalla($talla) {
        $this->talla = $talla;
    }



}