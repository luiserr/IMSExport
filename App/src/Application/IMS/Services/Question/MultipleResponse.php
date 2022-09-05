<?php 

namespace IMSExport\Application\IMS\Services\Question;

use IMSExport\Application\Entities\Exam;
use IMSExport\Application\Entities\Group;
use IMSexport\Application\XMLGenerator\Generator;
use IMSExport\Helpers\Collection;

class MultipleResponse extends BaseQuestion
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
	                					->createMaterial($self->getText(), 1)
			                			->createRenderChoice('single', function () use ( $self ) {
			                				$self
			                					->createAnswerChoice();
			                			});
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
				                			"SCORE",
				                			"Decimal"
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
            });
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function answersCorrect() {

		$answerRows = $this->answerCollection
						->toArray();

		$not = '';
		$self = $this; 
		if($answerRows && count($answerRows))
		{	
			foreach ($answerRows as $key => $value) {
				$id = $value['idRespuesta'];

				if($value['Correcta']==1){
					$self->varequal("response_{$self->data['idPreguntas']}", $id);
				} else {

					$self
						->tagParent
		                		(
		                			"not",
				                	function () use ( $self, $id)
				                	{
				                		$self->varequal("response_{$self->data['idPreguntas']}", $id);
				                	}
				                );
				}	

			}
		}	
    	
    }
}