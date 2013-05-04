<?php
class TTimePicker extends CInputWidget{
	public $overwrite=false;
	//default value that is treated as lack of date.
	public $default='0000-00-00 00:00:00';
	// options specific to timepicker
	// custom user options
	public $options=array();
	// default options
	public $defaultOptions = array(
		'format'=>'yyyy-MM-dd hh:mm:ss',
	);

	public function run(){
		$cs = Yii::app()->getClientScript();
		$assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
		$cs->registerCssFile($assets . '/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
		$cs->registerScriptFile($assets . '/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');

		$id;
		if($this->hasModel()){
			list($name, $id) = $this->resolveNameId();

			
			$htmlOptions=$this->htmlOptions;
			$value=CHtml::resolveValue($this->model, $this->attribute);
			if($this->default===$value){
				$htmlOptions['value']='';
			}

			echo '<div id="'.$id.'_datetimepicker" class="input-append date">';
			echo CHtml::activeTextField($this->model, $this->attribute, $htmlOptions);
			echo '<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span></div>';
		}else{
			$id=$this->getId();
			$this->name=$id;
			$defaults=array(
				'id'=>$id,
			);
			$htmlOptions=array_merge($defaults, $this->htmlOptions);
			echo '<div id="'.$id.'_datetimepicker" class="input-append date">';
			echo CHtml::textField($this->name, $this->value, $htmlOptions);
			echo '<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span></div>';
		}

		$joptions=CJavaScript::encode(array_merge($this->defaultOptions, $this->options));
		$jscode='$("#'.$id.'_datetimepicker").datetimepicker('.$joptions.');';

		if($this->overwrite){
			$jscode.='$("#'.$id.'_datetimepicker")'.
				'.data("datetimepicker")'.
					'.setLocalDate(new Date());';
		}
		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, $jscode);
	}
}