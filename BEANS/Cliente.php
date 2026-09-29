<?php 
class Cliente
{
	public $codCli;
	public $nomCli;
        public $correo;
        public $telefono;
	public $pas;
    public $Dir;

function __construct ($codCli, $nomCli, $correo, $telefono, $pas,$Dir) {

     $this->codCli = $codCli ;
     $this->nomCli = $nomCli ;
     $this->correo = $correo ;
     $this->telefono = $telefono ;
     $this->pas = $pas ;
    $this->Dir = $Dir ;

}
 
public function _setCodCli($codCli){
  $this->codCli = $codCli;
 }

public function _setNomCli($nomCli){
  $this->nomCli = $nomCli;
 }

public function _setCorreo($correo){
  $this->correo = $correo;
 }

public function _setTelefono($telefono){
  $this->telefono = $telefono;
 }

 public function _setPas($pas){
  $this->pas = $pas;
 }


    public function _setDir($Dir){
        $this->$Dir = $Dir;
    }



    public function getCodCli() {
 	return $this->codCli;
 }

public function getNomCli() {
 	return $this->nomCli;
 }

public function getCorreo() {
 	return $this->correo;
 }

public function getTelefono() {
  return $this->telefono;
 }

public function getPas() {
 	return $this->pas;
 }

    public function getDir() {
        return $this->Dir;
    }

 
}
