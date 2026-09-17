<?php
class Producto {

	public $cod;
	public $des;
	public $pre;
	public $stock;
	public $estado;
	public $detalle;
	public $imagen;
	public $envio;

	
		
		function __construct($cod, $des, $pre, $stock, $estado, $detalle, $imagen, $envio){
			
			$this->cod = $cod;
			$this->des = $des;
			$this->pre = $pre;
			$this->stock = $stock;
			$this->estado = $estado;
			$this->detalle = $detalle;
			$this->imagen = $imagen;
			$this->envio = $envio;


		}

        function getCod(){
 	return $this->cod;
 }

function getDes(){
 	return $this->des;
 }

function getPre(){
 	return $this->pre;
 }

 function getStock(){
 	return $this->stock;
 }

function getEstado(){
 	return $this->estado;
 }

 function getDetalle(){
 	return $this->detalle;
 }

 function getImagen(){
 	return $this->imagen;
 }

 function getEnvio(){
 	return $this->envio;
 }

 function setCod($cod){
  $this->cod = $cod;
 }

function setDes($des){
  $this->des = $des;
 }

function setPre($pre){
  $this->pre = $pre;
 }

 function setStock($stock){
  $this->stock = $stock ;
 }

function setEstado($estado){
  $this->estado = $estado ;
 }

 function setDetalle($detalle){
  $this->detalle = $detalle;
 }

 function setImagen($imagen){
  $this->imagen = $imagen ;
 }

  function setEnvio($envio){
  $this->envio = $envio ;
 }

	}


	

