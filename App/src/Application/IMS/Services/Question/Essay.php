<?php 

namespace IMSExport\Application\IMS\Services\Question;

use IMSExport\Application\Entities\Exam;
use IMSExport\Application\Entities\Group;
use IMSexport\Application\XMLGenerator\Generator;
use IMSExport\Helpers\Collection;

class Essay extends BaseQuestion
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
	                					->createMaterial($self->getText(), 1);
	                				}
	                			);
	                	}
	                )
	                ->itemfeedback
	                (
	                	"solution",
	                	function () use ( $self )
	                	{
	                		$self
				                ->tagParent(
				                	"solution", 
				                	function () use ( $self )
	                				{
	                					$self
							                ->tagParent(
							                	"solutionmaterial", 
							                	function () use ( $self )
				                				{
				                					$self->answersCorrect();
				                				}
				                			);
	                				}
	                			);
	                	}
	                );
            });
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function answersCorrect() 
    {

    	$answerRows = $this->answerCollection->toArray();
		$self = $this; 
		if($answerRows && count($answerRows))
		{	
			foreach ($answerRows as $key => $value) {
				
				$self->createMaterial($value['Respuesta']);

			}

		}
    	
    }
    
}