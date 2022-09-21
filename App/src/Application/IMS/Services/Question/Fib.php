<?php 

namespace IMSExport\Application\IMS\Services\Question;

use IMSExport\Application\Entities\Exam;
use IMSExport\Application\Entities\Group;
use IMSexport\Application\XMLGenerator\Generator;
use IMSExport\Helpers\Collection;

class Fib extends BaseQuestion
{
	public function export()
    {

	   	try {
            $self = $this;
            $this->createItem(function () use ( $self ) {
                $self
                	->tagParent
                	(
	                	'presentation',
	                	function () use ( $self )
	                	{
	                		$self
	                			->tagParent(
	                				'flow', 
	                				function () use ( $self )
	                				{	
	                					$self
		                					->tagParent
		                					(
		                						'flow', 
		                						function () use ( $self )
		                						{
		                							if($self->getType()==5)
						                				$self->questionsText();
						                			else 
						                				$self->questionsTextColumn();
		                						}
		                					);
			                			
	                				}
	                			);
	                	}
	                )
	                ->tagParent
	                (
	                	"resprocessing",
	                	function () use ( $self )
	                	{
	                		$self
		                		->tagParent
		                		(
		                			"outcomes",
				                	function () use ( $self )
				                	{
				                		$self->decvar
				                		(
				                			"FIBSCORE_{$this->data['idPreguntas']}",
				                			"Integer"
				                		);
				                	}
		                		)
	                			->tagParent
	                			(
		                			"respcondition",
				                	function () use ( $self )
				                	{
				                		$self
				                			->tagParent
				                			(
				                				"conditionvar",
							                	function () use ( $self )
							                	{
						                			$self->answersCorrect();
							                	}
				                			)
				                			->setvar("Set", 1);

				                		if($self->data['retroalimentacion']) {

				                			$self
				                			->displayfeedback("Response", "Correct");

				                		}

				                	}
		                		);
	                	}
	                );

				$self->notVarEqual();


                if($self->data['retroalimentacion']) 
                {
	                $self->itemfeedback
	                (
	                	"Correct",
	                	function () use ( $self )
	                	{
	                		$self
				                ->tagParent(
				                	"flow_mat", 
				                	function () use ( $self )
	                				{
	                					$self->createMaterial(
	                						$self->data['retroalimentacion']
	                					);
	                				}
	                			);
	                	}
	                );
	            }

	            if($self->data['retroalimentacionRespIncorrecta']) 
                {
	                $self->itemfeedback
	                (
	                	"InCorrect",
	                	function () use ( $self )
	                	{
	                		$self
				                ->tagParent(
				                	"flow_mat", 
				                	function () use ( $self )
	                				{
	                					$self->createMaterial(
	                						$self->data['retroalimentacionRespIncorrecta']
	                					);
	                				}
	                			);
	                	}
	                );
	            }
            });
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function questionsText() 
    {
    	$self = $this;

    	preg_match_all('/\{([^}]*)\}/s', $self->getText(), $matches);
    	$countRF = count($matches[1]);
    	$aux = 0;

    	if (isset($matches[1])) {
            $matches = $matches[1];

            $t = preg_replace_callback
			(
				'/\{([^}]*)\}/s',
				function ($coincidencias) {
					return "¬__*__¬";
		    	}, 
		    	$this->getText()
			);

			$porciones = explode("¬__*__¬", $t);

			foreach ($porciones as $key => $value) {

				$ident = "FIB_{$this->data['idPreguntas']}_{$aux}";

				$self
					->createMaterial($value, 1);

				if($aux < $countRF)
					$self->response_str($ident, "Single", strlen($matches[$aux]));

				$aux++;
			}
            
        }    	
    }

    public function questionsTextColumn() {

		$ident = "FIB_{$this->data['idPreguntas']}";

		$this
			->createMaterial($this->getText(), 1)
			->response_str($ident, "Single", null);

    }

    public function notVarEqual() 
    { 
    	$self = $this;
    	preg_match_all('/\{([^}]*)\}/s', $self->getText(), $matches);

        if (isset($matches[1])) {
            $matches = $matches[1];
            foreach ($matches as $key => $value) {
            	$ident = "FIB_{$this->data['idPreguntas']}_{$key}";
       			$self->notResprocessing($ident, $value);
       		}
        }    	
    }

    public function notResprocessing ($ident, $value) 
    {
    	$self = $this;
    	$self
	    	->tagParent
	        (
	        	"resprocessing",
	        	function () use ( $ident, $value, $self )
	        	{
	        			$self
	        			->tagParent
	        			(
	            			"respcondition",
		                	function () use ( $ident, $value, $self )
		                	{
		                		$self
		                			->tagParent
		                			(
		                				"conditionvar",
					                	function () use ( $ident, $value, $self )
					                	{
					                		$self
												->tagParent
												(
													"not",
													function () use ( $ident, $value, $self )
													{
														$self->varequal($ident, $value);
													}
												);
					                	}
		                			);

		                		if($self->data['retroalimentacionRespIncorrecta']) {

		                			$self
		                				->displayfeedback("Response", "InCorrect");

		                		}

		                	}
	            		);
	        	}
	        );
    }

    public function answersCorrect() 
    {

    	$self = $this;

    	if($self->getType()==5) {

    		preg_match_all('/\{([^}]*)\}/s', $self->getText(), $matches);

	        if (isset($matches[1])) {
	            $matches = $matches[1];
	            foreach ($matches as $key => $value) {
	       			$ident = "FIB_{$this->data['idPreguntas']}_{$key}";
	       			$self->varequal(
	       				$ident, 
	       				$value
	       			);
	       		}

	        }

    	} else {
    		$answerRows = $this->answerCollection
						->toArray();

			$not = '';
			$self = $this; 
			if($answerRows && count($answerRows))
			{	
				foreach ($answerRows as $key => $value) {
					$id = $value['idRespuesta'];

					if($value['Correcta']==1){
						$self->varequal("FIB_{$self->data['idPreguntas']}", $value['Respuesta']);
					} else {

						$self
							->tagParent
			                		(
			                			"not",
					                	function () use ( $self, $id)
					                	{
					                		$self->varequal("FIB_{$self->data['idPreguntas']}", $value['Respuesta']);
					                	}
					                );
					}	

				}
			}
    	}
    	
    }
    
}