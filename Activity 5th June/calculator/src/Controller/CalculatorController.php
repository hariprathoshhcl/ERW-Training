<?php

namespace Drupal\calculator\Controller;
use Drupal\Core\Controller\ControllerBase;
  
  	 Interface interfacecalc{
		 public function add();
		 public function subract();
		 public function multiply();
		 public function divide();
	 }


class CalculatorController extends ControllerBase implements interfacecalc{

			public function add(){ 
				return "Addition<br>";
			}
			
			public function subract(){
				return "Subraction<br>";
			}
			
			public function multiply(){
				return "Multiplication <br>";
			}
			
			public function divide(){
				return "Divide <br>";
			}
			
			
			
			public function calcAllFun(){
				 
				 $data = $this->add();
				 $data .= $this->subract();
				 $data .= $this->multiply();
				 $data .= $this->divide();
				 
				   $funval = [
						  '#markup' => $this->t($data),
						];
					      
					return $funval;

		}

}