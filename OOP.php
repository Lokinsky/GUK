<?php
/**
 * Класс, описывающий работу с таблицей objects, расположенную в базе данных 'db'.
 * @author Lokinsky <wf.pbvova2030@icloud.com>
 * @version 1.0
 */
class Item
{
	/**
	 * Счетчик записей в таблице.
	 * @see __set()
	 * @see __get()
	 * @access private
	 * @var integer
	 */
	private $id = 0;
	/**
	 * Название записи.
	 * @see __set()
	 * @see __get()
	 * @access private
	 * @var string
	 */
	private $name = "";
	/**
	 * Статус записи.
	 * @see __set()
	 * @see __get()
	 * @access private
	 * @var string
	 */
	private $status = "";
	/**
	 * Флаг изменения объекта извне.
	 * @see __set()
	 * @access private
	 * @var bool
	 */
	private $changed = false;

	/**
	 * Конструктор объекта Item.
	 * @access public
	 * @param $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
		$this->db->setTable = "objects";
		if(!$this->init())
			echo "Initialized failed..";
	}

	/**
	 * Функция инициализации объекта.
	 * @todo Написать реализацию работы с бд.
	 * @access private
	 * @return bool
	 */
	private function init()
	{
		if(!$this->name && !$this->status)
		{
			//$result = $this->db->select($this->id);
			$result = array(
				"name"      => "Box",
				"status"      => "created",
				"changed"   => false
			);
			if(!empty($result))
			{
				$this->name = $result["name"];
				$this->status = $result["status"];
				return true;
			}
			return false;
		}
	}

	/**
	 * Магическая функция.
	 * Устанавливает значения в соответствии с ранее указанным типом данных.
	 * Примечание: $id менять нельзя.
	 * @example item->status = "foo:bar"
	 * @param $property
	 * @param $value
	 */
	public function __set($property, $value)
	{
		if (property_exists($this, $property) && $property != "id" && $value) {
			if(gettype($value) == gettype($this->$property)){
				$this->$property = $value;
				$this->changed = true;
			}
			else
				echo "Wrong type while assigment the variable.\n";
		}else{
			echo sprintf("Bad property! \nThis property '%s' doesn`t exist or can`t be changed.\n",$property);
		}
	}

	/**
	 * Магическая функция.
	 * Возвращает свойства объекта.
	 * @example item->status
	 * @param $property
	 * @return mixed
	 */
	public function __get($property)
	{
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

	/**
	 * Функция сохранения свойств объекта.
	 * Примечание: сохранение происходит при наличии изменения извне.
	 * @todo Написать реализацию работы с бд.
	 * @return false|integer
	 */
	public function save(){
		if($this->changed){
			$this->db->update(array([
				$this->name,
				$this->status
			]));
			return $this->rowId;
		}else{
			echo "Data is not changed yet.\n";
			return false;
		}
	}

}